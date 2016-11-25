<?php

include_once('FormatHelper.php');
include_once('Product.php');

class Result implements Product{
	
	private $content;

	private $formatHelper;
	private $contentProduct;
	
	public function __construct ($msg) {
		$this->content = $msg;
	}
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .= $this->content;

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

?>

