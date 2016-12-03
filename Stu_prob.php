<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');
}

class Stu_prob implements Product {	
	
	private $formatHelper;
	private $contentProduct;

	private $information;
	private $answersheet;

	public function __construct($info) {
		$this->information = $info;
	}
	
	public function getContent() {

		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->answersheet = new Sheet($this->infomation);
	
		$this->contentProduct .= $this->answersheet->getContent();
			
		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
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
