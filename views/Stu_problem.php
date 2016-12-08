<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\fetchers\Sheet;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Stu_problem implements Product {	
	
	private $formatHelper;
	private $contentProduct;

	private $information;
	private $answersheet;

	public function __construct($info) {
		$this->information = $info;
	}
	
	public function getContent() {

		$this->formatHelper = new FormatHelper(get_class($this));

		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->answersheet = new Sheet($this->information);
	
		$this->contentProduct .= $this->answersheet->getContent();
			
		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

require_once('../routes/Dispatcher.php');

?>
