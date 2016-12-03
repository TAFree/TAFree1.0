<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');
}

class StatusFetch {
	
	private $tester_account;
	private $item;
	private $subitem;
	private $result;

	private $hookup;
	
	public function __construct () {
		
		$this->tester_account = $_POST['tester_account'];
		$this->item = $_POST['item'];
		$this->subitem = $_POST['subitem'];
		
		try {
			$this->hookup = UniversalConnect::doConnect();						

			$stmt = $this->hookup->prepare('SELECT ' . $this->tester_account . ' FROM ' . $this->item . ' WHERE subitem=\'' . $this->subitem . '\'');
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);	
			$this->result = $result[$this->tester_account];
					
			$this->hookup = null;
			
			echo $this->result;
		
		}	
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
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
