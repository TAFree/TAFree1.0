<?php

class ProblemColoring implements IStrategy {
	
	private $item;
	private $item_status;
	
	private $hookup;
	
	public function algorithm () {
		
		// Get item, item_status
		$this->item = $_POST['item'];
		$this->item_status = $_POST['item_status'];	

		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			// Update problem table
			$this->updateProblem();

			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
	
	}
	
	public function updateProblem () {
		$stmt = $this->hookup->prepare('UPDATE problem SET status=:status WHERE item=\'' . $this->item . '\'');
			$stmt->execute(array(':status' => $this->item_status));	
		}
	}

}

?>


