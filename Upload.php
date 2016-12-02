<?php 

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('SetRouter.php');

function __autoload($class_name) {	
	include_once($class_name . '.php');
}

class Upload {

	public function __construct() {
			
		$trigger = new DBOperator();

		if (isset($_POST['delete'])) {
			$trigger->reduce();
		}
		else {
			$trigger->upload();
		}
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

