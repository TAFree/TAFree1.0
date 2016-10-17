<?php

include_once('FormatHelper.php');
include_once('Product.php');

class Debug implements Product{
	
	// Should be assign	
	private $links = array (
		'Assign' => 'http://www.google.com',
		'Mark' => 'http://www.google.com',
		'KeyGen' => 'http://www.google.com',
	);	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .= '<div id=\'FAC_DIV\'>';
		foreach ($this->links as $key => $value) {
			$this->contentProduct .= '<a class=\'FAC_A\' href=\'' . $value . '\'>' . $key . '</a><br><br>';
		}
		$this->contentProduct .= '</div>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

?>
