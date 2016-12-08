<?php 
namespace TAFree\controllers;

use TAFree\utils\DBOperator;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Upload {

	public function __construct() {
			
		$trigger = new DBOperator();

		if (isset($_POST['delete'])) {
			$trigger->reduce();
		}
		else {
			$trigger->upload();
		}
	}

}

require_once('../routes/Dispatcher.php');

?>

