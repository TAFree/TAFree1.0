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

		// Arrange score back task	
		$command = 'php ./ScoreBackup.php ' . $this->item;
		$backup_time = preg_split('/[\s:-]+/', $this->backup);
		$year = $backup_time[0];
		$mon = $backup_time[1];
		$date = $backup_time[2];
		$hr = $backup_time[3];
		$min = $backup_time[4];
		$handler = popen('at ' . $hr . ':' . $min . ' ' . $mon . $date . $year, 'w');
		fwrite($handler, $command);
		fclose($handler);
	}
}

?>
