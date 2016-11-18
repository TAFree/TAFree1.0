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

			// Check if all subitems has been finished assigning work when item_status is 'Available'
			if ($this->item_status === 'Available') {
				if (!$this->areSubitemsFinished()) {
					return;
				}
			}

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

	public function areSubitemsFinished() {
		$stmt = $this->hookup->prepare('Select modified_source FROM ' . $this->item . '_' . $this->subitem);
		$stmt->execute();
		while ($row = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
			if(empty($row['modified_source'])) {
				return false;
			}
		}
		return true;
	}
}

?>


