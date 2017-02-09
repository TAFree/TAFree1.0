<?php
namespace TAFree\controllers;

use TAFree\database\UniversalConnect;
use TAFree\routes\SessionManager;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class HandinRejector {
	
	private $item;
	private $subitem;
	private $stu_account;
	private $judge_status;
	private $reject = 'false';
	
	public function __construct () {
		
		// Get item, subitem, stu_account
		$this->item = SessionManager::getParameter('item');
		$this->subitem = SessionManager::getParameter('subitem');
		$this->stu_account = SessionManager::getParameter('account');

		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			// Get judge_status
			$stmt = $this->hookup->prepare('SELECT ' . $this->stu_account . ' FROM ' . $this->item . ' WHERE subitem=\'' . $this->subitem . '\'');
			$stmt->execute();
			$row = $stmt->fetch(\PDO::FETCH_ASSOC);
			$this->judge_status = $row[$this->stu_account];

			$this->hookup = null;		
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
		// Rejuct if judge status is pending
		if ($this->judge_status === 'Pending') {
			$this->reject = 'true';
		}

		echo $this->reject;
			
	}

}

require_once('../routes/Dispatcher.php');

?>

