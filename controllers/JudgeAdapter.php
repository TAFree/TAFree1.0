<?php
namespace TAFree\controllers;

use TAFree\utils\Viewer;
use TAFree\database\UniversalConnect;
use TAFree\routes\SessionManager;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class JudgeAdapter {
	
	private $id;
	private $submitter;
	private $judger;
	private $stu_account;
	private $stu_name;	
	private $item;
	private $subitem;
	private $safe;
	private $result;
	private $judge_script;
	private $judge_ext;
	private $judge_cmd;

	private $hookup;
	
	public function __construct () {
		
		// Get item, subitem, stu_account, stu_name, ip
		$this->item = SessionManager::getParameter('item');
		$this->subitem = SessionManager::getParameter('subitem');
		$this->stu_account = SessionManager::getParameter('account');
		$this->stu_name = SessionManager::getParameter('nickname');
		$this->submitter = SessionManager::getParameter('ip');
	
		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			// Get safe
			$stmt = $this->hookup->prepare('SELECT safe FROM ' . $this->item . ' WHERE subitem=\'' . $this->subitem . '\'');
			$stmt->execute();
			$row = $stmt->fetch(\PDO::FETCH_ASSOC);
			$this->safe = $row['safe'];

			// Create id & set id as session variable
			$this->id = uniqid();
			SessionManager::getParameter('id', $this->id);

			// Add judge process row in process table
			$stmt = $this->hookup->prepare('INSERT INTO process (id, submitter, student_account, student_name, item, subitem) VALUES (:id, :submitter, :student_account, :student_name, :item, :subitem)');
			$stmt->bindParam(':id', $this->id);
			$stmt->bindParam(':student_account', $this->stu_account);
			$stmt->bindParam(':student_name', $this->stu_name);
			$stmt->bindParam(':submitter', $this->submitter);
			$stmt->bindParam(':item', $this->item);
			$stmt->bindParam(':subitem', $this->subitem);
			$stmt->execute();

			// Update judge status as 'Pending'
			$stmt = $this->hookup->prepare('UPDATE ' . $this->item . ' SET ' . $this->stu_account . '=\'Pending\' WHERE subitem=\'' . $this->subitem . '\'');
			$stmt->execute();

			// Directly execute judge script in free mode
			if ($this->safe === 'free') {
				
				// Get judge_script
				$stmt = $this->hookup->prepare('SELECT judgescript FROM ' . $this->item . ' WHERE subitem=\'' . $this->subitem . '\'');
				$stmt->execute();
				$row = $stmt->fetch(\PDO::FETCH_ASSOC);
				$this->judge_script = $row['judgescript'];
				
				// Get judge_ext
				$this->judge_ext = substr($this->judge_script, strrpos($this->judge_script, '.') + 1);
				
				// Get judge_cmd
				$stmt = $this->hookup->prepare('SELECT cmd FROM support WHERE ext=\'' . $this->judge_ext . '\'');
				$stmt->execute();
				$row = $stmt->fetch(\PDO::FETCH_ASSOC);
				$this->judge_cmd = $row['cmd'];

				// Start external judge process
				$desc = array (
					0 => array ('pipe', 'r'),
					1 => array ('pipe', 'w'),
					2 => array ('pipe', 'w')
				);
				$cmd = $this->judge_cmd . ' ' . '../problem/judge/' . $this->item . '/' . $this->subitem . '/' . $this->judge_script . ' ' . $this->stu_account . ' ' . $this->item . ' ' . $this->subitem . ' ' . $this->id;
				
				$process = proc_open($cmd, $desc, $pipes);
				
				// Close STDIN pipe
				fclose($pipes[0]);
	
				$error_output = stream_get_contents($pipes[2]);	
				
				// Close STDOUT & STDERR pipe
				fclose($pipes[1]);
				fclose($pipes[2]);

				// Close external judge process
				proc_close($process);

				// Output view of judge result
				if (!empty($error_output)) {
					// Output error message if error occurred on external judge process
					new Viewer('Msg', 'Judge process ' . $this->id . ' occurred error: <br>' . $error_output . '<br> Please inform administer ! ');
					
					$this->hookup = null;
					exit();
				}
				else {
					// Fetch view of judge result
					$stmt_result = $this->hookup->prepare('SELECT view FROM process WHERE id=\'' . $this->id . '\'');
					$stmt_result->execute();
					$row_result = $stmt_result->fetch(\PDO::FETCH_ASSOC);
					$this->result = $row_result['view'];
					
					new Viewer('Result', $this->result);
					
					$this->hookup = null;
					exit();
				}
			}
			else if ($this->safe === 'isolate') { // Isolate judge process in isolate mode
				
				// Output pending view
				new Viewer('Pending'); 
			
				$this->hookup = null;
				exit();
			}
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}

}

require_once('../routes/Dispatcher.php');

?>

