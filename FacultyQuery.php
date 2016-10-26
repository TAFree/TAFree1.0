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
			$stmt = $this->hookup->prepare('SELECT * FROM faculty WHERE faculty_account=? AND faculty_password=?');
			$stmt->execute(array($this->account, $this->password));
			$this->result = $stmt->rowCount();
			$this->hookup = null;
			if ($this->result === 1) {
				session_start();
				$_SESSION['faculty'] = $this->account;
				new Viewer('Fac_index');
			}
			else{
				new Viewer('WrongPerson');
			}
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}

}

?>
