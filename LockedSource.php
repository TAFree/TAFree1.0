
<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');	
}

class LockedSource {
	
	private $subitem;
	private $item;
	private $classname;
	private $lockedSource;
	
	private $hookup;

	public function __construct() {
		
		$this->subitem = $_POST['subitem'];
		$this->item = $_POST['item'];
		$this->classname = $_POST['classname'];
		
		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			$stmt = $this->hookup->prepare('SELECT original_source FROM ' . $this->item . '_' . $this->subitem . ' WHERE classname=\'' . $this->classname . '\'');
			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_ASSOC);	
		
			$this->lockedSource = $row['original_source'];
			
			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
				
		echo $this->lockedSource;
		exit();
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

