<?php

include_once('Util.php');

class StudentQuery implements IStrategy {

	private $account;
	private $password;
	private $result;
	
	private $hookup;

	public function algorithm() {
		
		$this->account = Util::fixInput($_POST['account']);
		$this->password = Util::fixInput($_POST['password']);
		
		try {
			$this->hookup = UniversalConnect::doConnect();
			$stmt = $this->hookup->query('SELECT student_password FROM student WHERE student_account=\'' . $this->account . '\'');
			$this->result = $stmt->fetchObject()->student_password;	
			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
	
		if ($this->result === $this->password) {
			session_start();
			$_SESSION['student'] = $this->account;
			new Viewer('Stu_index');
		}
		else{
			new Viewer('WrongPerson');
		}
	
	}

}

?>
