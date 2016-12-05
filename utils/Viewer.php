<?php 
namespace TAFree\utils;

use TAFree\utils\ContentFactory;

class Viewer {
	
	private $contentFactory;

	public function __construct($page, $para = null) {		

		$this->contentFactory = new ContentFactory();

		$page = 'TAFree\\views\\' . str_replace('/', '\\', $page);
		
		echo $this->contentFactory->doFactory(new $page($para));

	}
	
}

?>
