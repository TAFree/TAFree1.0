<?php

include_once('FormatHelper.php');
include_once('Product.php');

class Test implements Product{
	
	private $content = 'A place to test page.';	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .= '<p id=\'KEEP_P\'>' . $this->content . '</p>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

?>

