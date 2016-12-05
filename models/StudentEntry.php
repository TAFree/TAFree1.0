<?php
namespace TAFree\models;

use TAFree\classes\IStrategy;
use TAFree\database\UniversalConnect;

require_once('../composers/Autoloader.php');

class StudentEntry implements IStrategy {
	
	private $item;
	private $account;
	private $closeup;

	private $hookup;
	
	public function algorithm () {
		
		// Get item, showup time, backup time
		$this->item = $_POST['item'];
		$this->account = $_POST['account'];
		$this->closeup = $_POST['closeup'];

		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			// Update table
			$this->updateTable();

			$this->hookup = null;
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}
	
	public function updateTable () {
		// closeup
		$stmt = $this->hookup->prepare('UPDATE closeup SET ' . $this->account . '=:closeup WHERE item=\'' . $this->item . '\'');
		if ($this->closeup === 'null') {
			$this->closeup = null;
		}
		$stmt->execute(array(':closeup' => $this->closeup));	
	}
}

?>
