<?php
namespace TAFree\controllers;

use TAFree\utils\DBOperator;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');
require_once('../routes/SetRouter.php');

class AssignControl {
	
	private $unique_key;
	private $item;

	public function __construct() {
		
		$this->unique_key = uniqid(time(), true);
		$this->item = $_POST['item'];
		$trigger = new DBOperator();
		$trigger->assignRegistry($this->unique_key, $this->item);
		echo $this->unique_key;
		exit();
	}

}

$router->run();

?>
