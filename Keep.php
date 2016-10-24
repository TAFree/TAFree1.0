<?php

include_once('FormatHelper.php');
include_once('Product.php');

class Keep implements Product{
	
	private $content = 'Keep...';	

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

