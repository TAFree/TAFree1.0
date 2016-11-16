<?php 

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('SetRouter.php');

function __autoload($class_name) {	
	include_once($class_name . '.php');
}

class Handout {
	
	public function __construct() {
			
		$trigger = new DBOperator();
		$trigger->handout();
	}

}

if (isset($router)) {
	$router->run();
}
else {
	include_once('SetRouter.php');
	$router->run();
}

?>

