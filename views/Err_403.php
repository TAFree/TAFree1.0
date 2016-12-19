<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\utils\Viewer;

require_once('../composers/Autoloader.php');

class Err_403 implements Product{
	
	private $content = '403 QQ...';	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .= '<div id=\'HTTP_ERROR_DIV\'>' . $this->content . '</div>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

new Viewer('Err_403');

?>

