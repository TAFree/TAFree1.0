<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');


function __autoload($class_name) {
	include_once($class_name . '.php');
}

class Support implements Product{
	
	private $content; 
	private $examples;

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->content = file_get_contents('tafree-doc/support');	
		$this->contentProduct .= '<div class=\'DOC_DIV\'>' . $this->content;
		$this->examples = new ExampleFetch();
		$this->contentProduct .= $this->examples->getContent() . '</div>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

if (isset($router)) {
	$router->run();
}
else {
	include_once('SetRouter.php');
	$router->run();
}

?>

