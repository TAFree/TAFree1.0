<?php

include_once('Util.php');
include_once('UniversalConnect.php');
include_once('Viewer.php');

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
			if ( $this->account === IconnectInfo::UNAME && $this->password === IconnectInfo::PW) {
				new VIEWER('Admin');
			}
			else{
				new VIEWER('WrongPerson');
			}
		}
		else if ($this->successor !== NULL) {
			$this->successor->handleRequest($request);
		}
	}

}

?>
