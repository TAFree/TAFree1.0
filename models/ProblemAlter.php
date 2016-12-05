<?php
namespace TAFree\models;

use TAFree\classes\IStrategy;
use TAFree\utils\Viewer;
use TAFree\utils\DBOperator;
use TAFree\database\UniversalConnect;

require_once('../composers/Autoloader.php');

class ProblemAlter implements IStrategy {
	
	private $item;
	private $item_num;
	private $subitem;
	private $classnames = array();
	private $modified_sources = array();

	private $hookup;
	
	public function algorithm () {
		
		// Get item, subitem, classnames, modified_source
		$this->item = $_POST['item'];
		$this->subitem = $_POST['subitem'];
		$this->classnames = $_POST['classname'];	
		$this->modified_sources = $_POST['modified_source'];	
		
		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			// Update subitem table
			$this->updateSubitem();
		
			// Check other subitem tables for changing problem status into 'Available'
			if ($this->areAllFinished()) {
			
				$trigger = new DBOperator();
				$trigger->colorProblem($this->item, 'Available');
		
			}
				
			// Successful handout message 
			new Viewer('Msg', $this->item . '_' . $this->subitem . ' already handout !' . '<br>' . 'Make sure this is final version or not to give students writing permission.');
				
			$this->hookup = null;
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
	
	}
	
	public function updateSubitem () {
		for ($i = 0; $i < count($this->classnames); $i += 1) {
			$stmt = $this->hookup->prepare('UPDATE ' . $this->item . '_' . $this->subitem . ' SET modified_source=:modified_source WHERE classname=\'' . $this->classnames[$i] . '\'');
			$stmt->execute(array(':modified_source' => $this->modified_sources[$i]));	
		}
	}

	public function areAllFinished () {
		$stmt_num = $this->hookup->prepare('SELECT number FROM problem WHERE item=\'' . $this->item . '\'');
		$stmt_num->execute();
		$this->item_num = $stmt_num->fetch(\PDO::FETCH_ASSOC)['number'];
			
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

?>

