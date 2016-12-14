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
	private $ip;
	private $result;
	
	private $hookup;

	public function algorithm() {
		
		// Get account, password, ip
		$this->account = Util::fixInput($_POST['account']);
		$this->password = Util::fixInput($_POST['password']);
		if (Util::ipFilter($_SERVER['HTTP_CLIENT_IP'])) {
			$this->ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		else if(Util::ipFilter($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else if(Util::ipFilter($_SERVER['REMOTE_ADDR'])){
			$this->ip = $_SERVER['REMOTE_ADDR'];
		}
		else {
			$this->ip = 'Fish';
		}
		
		try {
			$this->hookup = UniversalConnect::doConnect();
			$stmt = $this->hookup->prepare('SELECT * FROM student WHERE student_account=? AND student_password=?');
			$stmt->execute(array($this->account, $this->password));
			if ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				SessionManager::init();
				SessionManager::setParameter('guest', 'student'); 
				SessionManager::setParameter('nickname', $row['student_name']);
				SessionManager::setParameter('account', $row['student_account']);
				SessionManager::setParameter('ip', $this->ip);
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
