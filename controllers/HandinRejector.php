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
	private $safe;
	private $judge_status;
	private $reject = false;
	
	public function __construct () {
		
		// Get item, subitem, stu_account
		$this->item = SessionManager::getParameter('item');
		$this->subitem = SessionManager::getParameter('subitem');
		$this->stu_account = SessionManager::getParameter('account');

		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			// Get safe, judge_status
			$stmt = $this->hookup->prepare('SELECT safe, ' . $this->stu_account . ' FROM ' . $this->item . ' WHERE subitem=\'' . $this->subitem . '\'');
			$stmt->execute();
			$row = $stmt->fetch(\PDO::FETCH_ASSOC);
			$this->safe = $row['safe'];
			$this->judge_status = $row[$this->stu_account];

			// Rejuct if judge status is pending
			if ($this->safe === 'isolate' && $this->judge_status === 'Pending') {
				$this->reject = true;
			}
			return $this->reject;
				
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}

}

require_once('../routes/Dispatcher.php');

?>

