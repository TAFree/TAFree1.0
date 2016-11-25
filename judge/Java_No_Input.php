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
	private $solution_output;
	private $student_output;

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
			
			// Update judge status
			$this->updateStatus();

			// Remove directory
			$this->removeDir();

			$this->hookup = null;
			
			exit();
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}

	}

	public function createDir () {
		$this->dir_name = './process/' . uniqid(time(), true);
		mkdir($this->dir_name);
		mkdir($this->dir_name . '/student');
		mkdir($this->dir_name . '/solution');
	}

	public function removeDir () {
		system('rm -rf ' . $this->dir_name, $retval);
		if ($retval !== 0 ) {
			new Viewer('Msg', 'Directory can not be removed...');
			exit();
		}
	}
	
	public function fetchSource () {
		$stmt = $this->hookup->prepare('SELECT classname, original_source, ' . $this->stu_account . ' FROM ' . $this->item . '_' . $this->subitem);
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			
			$student = fopen($this->dir_name . '/student/' . $row['classname'], 'w');
			fwrite($student, $row[$this->stu_account]);
			fclose($student);
			
			$solution = fopen($this->dir_name . '/solution/' . $row['classname'], 'w');
			fwrite($solution, $row['original_source']);
			fclose($solution);

		}
	}
	
	public function startJudge () {
	
		// Solution and student directory whose source is in
		$solution_dir = $this->dir_name . '/solution';
		$student_dir = $this->dir_name . '/student';

		// Compile source code from both solution and student
		$solution_CE = $this->compile($solution_dir);
		if (!empty($solution_CE)) {
			
			// Configure result that will response to client side
			$error_msg = '<h1>Solution has compiler error</h1>' . '<pre><code>' . $solution_CE . '</code></pre>';
			$this->configureView($error_msg);
		
			// System error
			$this->status = 'SE';
			return;
	
		}
		$student_CE = $this->compile($student_dir);
		if (!empty($student_CE)) {
			
			// Configure result that will response to client side
			$error_msg = '<h1>Your source code has compiler error</h1>' . '<pre><code>' . $student_CE . '</code></pre>';
			$this->configureView($error_msg);
		
			// Compiler error
			$this->status = 'CE';
			return;
	
		}
	
		// Execute source code from both solution and student	
		$solution_RE = $this->execute($solution_dir, 2);
		if (!empty($solution_RE)) {
			
			// Configure result that will response to client side
			$error_msg = '<h1>Solution has runtime error</h1>' . '<pre><code>' . $solution_RE . '</code></pre>';
			$this->configureView($error_msg);
		
			// System error
			$this->status = 'SE';
			return;
	
		}
		$student_RE = $this->execute($student_dir, 2);
		if (!empty($student_RE)) {

			// Configure result that will response to client side
			$error_msg = '<h1>Your source code has runtime error</h1>' . '<pre><code>' . $student_RE . '</code></pre>';
			$this->configureView($error_msg);

			// Runtime error
			$this->status = 'RE';
			return;
	
		}
		
		// Compare output from both solution and student
		$this->solution_output = $this->execute($solution_dir, 1);
		$this->student_output = $this->execute($student_dir, 1);

		// Configure result that will response to client side
		$error_msg = null;
		$this->configureView($error_msg);
		
		$retval = strcmp($this->solution_output, $this->student_output);
		if ($retval === 0) {
			// Accept
			$this->status = 'AC';
			return;
		}
		else {
			// Wrong Answer
			$this->status = 'WA';
			return;
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
		$cmd = 'javac -d ' . $dir . ' ';
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
	
	public function execute ($dir, $pipe_id) {
		// Configure descriptor array
		$desc = array (
				0 => array ('pipe', 'r'), // STDIN for process
				1 => array ('pipe', 'w'), // STDOUT for process
				2 => array ('pipe', 'w') // STDERR for process
		);

		// Configure execution command
		$cmd = 'exec java -classpath ' . $dir . ' ';
		$source = glob($dir . '/*.class');
		foreach ($source as $key => $value) {
			$first_pos = strrpos($value, '/') + 1;
			$last_pos = strrpos($value, '.class');
			$length = $last_pos - $first_pos;
			$classname = substr($value, strrpos($value, '/') + 1, $length);		
			$cmd .= $classname . ' ';
		}
		
		// Create execution process
		$process = proc_open($cmd, $desc, $pipes);
		
		// Get pid of execution process
		$process_status = proc_get_status($process);
		$pid = $process_status['pid'];	

		// Close STDIN pipe
		fclose($pipes[0]);
		
		// Wait seconds
		sleep(1);
		
		// Kill execution process
		posix_kill($pid, SIGTERM);
		
		// Get output of STDOUT or STDERR pipe
		$output = stream_get_contents($pipes[$pipe_id]);
	
		// Close STDOUT and STDERR pipe
		fclose($pipes[1]);
		fclose($pipes[2]);
	
		return $output;
	}

	public function updateStatus () {
		$stmt = $this->hookup->prepare('UPDATE ' . $this->item . ' SET ' . $this->stu_account . '=\'' . $this->status . '\' WHERE subitem=\'' . $this->subitem . '\'');
		$stmt->execute();
	}

	public function configureView ($error_msg) {
		if (!is_null($error_msg)) {
			new Viewer('Result', $error_msg . '<br><a href=\'Stu_chooser.php\' class=\'DOC_A\'>Back</a>');
		}
		else {
			new Viewer('Result', $this->student_output . '<br>' . $this->solution_output . '<br>' . '<a href=\'./Stu_chooser.php\' class=\'DOC_A\'>Back</a>');
		}
	}

}

$judger = new Java_No_Input();

?>
