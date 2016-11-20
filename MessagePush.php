<?php 

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');	
}

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

if ($router) {
	$router->run();
}
else {
	include_once('SetRouter.php');
	$router->run();
}

?>

