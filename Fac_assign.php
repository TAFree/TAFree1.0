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
<div class='FAC_ASSIGN_DIV'>
<input type='submit' value='Upload >>'>
</div>
<table id='PROBLEM_TABLE'>
<tr>
<th class='TITLE_TD'>Problem</th>
<th class='TITLE_TD'>{$_GET['item']}_{$_GET['subitem']}</th>
</tr>
<tr>
<td class='CONTENT_TD'>Description</td>
<td class='CONTENT_TD'><input type='file'></td>
</tr>
<tr>
<td class='CONTENT_TD'>Hint</td>
<td class='CONTENT_TD'><textarea></textarea></td>
</tr>
<tr>
<td class='CONTENT_TD'>Judge</td>
<td class='CONTENT_TD'>
<select id='JUDGE_SELECT'>
<option value='201602_Java_CP.php'>201602_Java_CP.php</option>
<option value='201602_C++_OOP.php'>201601_C++_OOP.php</option>
<option value='other'>other</option>
<input id='OTHER_INPUT' type='file'>
</select>
</td>
</tr>
</table>
<table id='SOLUTION_TABLE'>
<tr>
<th></th>
<th colspan='2' class='TITLE_TD'>Solution</th>
</tr>
<tr>
<td><button class='ADD_BUTTON' type='button'><b>+</b></button></td>
<td class='TITLE_TD'>Filename (.java, .cpp, .py)</td>
<td class='TITLE_TD'>Upload</td>
</tr>
<tr class='HIDDEN_TR'>
<td><button class='DEL_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text'></td>
<td class='CONTENT_TD'><input type='file'></td>
</tr>
<tr class='SHOW_TR'>
<td><button class='DEL_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text'></td>
<td class='CONTENT_TD'><input type='file'></td>
</tr>
</table>
<table id='TESTDATA_TABLE'>
<tr>
<th></th>
<th colspan='2' class='TITLE_TD'>Test Data</th>
</tr>
<tr>
<td><button class='ADD_BUTTON' type='button'><b>+</b></button></td>
<td class='TITLE_TD'>Filename (.in)</td>
<td class='TITLE_TD'>Separate by Space</td>
</tr>
<tr class='HIDDEN_TR'>
<td><button class='DEL_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text'></td>
<td class='CONTENT_TD'><textarea></textarea></td>
</tr>
<tr class='SHOW_TR'>
<td><button class='DEL_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text'></td>
<td class='CONTENT_TD'><textarea></textarea></td>
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
