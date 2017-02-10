<?php
namespace TAFree\views;

use TAFree\database\UniversalConnect;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Test {	
	

	private $contentProduct;

	private $hookup;

	public function __construct() {
		try {
			$this->hookup = UniversalConnect::doConnect();
			$stmt = $this->hookup->prepare('SELECT view FROM process WHERE id=\'123\'');
			$stmt->execute();
			
			$row = $stmt->fetch(\PDO::FETCH_ASSOC);
			$this->contentProduct .= $row['view'];
			
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage();
		}
		echo $this->contentProduct;	
	}	 

}

new Test();
?>
