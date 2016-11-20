<?php

class MessageEntry implements IStrategy {
	
	private $subject;
	private $message;

	private $hookup;
	

	public function __construct ($subject, $message) {

		$this->subject = $subject;
		$this->message = $message;
	}

	public function algorithm () {
		

		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			// Insert table
			$this->insertTable();

			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}
	
	public function insertTable () {
		// discussion
		$stmt = $this->hookup->prepare('INSERT INTO discussion (subject, message) VALUES(:subject, :message)');
		$stmt->execute(array(':subject' => $this->subject, ':message' => $this->message));	
	}
}

?>

