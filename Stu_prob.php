<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');
}

class Stu_prob implements Product {	
	
	private $formatHelper;
	private $contentProduct;

	private $item;
	private $subitem;
	private $writeblock;

	private $hookup;
	
	public function getContent() {
		
		$this->item = $_GET['item'];
		$this->subitem = $_GET['subitem'];

		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<h1>{$this->item}_{$this->subitem}</h1>
<form method='POST' action='./Handin.php'>
<div class='HIDDEN_DIV'>
<input type='hidden' value='{$this->item}' name='item'>
<input type='hidden' value='{$this->subitem}' name='subitem'>
</div>
<div class='STU_WRITE_DIV'>
<input type='submit' id='HANDIN_INPUT' class='CLICKABLE' value='Handin >>' name='submit'>
</div>
EOF;
		$this->writeblock = new Look($this->item, $this->subitem);
		$this->contentProduct .= $this->writeblock->getContent();
		
		$this->contentProduct .=<<<EOF
</form>
EOF;
		
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
