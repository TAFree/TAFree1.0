<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');
}

class Fac_assign implements Product {	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF

<form method='POST' action='./Fac_modify.php' >
<table id='ASS_TABLE'>
<tr>
<td colspan='4'>
<input type='submit' value='Save >>'>
<br>
<br>
</td>
</tr>
<tr>
<th></th>
<th class='TITLE_TD'>{$_GET['item']}_{$_GET['subitem']}</th>
<th class='TITLE_TD'>Problem Description<br><input type='file'></th>
</tr>
<tr>
<td><button id='ADD_BUTTON' class='ASS_BUTTON' type='button'><b>+</b></button></td>
<td class='TITLE_TD'>Filename (.java, .cpp, .py)</td>
<td class='TITLE_TD'>Solution</td>
</tr>
<tr class='HIDDEN_TR'>
<td><button class='ASS_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text'></td>
<td class='CONTENT_TD'><input type='file'></td>
</tr>
<tr>
<td><button class='ASS_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text'></td>
<td class='CONTENT_TD'><input type='file'></td>
</tr>
</table>
</form>


<table id='ASS_TABLE'>
<tr>
<td colspan='4'>
<input type='submit' value='Save >>'>
<br>
<br>
</td>
</tr>
<tr>
<th></th>
<th class='TITLE_TD' colspan='2'>Test Data</th>
</tr>
<tr>
<td><button id='ADD_BUTTON' class='ASS_BUTTON' type='button'><b>+</b></button></td>
<td class='TITLE_TD'>Filename (.in)</td>
<td class='TITLE_TD'>Data Separated by Space</td>
</tr>
<tr class='HIDDEN_TR'>
<td><button class='ASS_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text'></td>
<td class='CONTENT_TD'><textarea></textarea></td>
</tr>
<tr>
<td><button class='ASS_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text'></td>
<td class='CONTENT_TD'><textarea></textarea></td>
</tr>
</table>
<div class='BLOCK_DIV'>
<div class='TITLE_DIV'>Judge Script</div>
<textarea rows='30' cols='30'></textarea>
</div>
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
