<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');	
}

class AssignControl {
	
	private $unique_key;

	public function __construct() {
		
		$this->unique_key = uniqid($time(), true);

		session_start();
		$_SESSION['key_to_assign'] = $this->unique_key;

		$trigger = new DBOperator();
		$trigger->assignRegistry($this->unique_key);;
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
