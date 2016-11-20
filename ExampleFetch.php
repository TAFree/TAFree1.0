<?php 

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');	
}

class ExampleFetch {
	
	private $examples;

	public function __construct() {
		
		$this->examples = '';

		foreach (glob('./judge/*') as $filename) {
			$handle = fopen($filename, 'r');
			$contents = fread($handle, filesize($filename));
			$this->examples .= '<pre>' . htmlspecialchars($contents) . '</pre><br>';
			fclose($handle);
		}
		echo $this->examples;
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


