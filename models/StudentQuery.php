<?php
namespace TAFree\models;

use TAFree\classes\IStrategy;
use TAFree\utils\Util;
use TAFree\utils\Viewer;
use TAFree\database\UniversalConnect;
use TAFree\routes\SessionManager;

require_once('../composers/Autoloader.php');

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
			$stmt = $this->hookup->prepare('SELECT * FROM student WHERE student_account=? AND student_password=?');
			$stmt->execute(array($this->account, $this->password));
			if ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				SessionManager::init();
				SessionManager::setParameter('guest', 'student'); 
				SessionManager::setParameter('nickname', $row['student_name']);
				SessionManager::setParameter('account', $row['student_account']);
				header('location: ../views/Stu_problems.php');
				$this->hookup = null;
			}
			else{
				new Viewer('WrongPerson');
				$this->hookup = null;
			}
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
	
	}

}

?>
