<?php
namespace TAFree\controllers;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

use TAFree\classes\Handler;
use TAFree\utils\DBOperator;
use TAFree\utils\Util;
use TAFree\database\UniversalConnect;
use TAFree\secrete\IConnectInfo;
use TAFree\utils\Viewer;
use TAFree\routes\SessionManager;

require_once('../composers/Autoloader.php');

class Administer extends Handler {

	private $account;
	private $password;
	
	public function setSuccessor($nextService) {
		$this->successor = $nextService;
	
	}
	
	public function handleRequest ($request) {
		
		$this->handle = 'administer';
		
		if ($request->getService() === $this->handle) {
			$this->account = Util::fixInput($_POST['account']);
			$this->password = Util::fixInput($_POST['password']);
			if ( $this->account === IConnectInfo::UNAME && $this->password === IConnectInfo::PW) {
				SessionManager::init();
				SessionManager::setParameter('guest', 'administer'); 
				SessionManager::setParameter('nickname', 'Administer');
				SessionManager::setParameter('account', IConnectInfo::UNAME);
				new viewer('Admin');
				$this->hookup = null;
			}
			else{
				new viewer('WrongPerson');
				$this->hookup = null;
			}
		}
		else if ($this->successor !== null) {
			$this->successor->handleRequest($request);
		}
	}

}

?>
