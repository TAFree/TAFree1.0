<?php

include_once('Checker.php');

class TaskChecker extends Checker {
	
	private $mock_account;
	private $mock_item;
	private $mock_subitem;
	private $mock_task;

	private $hookup;
	
	public function query ($context) {
		$this->mock_account = $context['account'];
		$this->mock_item = $context['item'];
		$this->mock_subitem = $context['subitem'];
		$this->nock_task = $context['task'];
		
		try {
			$this->hookup = UniversalConnect::doConnect();						

			$stmt = $this->hookup->prepare('SELECT ' . $this->mock_account . ' FROM ' . $this->mock_item . ' WHERE subitem=\'' . $this->mock_subitem . '\'');
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);	
			$this->result = $result[$this->mock_account];

			if ($this->result === $this->mock_task) {
				return true;
			}
			else {
				return false;
			}
			
			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}
	
}

?>
