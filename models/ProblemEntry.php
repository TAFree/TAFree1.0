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
			if (!empty($testdata_filenames[$i])) {
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
				// Upload judge file if it does not exist in general table
				if (!$this->isSupport()) {
					new Viewer ('Msg', 'TAFree has not supported judge script file uploaded. <a class=\'DOC_A\' href=\'../views/Fac_expansion.php\'>You can expand it</a>.' . '<br>');
					exit();
				}
				$this-> uploadJudge();
			}
			else {
				// Clone judgescript if it is already in general table
				$this->cloneJudge();
			}
			
			// Clear and upload description files
			$this->uploadDescription();

			// Clear and insert [item]_[subitem]_testdata table
			$this->insertTestdata();
			
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
		
		// Upload to ../tmp directory 
		$tmpname = $_FILES['judge_file']['tmp_name'];
		$uniquename = uniqid(time(), true) . '_' . basename($_FILES['judge_file']['name']);				
		if (!move_uploaded_file ($tmpname, '../tmp/' . $uniquename)) {
			new Viewer ('Msg', 'Judge script is not uploaded...');
			exit();
		}
		
		// Update judge as its filename
		$this->judge = basename($_FILES['judge_file']['name']);

		// Update judgescript and its content
		$content = file_get_contents('../tmp/' . $uniquename);
		$stmt = $this->hookup->prepare('UPDATE ' . $this->item . ' SET judgescript=:judgescript, content=:content WHERE subitem=\'' . $this->subitem . '\'');
		$stmt->bindParam(':judgescript', $this->judge);
		$stmt->bindParam(':content', $content);
		$stmt->execute();

		// Clear judge file
		unlink('../tmp/' . $uniquename);
	
	}
	
	public function cloneJudge () {
		
		// Get content from general table	
		$stmt_content = $this->hookup->prepare('SELECT content FROM general WHERE judgescript=\'' . $this->judge . '\'');
		$stmt_content->execute();
		$row_content = $stmt_content->fetch(\PDO::FETCH_ASSOC);
		$content = $row_content['content'];
		
		// Update judgescript and its content
		$stmt = $this->hookup->prepare('UPDATE ' . $this->item . ' SET judgescript=:judgescript, content=:content WHERE subitem=\'' . $this->subitem . '\'');
		$stmt->bindParam(':judgescript', $this->judge);
		$stmt->bindParam(':content', $content);
		$stmt->execute();
			
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
	
	public function insertTestdata () {
		
		// Clear testdata table
		$stmt = $this->hookup->prepare('DELETE FROM ' . $this->item . '_' . $this->subitem . '_testdata');
		$stmt->execute();	
		
		// Insert testdata table
		$stmt = $this->hookup->prepare('INSERT INTO ' . $this->item . '_' . $this->subitem . '_testdata (testdata, content) VALUES (:testdata, :content)');
		for ($i = 0; $i < count($this->testdata_filenames); $i += 1) {
			$stmt->bindParam(':testdata', $this->testdata_filenames[$i]);
			$stmt->bindParam(':content', $this->testdata_contents[$i]);
			$stmt->execute();	
		}

	}

	public function updateItem () {
		$describe;
		$hint;
		$stmt = $this->hookup->prepare('UPDATE ' . $this->item . ' SET description=:describe, hint=:hint WHERE subitem=\'' . $this->subitem . '\'');
		$stmt->bindParam(':describe', $describe);
		$stmt->bindParam(':hint', $hint);
		$describe = $this->describe;
		$hint = $this->hint;
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

