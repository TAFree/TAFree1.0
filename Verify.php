<?php 

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');
}

class Verify {
	
	private $tasks = array();
	private $item;
	private $subitem;
	private $judge;
	
	public function __construct() {
			
		$this->tasks = $_POST['task'];
		$this->item = $_POST['item'];
		$this->subitem = $_POST['subitem'];
		$this->judge = $_POST['judge'];
		
		$ac = new Status('AC');
		$wa = new Status('WA');
		$na = new Status('NA');
		$ce = new Status('CE');
		$re = new Status('RE');
		$tle = new Status('TLE');
		$mle = new Status('MLE');
		$ole = new Status('OLE');
		$se = new Status('SE');
		$rf = new Status('RF');
		
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
		
		// If judge script is qualified then 
		if ($ac->handleRequest($loadup)) {
	
			// Clone it from ./problem/judge/[item]/[subitem] directory to ./judge directory to be reused in the future
			$this->cloneJudge();	
		
			// Check other subitem tables for changing problem status into 'Available'
			if ($this->areAllFinished()) {
				$trigger = new DBOperator();
				$trigger->colorProblem($this->item, 'Available');	
			}
		
		}		
		
	}
			
	public function cloneJudge () {
		
		// Clone judge file ./problem/judge/[item]/[subitem] to ./judge
		if (!copy('./problem/judge/' . $this->item . '/' . $this->subitem . '/' . $this->judge, './judge/' . $this->judge)) {
			new Viewer ('Msg', $this->judge . ' copy failed...');
			exit();
		}

	}
	
	public function areAllFinished () {
		$stmt_num = $this->hookup->prepare('SELECT number FROM problem WHERE item=\'' . $this->item . '\'');
		$stmt_num->execute();
		$this->item_num = $stmt_num->fetch(PDO::FETCH_ASSOC)['number'];
			
		for ($i = 1; $i <= $this->item_num; $i += 1) {
			$stmt_subitem = $this->hookup->prepare('SELECT modified_source FROM ' . $this->item . '_' . $i);
			$stmt_subitem->execute();
			if ($stmt_subitem->rowCount() === 0) {
				return false;
			}
		}
		return true;
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
