<?php
namespace TAFree\models;

use TAFree\classes\IStrategy;
use TAFree\utils\Viewer;
use TAFree\utils\DBOperator;
use TAFree\database\UniversalConnect;
use TAFree\models\ProblemChecker;

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
			$checker = new ProblemChecker();
			$obj = array();
			$obj['item'] = $this->item;
			if ($checker->result($obj)) {
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

}

?>

