<?php
namespace TAFree\controllers;

use TAFree\utils\DBOperator;
use TAFree\utils\Viewer;
use TAFree\database\UniversalConnect;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');
require_once('../routes/SetRouter.php');

class JudgeAdapter {
	
	private $item;
	private $subitem;
	private $stu_account;
	private $judge_script;
	private $judge_ext;
	private $judge_cmd;
	private $result;

	private $hookup;
	
	public function __construct () {
		
		// Get item, subitem, stu_account, stu_account
		$this->item = $_GET['item'];
		$this->subitem = $_GET['subitem'];
		$this->stu_account = $_GET['stu_account'];

	
		try {
			$this->hookup = UniversalConnect::doConnect();						
			
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
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}

}

$router->run();

?>

