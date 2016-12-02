<?php

class JudgeExpansion implements IStrategy {
	
	private $services = array();
	private $ext;
	private $cmd;
	private $judge;

	private $hookup;
	
	public function algorithm () {
		
		// Get services
		$this->services = $_POST['service'];
		
		// Get judge
		if (in_array($this->services, 'plugout')) {
			$this->judge = $_POST['judge'];
		}
		
		// Get ext,  cmd
		if (in_array($this->services, 'plugin')) {
			if (!empty($_POST['ext']) && !empty($_POST['cmd'])) {
				$this->ext = $_POST['ext'];
				$this->cmd = $_POST['cmd'];
			}	
			else {			
				new Viewer ('Msg', 'Do not leave empty file extension or empty executing command field...' . '<br>');
				exit();
			}
		}
		
		try {
			// Connect to database
			
			$this->hookup = UniversalConnect::doConnect();	
		
			// Manipulate file
			
			// Delete judge file that exists on machine if needed
			if ($this->judge !== 'no') {
				$this-> deleteJudge();
			}
			
			// Manipulate table				
			
			// Query, update or insert support table
			if (isset($this->ext) && isset($this->cmd)) {
				$this->addSupport();
			}
		
			$this->hookup = null;

			new Viewer('Msg', 'Successful expansion !');

		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
	
	}
		
	public function deleteJudge () {
		
		// Delete file in ./judge directory 
		if (file_exists ('./judge/' . $this->judge)) {
			unlink('./judge/' . $this->judge);
		}
		else {	
			new Viewer ('Msg', 'Judge script file is not on machine...');
			exit();
		}
	
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

}

?>

