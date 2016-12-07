<?php 
namespace TAFree\controllers;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

use TAFree\utils\Util;
use TAFree\controllers\Student;
use TAFree\controllers\Faculty;
use TAFree\controllers\Administer;
use TAFree\utils\Request;

require_once('../composers/Autoloader.php');

class Index {
	
	private $person;
	
	public function __construct() {
			
		$this->person = Util::fixInput($_POST['person']);
		
		$student = new Student();
		$faculty = new Faculty();
		$administer = new Administer();
		
		$student->setSuccessor($faculty);
		$faculty->setSuccessor($administer);

		$loadup = new Request($this->person);
		$student->handleRequest($loadup);
		
	}
	
}

require_once('../routes/Dispatcher.php');

?>
