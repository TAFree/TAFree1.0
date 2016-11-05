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

<form method='POST' action='./Assign.php' >
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
<th class='TITLE_TD'>Judge Script<br><input type='file'></th>
</tr>
<tr>
<td><button id='ADD_BUTTON' class='ASS_BUTTON' type='button'><b>+</b></button></td>
<td class='TITLE_TD'>Solution (.java, .cpp, .py)</td>
<td class='TITLE_TD'>Pattern</td>
<td class='TITLE_TD'>Others (Not necessary)</td>
</tr>
<tr class='HIDDEN_TR'>
<td><button class='ASS_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='file'></td>
<td class='CONTENT_TD'>
<select>
<option value='blank'>Blank</option>
<option value='fill_in'>Fill-in</option>
<option value='lock'>Lock</option>
<option value='invisible'>Invisible</option>
</select>
</td>
<td class='CONTENT_TD'><input type='file'></td>
</tr>
<tr>
<td><button class='ASS_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='file'></td>
<td class='CONTENT_TD'>
<select>
<option value='blank'>Blank</option>
<option value='fill_in'>Fill-in</option>
<option value='lock'>Lock</option>
<option value='invisible'>Invisible</option>
</select>
</td>
<td class='CONTENT_TD'><input type='file'></td>
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
