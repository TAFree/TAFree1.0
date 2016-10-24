<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name){
	include_once($class_name . '.php');
}

class Fac_all implements Product {	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<form>
<table id='ALL_TABLE'>
<tr>
<th class='TITLE_TD'>Student Name</td>
<th class='TITLE_TD'>Account</td>
<th class='TITLE_TD'>Password&nbsp;&nbsp;<a class='CLICKABLE' href='down_csv.php'>Download&nbsp;CSV</a></td>
</tr>
<tr>
<td class='CONTENT_TD'><input type='text' value='Abby'></td>
<td class='CONTENT_TD'><input type='text' value='abby8050'></td>
<td class='CONTENT_TD'><input type='text' value='123456'></td>
</tr>
<tr>
<td class='CONTENT_TD'><input type='text' value='Abby'></td>
<td class='CONTENT_TD'><input type='text' value='abby8050'></td>
<td class='CONTENT_TD'><input type='text' value='123456'></td>
</tr>
<tr>
<td class='CONTENT_TD'><input type='text' value='Abby'></td>
<td class='CONTENT_TD'><input type='text' value='abby8050'></td>
<td class='CONTENT_TD'><input type='text' value='123456'></td>
</tr>
</table>
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
