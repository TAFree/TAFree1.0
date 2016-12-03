<?php 

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');
}

class Qualify {
	
	private $item;
	private $subitem;
	private $judge;

	private $hookup;
	
	public function __construct() {
		
		// Get item, subitem	
		$this->item = $_POST['item'];
		$this->subitem = $_POST['subitem'];
		
		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			// Get judge
			$this->judge = $this->getJudge();
			
			// Clone qualified judge script from ./problem/judge/[item]/[subitem] directory to ./judge directory to be reused in the future
			$this->cloneJudge();	
			
			// Check other subitem tables for changing problem status into 'Available'
			if ($this->areAllFinished()) {
				$trigger = new DBOperator();
				$trigger->colorProblem($this->item, 'Available');	
			}					

			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}
			
	public function getJudge () {
		$stmt = $this->hookup->prepare('SELECT judgescript FROM ' . $this->item . ' WHERE subitem=\'' . $this->subitem . '\'');
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		return $row['judgescript'];
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
