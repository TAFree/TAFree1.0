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
		'Coders' => './Fac_coders.php',
		'Look' => 'Fac_look.php'
	);	
	private $item;
	private $subitem;

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		
		// Get item, subitem
		$this->item = $_GET['item'];
		$this->subitem = $_GET['subitem'];
		
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .= '<div id=\'FAC_DIV\'>';
		$this->contentProduct .= '<input type=\'hidden\' name=\'item\' value=\'' . $this->item . '\'>';
		$this->contentProduct .= '<input type=\'hidden\' name=\'subitem\' value=\'' . $this->subitem . '\'>';
		$this->contentProduct .= '<h1>Here is ' . $this->item . '_' . $this->subitem . '</h1>';	
		$this->contentProduct .= '<input type=\'button\' id=\'ASSIGN_INPUT\' class=\'CLICKABLE\' value=\'Assign\'>';
		foreach ($this->links as $key => $value) {
			$this->contentProduct .= '<a class=\'FAC_A\' href=\'' . $value . '?item=' . $this->item . '&subitem=' . $this->subitem. '\'>' . $key . '</a><br><br>';
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
