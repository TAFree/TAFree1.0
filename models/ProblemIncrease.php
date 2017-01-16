<?php
namespace TAFree\models;

use TAFree\classes\IStrategy;
use TAFree\utils\Viewer;
use TAFree\database\UniversalConnect;
use TAFree\routes\SessionManager;

require_once('../composers/Autoloader.php');

class ProblemIncrease implements IStrategy {
	
	private $item;
	private $subitem;
	private $number;

	private $hookup;
	
	public function algorithm () {
		
		// Get item, subitem
		$this->item = SessionManager::getParameter('item');
		$this->subitem = SessionManager::getParameter('subitem');
		$this->number = intval($this->subitem) + 1;
		$this->subitem = $this->number;

		try {
			// Connect to database
			
			$this->hookup = UniversalConnect::doConnect();	
			
			// Manipulate tables					
			
			// Increase problem table
			$this->increaseProblem();
			
			// Increase item table
			$this->increaseItem();
	
			// Increase subitem table
			$this->increaseSubitem();
		
			// Increase testdata table
			$this->increaseTestdata();
			
			// Create ../problem/description/[item]/[subitem]
			if(!mkdir('../problem/description/' . $this->item . '/' . $this->subitem)){
				new Viewer('Msg', 'Failed to create ../problem/description/' . $this->item . '/' . $this->subitem);
				exit();
			}
			
			$this->hookup = null;
			
			new Viewer('Msg', 'Already create ' . $this->item . '_' . $this->subitem . ' ! ');
	
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}	
	
	}

	public function increaseProblem () {
		$stmt = $this->hookup->prepare('UPDATE problem SET number=:number WHERE item=\'' . $this->item . '\'');
		$stmt->execute(array(':number' => $this->number));	
	}
	
	public function increaseItem () {	
		$stmt = $this->hookup->prepare('INSERT INTO ' . $this->item . '(subitem) VALUES(:subitem)');
		$stmt->bindParam(':subitem', $this->subitem);
		$stmt->execute();
	}
	
	public function increaseSubitem () {
		$stmt_stu = $this->hookup->prepare('SELECT student_account FROM student');
		$stmt_stu->execute();
		$stu_accs = array();
		while ($row_stu = $stmt_stu->fetch(\PDO::FETCH_ASSOC)) {
			array_push($stu_accs, $row_stu['student_account']);
		}
		$sql = 'CREATE TABLE ' . $this->item . '_' . $this->number . '(
			classname VARCHAR(100),
			main CHAR(1),
			original_source TEXT,
			modified_source TEXT,';
		for ($j = 0; $j < count($stu_accs); $j += 1) {
			$sql .= $stu_accs[$j] . ' TEXT';
			if ($j < count($stu_accs) - 1) {
				$sql .= ',';
			}
		}
		$sql .= ', PRIMARY KEY(classname));';
		$stmt_subitem = $this->hookup->prepare($sql);
		$stmt_subitem->execute();
	}

	public function increaseTestdata () {
		$sql = 'CREATE TABLE ' . $this->item . '_' . $this->subitem . '_testdata' . '(
			testdata VARCHAR(100),
			content TEXT,
			PRIMARY KEY(testdata));';
		$stmt_testdata = $this->hookup->prepare($sql);
		$stmt_testdata->execute();
	}

}

?>

