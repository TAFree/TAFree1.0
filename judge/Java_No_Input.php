<?php
/**
 	This is a judge script for verifying lab assignment 
	of NTU Civil Engineering Computer Programing with no testdata.
	You can copy, redistribute, or modify it freely.
	
	Tips:
	It is not necessary to use file already provided.
	Any related file can be uploaded via testdata field.
	Then how to apply specific file uploaded to ./problem/testdata/[item]/[subitem] 
	completely depends on by how the judge file is defined.
 */

// Error report mechanism of this script
ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);
 	

// Auto load class definition file that this script will be using.
function __autoload($class_name) {
	include_once($class_name . '.php');
}

class Java_No_Input {

	private $stu_account;
	private $item;
	private $subitem;
	private $dir_name;
	private $status;
	private $standard_run_pid;
	private $student_run_pid;
	private $student_sources = array();
	private $solution_sources = array();

	private $hookup;

	public function __construct () {
		
		// Arguments: student account, item, subitem
		$this->stu_account = $_SERVER['argv'][1];
		$this->item = $_SERVER['argv'][2];
		$this->subitem = $_SERVER['argv'][3];

		try {
			// Connect to MySQL database TAFreeDB
			$this->hookup = UniversalConnect::doConnect();						
			
			// Create directory to put source codes temporarily
			$this->createDir();
			
			// Fetch student and solution source from table [item]_[subitem]
			$this->fetchSource();
			
			// Start judge
			$this->startJudge();
			/*

			// Remove directory
			$this->removeDir();

			// Configure result that will response to client side
			$this->configureView();

			// Show result
			echo $this->result;
*/
			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}

	}

	public function createDir () {
		$this->dir_name = uniqid(time(), true);
		mkdir('./process/' . $this->dir_name);
		mkdir('./process/' . $this->dir_name . '/student');
		mkdir('./process/' . $this->dir_name . '/solution');
	}

	public function removeDir () {
		system('rm -rf ' . $this->dir_name, $retval);
		if ($retval !== 0 ) {
			new Viewer('Msg', 'Directory can not be removed...');
		}
	}
	
	public function fetchSource () {
		$stmt = $this->hookup->prepare('SELECT classname, original_source, ' . $this->stu_account . ' FROM ' . $this->item . '_' . $this->subitem);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			
			$student = fopen('./process/' . $this->dir_name . '/student/' . $row['classname'], 'w');
			fwrite($student, $row[$this->stu_account]);
			fclose($student);
			
			$solution = fopen('./process/' . $this->dir_name . '/solution/' . $row['classname'], 'w');
			fwrite($solution, $row['original_source']);
			fclose($solution);

		}
	}
	
	public function startJudge () {
	
		// Solution and student directory that source is inside
		$solution_dir = './process/' . $this->dir_name . '/solution';
		$student_dir = './process/' . $this->dir_name . '/student';

		// Compile source of both solution and student
		$solution_CE = $this->compile($solution_dir);
		if (!empty($solution_CE)) {
			new Viewer('Msg', 'Solution has compiler error: ' . '<br>' . $solution_CE);
			exit();
		}
		$student_CE = $this->compile($student_dir);
		if (!empty($student_CE)) {
			new Viewer('Msg', 'Your source code has compiler error: ' . '<br>' . $student_CE);
			$this->status = 'CE';
			// Update judge status as 'CE'
			$this->updateStatus();
		}

	}

	public function compile ($dir) {
		// Configure descriptor array
		$desc = array (
				0 => array ('pipe', 'r'), // STDIN for process
				1 => array ('pipe', 'w'), // STDOUT for process
				2 => array ('pipe', 'w') // STDERR for process
		);

		// Configure compilation command
		$cmd = 'exec javac -d ' . $dir . ' ';
		$source = glob($dir . '/*');
		foreach ($source as $key => $value) {
			$cmd .= $value . ' ';
		}

		// Create compilation process
		$process = proc_open($cmd, $desc, $pipes);
		
		// Close STDIN pipe
		fclose($pipes[0]);
		
		// Get output of STDERR pipe
		$error = stream_get_contents($pipes[2]);
		
		// Close STDOUT and STDERR pipe
		fclose($pipes[1]);
		fclose($pipes[2]);
		
		// Close process
		proc_close($process);
		
		return $error;
	}

	public function updateStatus () {
		$stmt = $this->hookup->prepare('UPDATE ' . $this->item . ' SET ' . $this->stu_account . '=\'' . $this->status . '\' WHERE subitem=\'' . $this->subitem . '\'');
		$stmt->execute();
	}

}

$judger = new Java_No_Input();

?>
