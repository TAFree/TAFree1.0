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
	private $stu_account;
	private $writeblock;

	private $hookup;
	
	public function getContent() {
		// Get item, subitem, stu_account
		$this->item = $_GET['item'];
		$this->subitem = $_GET['subitem'];
	
		$this->stu_account = $_SESSION['student'];

		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<form id='HANDIN_FORM' method='POST' action='./Handin.php'>
<div class='HIDDEN_DIV'>
<input type='hidden' value='{$this->item}' name='item'>
<input type='hidden' value='{$this->subitem}' name='subitem'>
<input type='hidden' value='{$this->stu_account}' name='stu_account'>
</div>
<div class='STU_WRITE_DIV'>
<input type='button' id='HANDIN_INPUT' class='CLICKABLE' value='Handin >>'>
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
