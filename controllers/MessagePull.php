<?php 
namespace TAFree\controllers;

use TAFree\utils\DBOperator;

require_once('../composers/Autoloader.php');
require_once('../routes/SetRouter.php');

class MessagePull {

	public function __construct() {
		
		$trigger = new DBOperator();
		$trigger->pullMessage();
	}

}

$router->run();

?>

