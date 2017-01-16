<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;

require_once('../composers/Autoloader.php');

class Pending implements Product{

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		$this->contentProduct .= '<div id=\'PENDING_DIV\'>TAFree is now processing your uploads.<br>Please do not touch anything ! </div>';
		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

?>

