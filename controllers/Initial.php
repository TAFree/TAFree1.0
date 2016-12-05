<?php 
namespace TAFree\controllers;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

use TAFree\utils\DBOperator;

require_once('../composers/Autoloader.php');
require_once('../routes/SetRouter.php');

class Initial {
	
	public function __construct() {
			
		$trigger = new DBOperator();
		$trigger->initial();
	}

}	

$router->run();

?>
