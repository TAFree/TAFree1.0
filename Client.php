<?php 

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('ContentFactory.php');

class Client {
	
	// Should be assign	
	private $page = 'Debug';

	private $contentFactory;

	public function __construct() {
		
		$page = $this->page;		
		include_once($page . '.php');
		$this->contentFactory = new ContentFactory();
		echo $this->contentFactory->doFactory(new $page());
	}
}

$worker = new Client();

?>
