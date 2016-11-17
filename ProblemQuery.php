<?php

class ProblemQuery implements IStrategy {

	private $account;
	private $password;
	private $result;
	
	private $hookup;

	public function algorithm() {
		
		$this->account = Util::fixInput($_POST['account']);
		$this->password = Util::fixInput($_POST['password']);
		
		try {
			$this->hookup = UniversalConnect::doConnect();
			$stmt = $this->hookup->prepare('SELECT * FROM student WHERE student_account=? AND student_password=?');
			$stmt->execute(array($this->account, $this->password));
			$this->result = $stmt->rowCount();
			$this->hookup = null;
			if ($this->result === 1) {
				session_start();
				$_SESSION['student_name'] = $stmt->fetch(PDO::FETCH_ASSOC)['student_name'];
				$_SESSION['student'] = $this->account;
				new Viewer('Stu_index');
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

