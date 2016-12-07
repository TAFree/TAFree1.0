<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\fetchers\ExampleFetch;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Support implements Product{
	
	private $content; 
	private $examples;

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->content = file_get_contents('../public/tafree-doc/support');	
		$this->contentProduct .= '<div class=\'DOC_DIV\'>' . $this->content;
		$this->examples = new ExampleFetch();
		
		$this->contentProduct .= $this->examples->getContent() . '</div>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

require_once('../routes/Dispatcher.php');

?>

