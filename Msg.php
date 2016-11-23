<?php

include_once('FormatHelper.php');
include_once('Product.php');

class Msg implements Product{
	
	private $content;

	private $formatHelper;
	private $contentProduct;
	
	public function __construct ($msg) {
		$this->content = $msg;
	}
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
//		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .= '<p id=\'MSG_P\'>' . $this->content . '</p>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

?>

