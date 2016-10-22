<?php 

include_once('ContentFactory.php');

class Viewer {
	
	private $contentFactory;

	public function __construct($page, $para=NULL) {		
		$this->contentFactory = new ContentFactory();
		echo $this->contentFactory->doFactory(new $page($para));
	}
	
}

?>
