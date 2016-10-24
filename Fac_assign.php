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

<form>
<table id='ASS_TABLE'>
<tr>
<th></th>
<th class='TITLE_TD'>Quiz01</th>
<th class='TITLE_TD'>4&nbsp;&nbsp;&nbsp;<input type='file'></th>
<th class='TITLE_TD'>Judge
<select>
<option>Automatic</option>
<option>Manual</option>
</select>&nbsp;&nbsp;
<input type='submit' value='Save >>'>
</th>
</tr>
<tr>
<td><button id='ADD_BUTTON' class='ASS_BUTTON' type='button'><b>+</b></button></td>
<td class='TITLE_TD'>Class</td>
<td class='TITLE_TD'>Solution(.java)</td>
<td class='TITLE_TD'>Input(.java)</td>
</tr>
<tr class='HIDDEN_TR'>
<td><button class='ASS_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text'></td>
<td class='CONTENT_TD'>
<input type='file'>
<select>
<option>Blank</option>
<option>Fill-in</option>
<option>Lock</option>
<option>Invisible</option>
</select>
</td>
<td class='CONTENT_TD'>
</td>
<tr>
<td><button class='ASS_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text'></td>
<td class='CONTENT_TD'>
<input type='file'>
<select>
<option>Blank</option>
<option>Fill-in</option>
<option>Lock</option>
<option>Invisible</option>
</select>
</td>
<td class='CONTENT_TD'>
<input type='file'>
</td>
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
