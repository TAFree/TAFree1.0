<?php
namespace TAFree\controllers;

use TAFree\utils\DBOperator;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class AssignControl {
	
	private $unique_key;
	private $item;

	public function __construct($item) {
		
		// Create unique key
		$this->unique_key = uniqid(time(), true);
		
		// Update unique_key in problem table
		$this->item = $item;
		$trigger = new DBOperator();
		$trigger->assignRegistry($this->unique_key, $this->item);
	}

	public function getKey() {
		return $this->unique_key;
	}

}

require_once('../routes/Dispatcher.php');

?>
