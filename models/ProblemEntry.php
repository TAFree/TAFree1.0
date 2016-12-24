<?php
namespace TAFree\models;

use TAFree\classes\IStrategy;
use TAFree\utils\Viewer;
use TAFree\database\UniversalConnect;

require_once('../composers/Autoloader.php');

class ProblemEntry implements IStrategy {
	
	private $item;
	private $subitem;
	private $hint;
	private $describe;
	private $judge;
	private $safe;
	private $solution_filenames = array();
	private $solution_contents = array();
	private $testdata_filenames = array();
	private $testdata_contents = array();

	private $hookup;
	
	public function algorithm () {
		
		// Get item, subitem, judge, safe
		$this->item = $_POST['item'];
		$this->subitem = $_POST['subitem'];
		$this->judge = $_POST['judge'];
		if (isset($_POST['safe'])) {
			$this->safe = $_POST['safe'];
		}
		else {
			$this->safe = 'free';
		}

		// Get hint
		if (!empty($_POST['hint'])) {
			$this->hint = $_POST['hint'];
		}	
		else {			
			new Viewer ('Msg', 'Do not leave empty hint field...' . '<br>');
			exit();
		}

		// Get solution
		$solution_filenames = $_POST['solution_filename'];
		$solution_contents = $_POST['solution_content'];
		// i = 0 is hidden row
		for ($i = 1; $i < count($solution_filenames); $i += 1) {
			if (!empty($solution_filenames[$i]) && !empty($solution_contents[$i])) {
				$this->solution_filenames[$i - 1] = $solution_filenames[$i];
				$this->solution_contents[$i - 1] = $solution_contents[$i];
			}
			else {			
				new Viewer ('Msg', 'Do not leave empty solution fields...' . '<br>');
				exit();
			}
		}
		
		// Get testdata
		$testdata_filenames = $_POST['testdata_filename'];
		$testdata_contents = $_POST['testdata_content'];
		// i = 0 is hidden row
		for ($i = 1; $i < count($testdata_filenames); $i += 1) {
			if (!empty($testdata_filenames[$i]) && !empty($testdata_contents[$i])) {
				$this->testdata_filenames[$i - 1] = $testdata_filenames[$i];
				$this->testdata_contents[$i - 1] = $testdata_contents[$i];
			}
			else {			
				new Viewer ('Msg', 'Do not leave empty testdata fields...' . '<br>');
				exit();
			}
		}
	
		try {
			// Connect to database
			
			$this->hookup = UniversalConnect::doConnect();	
		
			// Manipulate files
			
			// Fetch judge file 
			if ($this->judge === 'other') {
				// Upload judge file if it does not exist on machine
				if (!$this->isSupport()) {
					new Viewer ('Msg', 'TAFree has not supported judge script file uploaded. <a class=\'DOC_A\' href=\'../views/Fac_expansion.php\'>You can expand it</a>.' . '<br>');
					exit();
				}
				$this-> uploadJudge();
			}
			else {
				// Clone judge file if it is already on machine
				$this->cloneJudge();
			}
			
			// Clear and upload description files
			$this->uploadDescription();

			// Clear and upload testdata files
			$this->uploadTestdata();
			
			// Manipulate tables					
			
			// Update item table
			$this->updateItem();
	
			// Clear subitem table
			$this->clearSubitem();

			// Insert subitem table
			$this->insertSubitem();

			$this->hookup = null;
			
			// Modify solution for student writing
			new Viewer('Modify', array('item' => $this->item, 'subitem' => $this->subitem));
	
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}	
	
	}

	public function uploadDescription () {	
		
		// Clear previous files
		system('rm -rf ' . '../problem/description/' . $this->item . '/' . $this->subitem . '/*', $retval);
		if ($retval !== 0) {
			new Viewer ('Msg', 'Can not remove ' . '../problem/description/' . $this->item . '/' . $this->subitem . '/*');
			exit();
		}
		
		// Upload to ../problem/description/[item]/[subitem] directory 	
		$tmpname = $_FILES['description']['tmp_name'];
		$basename = basename($_FILES['description']['name']);				
		if(!move_uploaded_file ($tmpname, '../problem/description/' . '/' . $this->item . '/' . $this->subitem . '/' . $basename)) {
			new Viewer ('Msg', 'Description file is not uploaded...');
			exit();
		}
		
		// Update description
		$this->describe = $basename;
	}
		
	public function uploadJudge () {
		
		// Clear previous files
		system('rm -rf ' . '../problem/judge/' . $this->item . '/' . $this->subitem . '/*', $retval);
		if ($retval !== 0) {
			new Viewer ('Msg', 'Can not remove ' . '../problem/judge/' . $this->item . '/' . $this->subitem . '/*');
			exit();
		}
		
		// Upload to ../problem/judge/[item]/[subitem] directory 
		$tmpname = $_FILES['judge_file']['tmp_name'];
		$basename = date('Ymd') . '_' . basename($_FILES['judge_file']['name']);				
		if (!move_uploaded_file ($tmpname, '../problem/judge/' . $this->item .'/'. $this->subitem . '/' . $basename)) {
			new Viewer ('Msg', 'Judge script is not uploaded...');
			exit();
		}
	
		// Update judge 
		$this->judge = $basename;
	}
	
	public function cloneJudge () {
		
		// Clear previous files
		system('rm -rf ' . '../problem/judge/' . $this->item . '/' . $this->subitem . '/*', $retval);
		if ($retval !== 0) {
			new Viewer ('Msg', 'Can not remove ' . '../problem/judge/' . $this->item . '/' . $this->subitem . '/*');
			exit();
		}
			
		// Copy to ../problem/judge/[item]/[subitem] directory 
		if (!copy ('../judge/' . $this->judge, '../problem/judge/' . $this->item . '/' . $this->subitem . '/' . $this->judge)) {
			new Viewer ('Msg', 'Judge script copy failed...');
			exit();
		}
	}
	
	public function isSupport () {
		$filename = basename($_FILES['judge_file']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		$stmt = $this->hookup->prepare('SELECT cmd FROM support WHERE ext=\'' . $ext . '\'');
		$stmt->execute();
		if ($stmt->rowCount() === 0) {
			return false;
		}
		else {
			return true;
		}
	}
	
	public function uploadTestdata () {
		
		// Clear previous files
		system('rm -rf ' . '../problem/testdata/' . $this->item . '/' . $this->subitem . '/*', $retval);
		if ($retval !== 0) {
			new Viewer ('Msg', 'Can not remove ' . '../problem/testdata/' . $this->item . '/' . $this->subitem . '/*');
			exit();
		}
		
		// Upload to ../problem/testdata/[item]/[subitem] directory 	
		for ($i = 0; $i < count($this->testdata_filenames); $i += 1) {
			$testdata = fopen('../problem/testdata/' . $this->item . '/' . $this->subitem . '/' . $this->testdata_filenames[$i], 'w');
			fwrite($testdata, $this->testdata_contents[$i]);
			fclose($testdata); 
		}
	}

	public function updateItem () {
		$describe;
		$hint;
		$judge;
		$safe;
		$stmt = $this->hookup->prepare('UPDATE ' . $this->item . ' SET description=:describe, hint=:hint, judgescript=:judge, safe=:safe WHERE subitem=\'' . $this->subitem . '\'');
		$stmt->bindParam(':describe', $describe);
		$stmt->bindParam(':hint', $hint);
		$stmt->bindParam(':judge', $judge);
		$stmt->bindParam(':safe', $safe);
		$describe = $this->describe;
		$hint = $this->hint;
		$judge = $this->judge;
		$safe = $this->safe;
		$stmt->execute();
	}
	
	public function clearSubitem () {
		$stmt = $this->hookup->prepare('DELETE FROM ' . $this->item . '_' . $this->subitem);
		$stmt->execute();	
	}
	
	public function insertSubitem () {
		$stmt = $this->hookup->prepare('INSERT INTO ' . $this->item . '_' . $this->subitem . ' (main, classname, original_source) VALUES (:main, :classname, :original_source)');
		for ($i = 0; $i < count($this->solution_filenames); $i += 1) {
			$check;
			$stmt->bindParam(':main', $check);
			if ($i === 0) {
				$check = 'V';
			}
			else {
				$check = null;
			}
			$stmt->bindParam(':classname', $this->solution_filenames[$i]);
			$stmt->bindParam(':original_source', $this->solution_contents[$i]);
			$stmt->execute();	
		}
	}

}

?>

