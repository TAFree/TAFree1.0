<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');
}

class Stu_score implements Product {	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<form>
<table id='STU_SCORE_TABLE'>
<tr>
<td class='TITLE_TD' colspan='4'><p>Lab01</p></td>
</tr>
<tr>
<td class='TITLE_TD'>Student Name</td>
<td class='TITLE_TD'>Account</td>
<td class='TITLE_TD'>1</td>
<td class='TITLE_TD'>2</td>
</tr>
<tr>
<td class='CONTENT_TD'>Abby</td>
<td class='CONTENT_TD'>abby8050</td>
<td class='CONTENT_TD'>1</td>
<td class='CONTENT_TD'>0</td>
</tr>
</table>
            
<table class='STU_SCORE_TABLE'>
<tr>
<td class='TITLE_TD' colspan='5'><p>Lab01</p></td>
</tr>
<tr>
<td class='TITLE_TD'>Student Name</td>
<td class='TITLE_TD'>Account</td>
<td class='TITLE_TD'>1</td>
<td class='TITLE_TD'>2</td>
<td class='TITLE_TD'>3</td>
</tr>
<tr>
<td class='CONTENT_TD'>Abby</td>
<td class='CONTENT_TD'>abby8050</td>
<td class='CONTENT_TD'>1</td>
<td class='CONTENT_TD'>0</td>
<td class='CONTENT_TD'>0.7</td>
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
