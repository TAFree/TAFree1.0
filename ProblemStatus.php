<?php 

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');	
}

class ProblemStatus {
	
	private $item;
	private $item_status;

	public function __construct() {
		
		// Get item, item_status
		$this->item = $_POST['item'];	
		$this->item_status = $_POST['item_status'];	

		$trigger = new DBOperator();
		$trigger->colorProblem($this->item, $this->item_status);
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

