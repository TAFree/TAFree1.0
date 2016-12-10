<?php
namespace TAFree\fetchers;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\database\UniversalConnect;
use TAFree\fetchers\Look;

require_once('../composers/Autoloader.php');

class Sheet implements Product {	
	
	private $contentProduct;

	private $item;
	private $subitem;
	private $stu_account;
	private $writeblock;

	public function __construct($info) {
		$this->item = $info['item'];
		$this->subitem = $info['subitem'];
		$this->stu_account = $info['stu_account'];
	}
	
	public function getContent() {
		
		$this->contentProduct .=<<<EOF
<div class='HIDDEN_DIV'>
<input type='hidden' value='{$this->item}' name='item'>
<input type='hidden' value='{$this->subitem}' name='subitem'>
<input type='hidden' value='{$this->stu_account}' name='stu_account'>
</div>
<div class='PUT_BUTTON_DIV'>
<input type='button' id='HANDIN_INPUT' class='CLICKABLE' value='Handin'>
</div>
EOF;
		
		$this->writeblock = new Look($this->item, $this->subitem);
		
		$this->contentProduct .= $this->writeblock->getContent();
		
		return $this->contentProduct;
	}	 

}

?>
