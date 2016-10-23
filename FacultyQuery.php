<?php

include_once('Util.php');

class FacultyQuery implements IStrategy {

	private $account;
	private $password;
	private $result;
	
	private $hookup;

	public function algorithm() {
		
		$this->account = Util::fixInput($_POST['account']);
		$this->password = Util::fixInput($_POST['password']);
		
		try {
			$this->hookup = UniversalConnect::doConnect();
			$stmt = $this->hookup->query('SELECT faculty_password FROM faculty WHERE faculty_account=\'' . $this->account . '\'');
			$this->result = $stmt->fetchObject()->faculty_password;	
			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
	
		if ($this->result === $this->password) {

			new Viewer('Fac_index');
		}
		else{
			new Viewer('WrongPerson');
		}
	
	}

}

?>
