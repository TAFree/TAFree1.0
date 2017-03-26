<?php
namespace TAFree\models;

use TAFree\classes\IStrategy;
use TAFree\database\UniversalConnect;
use TAFree\utils\Util;
use TAFree\utils\Viewer;

require_once('../composers/Autoloader.php');

class PasswordUpdater implements IStrategy {

	private $account;
	private $password;
	private $guest;
	
	private $hookup;

	public function __construct($guest) {
		$this->guest = $guest;
	}

	public function algorithm() {
		
		$this->account = Util::fixInput($_POST['account']);
		$this->password = Util::fixInput($_POST['password']);

		if (!Util::anFilter($this->password)){	
			new Viewer ('Msg', $this->password .  ' is not only alphabet or number...' . '<br>');	
			exit();
		}

		try {

			$this->hookup = UniversalConnect::doConnect();
			$stmt = $this->hookup->prepare('UPDATE ' . $this->guest . ' SET ' . $this->guest . '_password=\'' . $this->password . '\' WHERE ' . $this->guest . '_account=?');
			$stmt->execute(array($this->account));
			$this->hookup = null;	

			new Viewer('Msg', 'Please re-login with new password !');

		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}

}

?>
