<?php

class ProblemColoring implements IStrategy {
	
	private $item;
	private $item_status;
	
	private $hookup;
	
	public function __construct($item, $item_status) {
		$this->item = $item;
		$this->item_status = $item_status;
	}
	
	public function algorithm () {
		
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

?>


