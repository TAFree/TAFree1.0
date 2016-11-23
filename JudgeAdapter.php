<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');
}

class JudgeAdapter {
	
	private $item;
	private $subitem;
	private $stu_account;
	private $judge_script;
	private $judge_ext;
	private $judge_cmd;
	private $retval;

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
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->judge_script = $row['judgescript'];

			// Get judge_ext
			$this->judge_ext = substr($this->judge_script, strrpos($this->judge_script, '.') + 1);
			
			// Get judge_cmd
			$stmt = $this->hookup->prepare('SELECT cmd FROM support WHERE ext=\'' . $this->judge_ext . '\'');
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->judge_cmd = $row['cmd'];
			
			$this->hookup = null;

		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
		// Start external judge process and get its standard output as view
		system($this->judge_cmd . ' ' . './problem/judge/' . $this->item . '/' . $this->subitem . '/' . $this->judge_script . ' ' . $this->stu_account, $this->retval);
		
		if ($this->retval !== 0) {
			new Viewer('Msg', 'Judge process error... (status: ' . $retval . ')');
			exit();
		}
		exit();

	}

}

if ($router) {
	$router->run();
}
else {
	include_once('SetRouter.php');
	$router->run();
}

?>
