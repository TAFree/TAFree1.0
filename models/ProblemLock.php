<?php

class ProblemLock implements IStrategy {
	
	private $item;
	private $unique_key;

	private $hookup;
	
	public function __construct ($key, $item) {
		$this->unique_key = $key;
		$this->item = $item;
	}

	public function algorithm () {
		
		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			$stmt = $this->hookup->prepare('UPDATE problem SET unique_key=\'' . $this->unique_key . '\' WHERE item=\'' . $this->item . '\'');
			$stmt->execute();

			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}
}

?>
