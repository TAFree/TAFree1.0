<?php

class ProblemEntry implements IStrategy {
	
	private $item;
	private $subitem;
	private $hint;
	private $describe;
	private $judge;
	private $solution_filenames = array();
	private $solution_contents = array();
	private $testdata_filenames = array();
	private $testdata_contents = array();

	private $hookup;
	
	public function algorithm () {
		
		// Get item, subitem, judge
		$this->item = $_POST['item'];
		$this->subitem = $_POST['subitem'];
		$this->judge = $_POST['judge'];

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
	
		// Manipulate files
		try {	
			// Clear and upload description files
			$this->uploadDescription();
			
			// Upload judge file if it does not exist on machine
			if ($this->judge === 'other') {
				$this-> uploadJudge();
			}
			
			// Clear and clone selected judge file from general judge directory 
			$this->cloneJudge();

			// Clear and upload testdata files
			$this->uploadTestdata();
			
		}
		catch (Exception $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}	

		// Manipulate tables
		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			// Update item table
			$this->updateItem();
	
			// Clear subitem table
			$this->clearSubitem();

			// Insert subitem table
			$this->insertSubitem();

			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
		// Modify solution for student writing
		new Viewer('Modify', array('item' => $this->item, 'subitem' => $this->subitem));
	
	}

	public function uploadDescription () {	
		
		// Clear previous files
		$delete_file_msg = system('rm -rf ' . 'problem/description/' . $this->item . '/' . $this->subitem . '/*', $retval);
		if ($retval !== 0) {
			new Viewer ('Msg', $delete_file_msg);
			exit();
		}
		
		// Upload to ./problem/description/[item]/[subitem] directory 	
		$tmpname = $_FILES['description']['tmp_name'];
		$basename = basename($_FILES['description']['name']);				
		if(!move_uploaded_file ($tmpname, './problem/description/' . '/' . $this->item . '/' . $this->subitem . '/' . $basename)) {
			new Viewer ('Msg', 'Description file is not uploaded...');
			exit();
		}
		
		// Update description
		$this->describe = $basename;
	}
		
	public function uploadJudge () {
		
		// Upload to ./judge directory regarded as general judge file that can be reused
		$tmpname = $_FILES['judge_file']['tmp_name'];
		$basename = date('Ymd') . '_' . basename($_FILES['judge_file']['name']);			
		if (!move_uploaded_file ($tmpname, './judge/' . $basename)) {
			new Viewer ('Msg', 'Judge script is not uploaded...');
			exit();
		}
	
		// Update judge 
		$this->judge = $basename;
	}
	
	public function cloneJudge () {
		
		// Clear previous files
		$delete_file_msg = system('rm -rf ' . 'problem/judge/' . $this->item . '/' . $this->subitem . '/*', $retval);
		if ($retval !== 0) {
			new Viewer ('Msg', $delete_file_msg);
			exit();
		}
		
		// Clone judge file from ./judge to ./problem/judge/[item]/[subitem] 
		if (!copy('./judge/' . $this->judge, './problem/judge/' . $this->item . '/' . $this->subitem . '/' . $this->judge)) {
			new Viewer ('Msg', $this->judge . ' copy failed...');
			exit();
		}
	}

	public function uploadTestdata () {
		// Clear previous files
		$delete_file_msg = system('rm -rf ' . 'problem/testdata/' . $this->item . '/' . $this->subitem . '/*', $retval);
		if ($retval !== 0) {
			new Viewer ('Msg', $delete_file_msg);
			exit();
		}
		
		// Upload to ./problem/testdata/[item]/[subitem] directory 	
		for ($i = 0; $i < count($this->testdata_filenames); $i += 1) {
			$testdata = fopen('./problem/testdata/' . $this->item . '/' . $this->subitem . '/' . $this->testdata_filenames[$i], 'w');
			fwrite($testdata, $this->testdata_contents[$i]);
			fclose($testdata); 
		}
	}

	public function updateItem () {
		$stmt = $this->hookup->prepare('UPDATE ' . $this->item . ' SET description=:describe, hint=:hint, judgescript=:judge WHERE subitem=\'' . $this->subitem . '\'');
		$stmt->execute(array(':describe' => $this->describe, ':hint' => $this->hint, ':judge' => $this->judge));	
	}
	
	public function clearSubitem () {
		$stmt = $this->hookup->prepare('DELETE FROM ' . $this->item . '_' . $this->subitem);
		$stmt->execute();	
	}
	
	public function insertSubitem () {
		$stmt = $this->hookup->prepare('INSERT INTO ' . $this->item . '_' . $this->subitem . ' (classname, original_source) VALUES (:classname, :original_source)');
		for ($i = 0; $i < count($this->solution_filenames); $i += 1) {
			$stmt->bindParam(':classname', $this->solution_filenames[$i]);
			$stmt->bindParam(':original_source', $this->solution_contents[$i]);
			$stmt->execute();	
		}
	}

}

?>
