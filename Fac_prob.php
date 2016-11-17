<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');	
}

class Fac_prob implements Product{
	
	private $links = array (
		'Assign' => './Fac_assign.php',
		'Status' => './Fac_status.php',
		'Watch' => 'Fac_watch.php'
	);	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .= '<div id=\'FAC_DIV\'>';
		$this->contentProduct .= '<h1>Here is ' . $_GET['item'] . '_' . $_GET['subitem'] . '</h1>';	
		foreach ($this->links as $key => $value) {
			$this->contentProduct .= '<a class=\'FAC_A\' href=\'' . $value . '?item=' . $_GET['item'] . '&subitem=' . $_GET['subitem'] . '\'>' . $key . '</a><br><br>';
		}
		$this->contentProduct .= '</div>';

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
