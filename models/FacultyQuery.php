<?php
namespace TAFree\models;

use TAFree\classes\IStrategy;
use TAFree\database\UniversalConnect;
use TAFree\utils\Util;
use TAFree\utils\Viewer;
use TAFree\routes\SessionManager;

require_once('../composers/Autoloader.php');

class FacultyQuery implements IStrategy {

	private $account;
	private $password;
	
	private $hookup;

	public function algorithm() {
		
		$this->account = Util::fixInput($_POST['account']);
		$this->password = Util::fixInput($_POST['password']);
		
		try {

			$this->hookup = UniversalConnect::doConnect();

			$stmt = $this->hookup->prepare('SELECT * FROM faculty WHERE faculty_account=? AND faculty_password=?');
			$stmt->execute(array($this->account, $this->password));

			if ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				SessionManager::init();
				SessionManager::setParameter('guest', 'faculty'); 
				SessionManager::setParameter('nickname', $row['faculty_name']);
				SessionManager::setParameter('account', $row['faculty_account']);
				header('location: ../views/Fac_problems.php');
				$this->hookup = null;
				exit();
			}
			else{
				new Viewer('WrongPerson');
				$this->hookup = null;
				exit();
			}	

		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}

}

?>
