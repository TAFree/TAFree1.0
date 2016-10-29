<?php

class TimeSetup implements IStrategy {
	
	private $item;
	private $showup;
	private $backup;

	private $hookup;
	
	public function algorithm () {
		
		// Get item, showup time, backup time
		$this->item = $_POST['item'];
		$this->showup = $_POST['showup'];
		$this->backup = $_POST['backup'];

		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			// Update table
			$this->updateTable();

			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}
	
	public function updateTable () {
		
		// problem
		$stmt = $this->hookup->prepare('UPDATE problem SET showup=\'' . $this->showup . '\', backup=\'' . $this->backup . '\' WHERE item=\'' . $this->item . '\'');
		$stmt->execute();	

	}
}

?>
