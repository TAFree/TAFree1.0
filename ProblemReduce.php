<?php

class ProblemReduce implements IStrategy {
	
	private $item;
	private $subitem;
	private $number;

	private $hookup;
	
	public function algorithm () {
		
		// Get item, subitem
		$this->item = $_POST['item'];
		$this->subitem = $_POST['subitem'];
		$this->number = intval($this->subitem) - 1;

		try {
			// Connect to database
			
			$this->hookup = UniversalConnect::doConnect();	
			
			// Manipulate tables					
			
			// Reduce problem table
			$this->reduceProblem();
			
			// Reduce item table
			$this->reduceItem();
	
			// Delete subitem table
			$this->deleteSubitem();

			$this->hookup = null;
			
			new Viewer('Msg', 'Already delete ' . $this->item . '_' . $this->subitem . ' ! ');
	
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}	
	
	}

	public function reduceProblem () {
		$stmt = $this->hookup->prepare('UPDATE problem SET number=:number WHERE item=\'' . $this->item . '\'');
		$stmt->execute(array(':number' => $this->number));	
	}
	
	public function reduceItem () {	
		$stmt = $this->hookup->prepare('DELETE FROM ' . $this->item . ' WHERE subitem=\'' . $this->subitem . '\'');
		$stmt->execute();	
	}
	
	public function deleteSubitem () {
		$stmt = $this->hookup->prepare('DROP TABLE ' . $this->item . '_' . $this->subitem);
		$stmt->execute();
	}

}

?>

