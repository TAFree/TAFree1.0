<?php
namespace TAFree\controllers;

use TAFree\utils\Viewer;
use TAFree\database\UniversalConnect;
use TAFree\routes\SessionManager;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class JudgeAdapter {
	
	private $item;
	private $subitem;
	private $stu_account;
	private $judge_script;
	private $judge_ext;
	private $judge_cmd;
	private $safe;
	private $result;

	private $hookup;
	
	public function __construct () {
		
		// Get item, subitem, stu_account
		$this->item = SessionManager::getParameter('item');
		$this->subitem = SessionManager::getParameter('subitem');
		$this->stu_account = SessionManager::getParameter('account');

	
		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			// Get safe
			$stmt = $this->hookup->prepare('SELECT safe FROM ' . $this->item . ' WHERE subitem=\'' . $this->subitem . '\'');
			$stmt->execute();
			$row = $stmt->fetch(\PDO::FETCH_ASSOC);
			$this->safe = $row['safe'];

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
				
				$this->hookup = null;

				// Start external judge process and get its standard output as view
				$desc = array (
					0 => array ('pipe', 'r'),
					1 => array ('pipe', 'w'),
					2 => array ('pipe', 'w')
				);
				$cmd = $this->judge_cmd . ' ' . '../problem/judge/' . $this->item . '/' . $this->subitem . '/' . $this->judge_script . ' ' . $this->stu_account . ' ' . $this->item . ' ' . $this->subitem;

				$process = proc_open($cmd, $desc, $pipes);
				fclose($pipes[0]);
				$this->result = stream_get_contents($pipes[1]);	
				$error_output = stream_get_contents($pipes[2]);	
				fclose($pipes[1]);
				fclose($pipes[2]);
				proc_close($process);
				
				if (!empty($error_output)) {
					new Viewer('Msg', 'Judge process error...' . '<br>' . $error_output);
					exit();
				}
				else {
					new Viewer('Result', $this->result);
					exit();
				}
			}
			else if ($this->safe === 'isolate') { // Isolate judge process in isolate mode
				
				// Update judge status as pending
				$stmt = $this->hookup->prepare('UPDATE ' . $this->item . ' SET ' . $this->stu_account . '=\'Pending\' WHERE subitem=\'' . $this->subitem . '\'');
				$stmt->execute();
			
				// Output pending view
				new Viewer('Pending');
			
			        // Poll database during judge status is pending	
				for ($i = 0; $i < 5; $i += 1) {
					$stmt_judge = $this->hookup->prepare('SELECT ' . $this->stu_account . ' FROM ' . $this->item . ' WHERE subitem=\'' . $this->subitem . '\'');	
					$stmt_judge->execute();
					$row_judge = $stmt_judge->fetch(\PDO::FETCH_ASSOC);
					
					if ($row_judge[$this->stu_account] !== 'Pending') { // Return view
						$stmt_result = $this->hookkup->prepare('SELECT view');
						$stmt_result->execute();
						$row_result = $stmt_result->fetch(\PDO::FETCH_ASSOC);
						$this->result = $row_result['view'];
						
						new Viewer('Result', $this->result);
					
						$this->hookup = null;
						exit();			
					
					}
					sleep(1);
				}
				
				// Judge process exceeding time is regarded as system error
				$stmt = $this->hookup->prepare('UPDATE ' . $this->item . ' SET ' . $this->stu_account . '=\'SE\' WHERE subitem=\'' . $this->subitem . '\'');
				$stmt->execute();
				
				new Viewer('Msg', 'Judge process exceeded time. Please inform administer ! ');
				
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

