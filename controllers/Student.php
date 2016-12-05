<?php
namespace TAFree\controllers;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

use TAFree\classes\Handler;
use TAFree\utils\DBOperator;

require_once('../composers/Autoloader.php');

class Student extends Handler {

	public function setSuccessor($nextService) {
		$this->successor = $nextService;
	}
	public function handleRequest ($request) {
		$this->handle = 'student';
		if ($request->getService() === $this->handle) {
			
			$trigger = new DBOperator();
			$trigger->queryStudent();
			
		}
		else if ($this->successor !== null) {
			$this->successor->handleRequest($request);
		}
	}

}

?>
