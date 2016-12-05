<?php
namespace TAFree\fetchers;

use TAFree\database\UniversalConnect;

require_once('../composers/Autoloader.php');

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

class KeyQuery {
		
	private $item;
	private $unique_key;
	
	public function __construct ($item) {
		$this->item = $item;
	}

	public function findKey () {

		try {
			$this->hookup = UniversalConnect::doConnect();
			
			$stmt = $this->hookup->prepare('SELECT unique_key FROM problem WHERE item=\'' . $this->item . '\'');
			$stmt->execute();
			$row = $stmt->fetch(\PDO::FETCH_ASSOC);
			$this->unique_key = $row['unique_key'];
			
			$this->hookup = null;
		
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
		return $this->unique_key;
	
	}

}

?>
