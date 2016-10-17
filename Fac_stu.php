<?php

include_once('FormatHelper.php');
include_once('Product.php');

class Fac_stu implements Product{
	
	// Should be assign	
	private $links = array (
		'Add/Delete' => 'http://www.apple.com/hk/',
		'All' => 'http://www.apple.com/hk/',
		'Leave' => 'http://www.apple.com/hk/'				     
	);	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .= '<div id=\'FAC_DIV\'>';
		foreach ($this->links as $key => $value) {
			if ($key !== 'Leave') {
				$this->contentProduct .= '<a class=\'FAC_A\' href=\'' . $value . '\'>' . $key . '</a><br><br>';
			}else {
				$this->contentProduct .= '<a id=\'FAC_LEAVE\' class=\'FAC_A\' href=\'' . $value . '\'>' . $key . '</a><br><br>';
			}
		}
		$this->contentProduct .= '</div>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

?>
