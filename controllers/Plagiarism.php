<?php 
namespace TAFree\controllers;

use TAFree\utils\DBOperator;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Plagiarism {
	
	public function __construct() {
			
		$trigger = new DBOperator();
		$trigger->detect();
	}

}

require_once('../routes/Dispatcher.php');

?>

