<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload ($class_name) {
	include_once($class_name . '.php');
}

class Stu_leave implements Product {	
	
	private $formatHelper;
	private $contentProduct;
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		$this->contentProduct .=<<<EOF
<form>
<table id='STU_LEAVE_TABLE'>
<tr>
<th class='TITLE_TD'>Name</th>
<th class='TITLE_TD'>Account</th>
<th class='TITLE_TD'>Item</th>
<th class='TITLE_TD'>Reason</th>
<th class='TITLE_TD'>Expected Deadline</th>
<th class='TITLE_TD'>Allowed Deadline</th>
<th class='TITLE_TD'>Reply<br><input type='submit' value='Send >>'></th>
</tr>
<tr>
<td class='CONTENT_TD'>Someone</td>
<td class='CONTENT_TD'>abcde</td>
<td class='CONTENT_TD'>Lab01</td>
<td class='REASON'>Sick</td>
<td class='CONTENT_TD'>2016/10/10&nbsp;13:00</td>
<td class='CONTENT_TD'>2016/10/10&nbsp;14:00</td>
<td class='CONTENT_TD'>Approval</td>
</tr>
<td class='CONTENT_TD'>Someone</td>
<td class='CONTENT_TD'>abcde</td>
<td class='CONTENT_TD'>Lab01</td>
<td class='REASON'>SicickSickSickSickSickSickSickSickSickSickSickSickSickSickSickSickSick</td>
<td class='CONTENT_TD'>2016/10/10&nbsp;13:00</td>
<td class='CONTENT_TD'></td>
<td class='CONTENT_TD'></td>
</tr>
<tr>
<td class='CONTENT_TD'>ABBY</td>
<td class='CONTENT_TD'>{$_SESSION['student']}</td>
<td class='CONTENT_TD'>
<select>
<option>Lab01</option>
<option>Quiz02</option>
<option>Final01</option>
</select>
</td>
<td class='REASON'><textarea row='30' cols='60'></textarea></td>
<td class='CONTENT_TD'>
<input type='date'>
<input type='number' name='hour' min='0' max='23' value='00'>:
<input type='number' name='minute' min='0' max='59' value='00'>
</td>
<td class='CONTENT_TD'></td>
<td class='CONTENT_TD'></td>
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
