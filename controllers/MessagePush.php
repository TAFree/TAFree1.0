<?php 
namespace TAFree\controllers;

use TAFree\utils\DBOperator;

require_once('../composers/Autoloader.php');
require_once('../routes/SetRouter.php');

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

$router->run();

?>

