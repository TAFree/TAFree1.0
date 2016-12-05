<?php 
namespace TAFree\controllers;

use TAFree\utils\DBOperator;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');
require_once('../routes/SetRouter.php');

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

$router->run();

?>

