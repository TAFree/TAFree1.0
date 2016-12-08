<?php 
namespace TAFree\controllers;

use TAFree\utils\DBOperator;
use TAFree\routes\SessionManager;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Handout {
	
	public function __construct() {
			
		$trigger = new DBOperator();
		$trigger->handout();

		// Clear key_to_assign session variable
		SessionManager::deleteParameter('key_to_assign');
	}

}

require_once('../routes/Dispatcher.php');

?>

