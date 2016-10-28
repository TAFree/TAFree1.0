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
				
		$this->contentProduct .= '<table><tr>';
		
		try {
			$this->hookup = UniversalConnect::doConnect();
			$stmt = $this->hookup->prepare('SELECT item, number FROM problem');	
			$stmt->execute();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$this->contentProduct .= '<td><svg id=\'' . $row['item'] . '\' class=\'POLYGON_SVG\'></svg><input class=\'NUMBER_SUBITEM_HIDDEN\' type=\'hidden\' value=\'' . $row['number'] . '\'></td>';
			}
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
		$this->contentProduct .= '</tr></table>';

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
