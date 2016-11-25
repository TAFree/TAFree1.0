<?php

include_once('FormatHelper.php');
include_once('Product.php');

class WrongPerson implements Product{
	
	private $content = 'Either password or account is wrongly typed... <a class=\'DOC_A\' href=\'./Login.php\'>Login Again</a>';	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .= '<p id=\'WRONG_PERSON_P\'>' . $this->content . '</p>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

?>

