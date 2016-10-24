<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');

class Chooser implements Product {	
	
	private $ids = array('LAB01', 'FINAL', 'QUIZ01', 'LAB02');

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .= '<table><tr>';
		for ($i = 0; $i < count($this->ids); $i++) {
			$this->contentProduct .= '<td><svg id=\'' . $this->ids[$i] . '\' class=\'POLYGON_SVG\'></svg></td>';
		}
		$this->contentProduct .= '</tr></table>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;	
	}	 

}

?>
