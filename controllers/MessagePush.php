<?php 
namespace TAFree\controllers;

use TAFree\utils\DBOperator;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class MessagePush {
	
	private $subject;
	private $message;

	public function __construct() {
		
		// Get subject, message
		$this->subject = $_POST['subject'];	
		$this->message = $_POST['message'];	

		$trigger = new DBOperator();
		$trigger->pushMessage($this->subject, $this->message);
	}

}

require_once('../routes/Dispatcher.php');

?>

