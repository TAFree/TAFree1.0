<?php
namespace TAFree\models;

use TAFree\classes\IStrategy;
use TAFree\utils\Viewer;
use TAFree\database\UniversalConnect;

require_once('../composers/Autoloader.php');

class JudgeExpansion implements IStrategy {
	
	private $services = array();
	private $ext;
	private $cmd;
	private $supports = array();
	private $del_judge;
	private $add_judge;

	private $hookup;
	
	public function algorithm () {
		
		// Get services
		if (!isset($_POST['service'])){
			new Viewer ('Msg', 'Forgot to select plug in / out...' . '<br>');
			exit();
		}		
		else {
			$this->services = $_POST['service'];
		}

		// Get deleted judge and support
		if (in_array('plugout', $this->services)) {
			if (isset($_POST['del_judge'])) {
				$this->del_judge = $_POST['del_judge'];
			}
			if (isset($_POST['support'])) {
				$this->supports = $_POST['support'];
			}
		}
		
		// Get added ext,  cmd, and judge
		if (in_array('plugin', $this->services)) {
			if (isset($_FILES['add_judge'])) {
				$this->add_judge = $_FILES['add_judge'];
			}
			if (!empty($_POST['ext']) && !empty($_POST['cmd'])) {
				$this->ext = $_POST['ext'];
				$this->cmd = $_POST['cmd'];
			}	
		}
		
		try {
			// Connect to database
			
			$this->hookup = UniversalConnect::doConnect();	
		
			// Manipulate file
			
			// Add general judge file
			if (!empty($this->add_judge['tmp_name'])) {
				$this->addJudge();
			}

			// Delete judge file that exists on machine 
			if (isset($this->del_judge) && $this->del_judge !== 'no') {
				$this->deleteJudge();
			}
			
			// Manipulate table				
			
			// Query, update or insert support table
			if (isset($this->ext) && isset($this->cmd)) {
				$this->addSupport();
			}
			
			// Delete support table
			if (isset($this->supports)) {
				$this->deleteSupport();
			}
	
			$this->hookup = null;

			new Viewer('Msg', 'Successful expansion !');

		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
	
	}
		
	public function addJudge () {		
		// Upload to ../tmp directory 
		$tmpname = $this->add_judge['tmp_name'];
		$basename = basename($this->add_judge['name']);	
		$filedir = '../tmp/' . uniqid(time(), true) . '-judge';
		$filename = $filedir . '/' . $basename;
		mkdir($filedir);			
		if (!move_uploaded_file ($tmpname, $filename)) {
			new Viewer ('Msg', 'Judge script is not uploaded...');
			exit();
		}
		else{
			$content = file_get_contents($filename);
			$stmt = $this->hookup->prepare('INSERT INTO general(judgescript, content) VALUES(:judgescript, :content)');
			$stmt->bindParam(':judgescript', $basename);
			$stmt->bindParam(':content', $content);
			$stmt->execute();
			system('rm -rf ' . $filedir);
		}
	
	}

	public function deleteJudge () {
		
		// Delete general judge script in database
		$stmt = $this->hookup->prepare('DELETE FROM general WHERE judgescript=\'' . $this->del_judge . '\'');
		$stmt->execute();
		
	}
	
	public function addSupport () {
		
		$stmt = $this->hookup->prepare('SELECT ext FROM support WHERE ext=\'' . $this->ext . '\'');
		$stmt->execute();
		if ($stmt->rowCount() === 0) {
			// Insert support
			$stmt = $this->hookup->prepare('INSERT INTO support (ext, cmd) VALUES (:ext, :cmd)');
			$stmt->bindParam(':ext', $ext);
			$stmt->bindParam(':cmd', $cmd);
			$ext = $this->ext;
			$cmd = $this->cmd;
			$stmt->execute();
		}
		else {
			// Update support
			$stmt = $this->hookup->prepare('UPDATE support SET cmd=\'' . $this->cmd . '\' WHERE ext=\'' . $this->ext . '\'');
			$stmt->execute();
		
		}
	}
	
	public function deleteSupport () {
		
		foreach($this->supports as $key => $value){
			$stmt = $this->hookup->prepare('DELETE FROM support WHERE ext=\'' . $value . '\'');
			$stmt->execute();
		}

	}

}

?>

