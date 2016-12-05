<?php 
namespace TAFree\controllers;

use TAFree\utils\DBOperator;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');
require_once('../routes/SetRouter.php');

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

$router->run();

?>

