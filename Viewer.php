<?php 

include_once('ContentFactory.php');

class Viewer {
	
	private $contentFactory;

	public function __construct($page) {		
		$this->contentFactory = new ContentFactory();
		echo $this->contentFactory->doFactory(new $page());
	}
	
}

?>
