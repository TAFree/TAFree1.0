<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

class Hack implements Product{
	
	private $content = 'Hack me <3 !';	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .= '<p id=\'HACK_P\'>' . $this->content . '</p>';

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

