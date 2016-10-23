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
			$stmt = $this->hookup->query('SELECT * FROM student WHERE student_account=\':account\' AND student_password=\':password\'');
			$stmt->bindValue(':account', $this->account, PDO::PARAM_STR);
			$stmt->bindValue(':password', $this->password, PDO::PARAM_STR);
			$stmt->execute();
			while($row=$stmt->fetch()){
				echo $row;
			}
			//echo $this->result;
			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
	/*	
		if ($this->result !== 0) {
			new Viewer('Stu_index');
		}
		else{
			new Viewer('WrongPerson');
		}
	*/
	}

}

?>
