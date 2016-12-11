<?php
namespace TAFree\fetchers;

use TAFree\database\UniversalConnect;
use TAFree\routes\SessionManager;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class SourceFetch {
	
	private $item;
	private $subitem;
	private $classnames;
	private $sources = array();

	private $hookup;
	
	public function __construct () {
		
		$this->item = SessionManager::getParameter('item');
		$this->subitem = SessionManager::getParameter('subitem');

		// Get classnames that request for sources
		$data = file_get_contents('php://input'); 
		$this->classnames = json_decode($data); 
		
	
		try {
			$this->hookup = UniversalConnect::doConnect();						
		
			// Fetch sources that are requested
			foreach ($this->classnames as $id => $classname) {
				$stmt = $this->hookup->prepare('SELECT original_source FROM ' . $this->item . '_' . $this->subitem . ' WHERE classname=:classname');
				$stmt->bindParam(':classname', $classname);
				$stmt->execute();	
				$row = $stmt->fetch(\PDO::FETCH_ASSOC);
				$this->sources[$classname] = $row['original_source'];
			}
				
			$this->hookup = null;
			
			// Response sources by json format
			header ('Content-Type: application/json; charset=utf-8');
			$json_obj = json_encode($this->sources);
			echo $json_obj;

		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}

}

require_once ('../routes/Dispatcher.php');

?>

