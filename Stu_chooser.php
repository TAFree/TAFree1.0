<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');	
}

class Stu_chooser implements Product {	

	private $formatHelper;
	private $contentProduct;
	
	private $hookup;
	
	public function getContent() {
		
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
				
		$this->contentProduct .= '<table id=\'STU_CHOOSER_TABLE\'>';
		
		try {
			$this->hookup = UniversalConnect::doConnect();
			$stmt = $this->hookup->prepare('SELECT item, number FROM problem');	
			$stmt->execute();
			while ($row_item = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$this->contentProduct .= '<tr><td><img class=\'PRE_IMG\' height=\'30\' width=\'30\' src=\'../public/tafree-svg/previous.svg\'><svg id=\'' . $row_item['item'] . '\' class=\'POLYGON_SVG\'></svg><input class=\'NUMBER_SUBITEM_HIDDEN\' type=\'hidden\' value=\'' . $row_item['number'] . '\'><img class=\'NEXT_IMG\' height=\'30\' width=\'30\' src=\'../public/tafree-svg/next.svg\'></td></tr>';	
			}
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
		$this->contentProduct .= '</table>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;	
	}	 

}

if ($router) {
	$router->run();
}
else {
	include_once('SetRouter.php');
	$router->run();
}

?>
