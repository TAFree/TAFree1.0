<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\fetchers\Look;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');
require_once('../routes/SetRouter.php');

class Fac_look implements Product {	
	
	private $formatHelper;
	private $contentProduct;

	private $item;
	private $subitem;
	private $writeblock;
	
	public function getContent() {
		
		$this->item = $_GET['item'];
		$this->subitem = $_GET['subitem'];

		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->writeblock = new Look($this->item, $this->subitem);
		$this->contentProduct .= $this->writeblock->getContent();
			
		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

$router->run();

?>
