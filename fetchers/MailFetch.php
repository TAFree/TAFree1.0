<?php 
namespace TAFree\fetchers;

use TAFree\routes\SessionManager;
use TAFree\database\UniversalConnect;

require_once('../composers/Autoloader.php');

class MailFetch {
	
	private $newer;
	private $guest;

	private $hookup;

	public function __construct() {
		
		$this->guest = SessionManager::getParameter('guest');
		
		try {
		
			$this->hookup = UniversalConnect::doConnect();
		
			switch ($this->guest) {
			case 'faculty':
				$this->fetchApply();
				break;
			case 'student':
				$this->fetchRatify();
				break;
			default: 
				$this->newer = 0;
				break;
			}							
			
			$this->hookup = null;
		
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}

	}
	
	public function hasNewer() {
		return $this->newer;
	}

	public function fetchApply () {	
		$stmt = $this->hookup->prepare('SELECT reply FROM apply WHERE reply=\'Wait\'');
		$stmt->execute();
		$result = $stmt->rowCount();
		if ($result !== 0) {
			$this->newer = true;
		}
	}
	
	public function fetchRatify () {	
		$stmt = $this->hookup->prepare('SELECT reply FROM apply WHERE student_account=\'' . SessionManager::getParameter('account') . '\' AND reply<>\'Wait\' AND  expected_deadline>=NOW()');
		$stmt->execute();
		$result = $stmt->rowCount();
		if ($result !== 0) {
			$this->newer = true;
		}
	}

}

?>


