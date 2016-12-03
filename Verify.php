<?php 

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');
}

class Verify {
	
	private $tasks = array();
	
	public function __construct() {
			
		$this->tasks = $_POST['task'];
		
		$ac = new AC();
		$wa = new WA();
		$na = new NA();
		$ce = new CE();
		$re = new RE();
		$tle = new TLE();
		$mle = new MLE();
		$ole = new OLE();
		$se = new SE();
		$rf = new RF();
		
		$ac->setSuccessor($wa);
		$wa->setSuccessor($na);
		$na->setSuccessor($ce);
		$ce->setSuccessor($re);
		$re->setSuccessor($tle);
		$tle->setSuccessor($mle);
		$mle->setSuccessor($ole);
		$ole->setSuccessor($se);
		$se->setSuccessor($rf);

		$loadup = new Request($this->tasks);
		$ac->handleRequest($loadup);
		
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
