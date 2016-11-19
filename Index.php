<?php 

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');
}

class Index {
	
	private $person;
	
	public function __construct() {
			
		$this->person = Util::fixInput($_POST['person']);
		
		$student = new Student();
		$faculty = new Faculty();
		$administer = new Administer();
		
		$student->setSuccessor($faculty);
		$faculty->setSuccessor($administer);

		$loadup = new Request($this->person);
		$student->handleRequest($loadup);
		
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
