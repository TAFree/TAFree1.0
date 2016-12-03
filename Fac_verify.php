<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');

class Fac_verify implements Product {	
	
	private $formatHelper;
	private $contentProduct;

	private $item;
	private $subitem;
	
	public function __construct($fullitem) {
		
		// Get item, subitem
		$this->item = substr($fullitem, 0, strrpos($fullitem, '_'));
		$this->subitem = substr($fullitem, strrpos($fullitem, '_') + 1);
		
	}

	public function getContent() {
		
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<h1>{$this->item}_{$this->subitem}</h1>
<div id='FAC_VERIFY_DIV'>
<input type='button' class='CLICKABLE' id='QUALIFY_INPUT' value='Qualify >>'> 
<label for='TESTER_INPUT'>Tester Account <input type='text' id='TESTER_INPUT'></label>
<div class='HIDDEN_DIV'>
<input type='hidden' value='{$this->item}' id='item'>
<input type='hidden' value='{$this->subitem}' id='subitem'>
</div>
<pre>
Select tasks for testing judge script:
A qualified judge script is at least able to distinguish status of Accept (AC) & Wrong Answer (WA) from student's source code. Others are optional.
</pre>
<table id='VERIFY_TABLE'>
<tr id='AC_TR'>
<td><label for='AC_INPUT'><input type='checkbox' id='AC_INPUT' value='AC' disabled checked>AC (Accept)</label></td>
<td><img id='AC_IMG' width='15' height='15' src='./tafree-svg/unknown.svg'></td>
</tr>
<tr id='WA_TR'>
<td><label for='WA_INPUT'><input type='checkbox' id='WA_INPUT' value='WA' disabled checked>WA (Wrong Anwser)</label></td>
<td><img id='WA_IMG' width='15' height='15' src='./tafree-svg/unknown.svg'></td>
</tr>
<tr>
<td><label for='NA_INPUT'><input type='radio' name='optional' id='NA_INPUT' value='NA'>NA (Not Accept, passed part of testdata, not all)</label></td>
<td><img width='15' height='15' src='./tafree-svg/unknown.svg'></td>
</tr>
<tr>
<td><label for='CE_INPUT'><input type='radio' name='optional' id='CE_INPUT' value='CE'>CE (Compile Error)</label></td>
<td><img width='15' height='15' src='./tafree-svg/unknown.svg'></td>
</tr>
<tr>
<td><label for='RE_INPUT'><input type='radio' name='optional' id='RE_INPUT' value='RE'>RE (Runtime Error)</label></td>
<td><img width='15' height='15' src='./tafree-svg/unknown.svg'></td>
</tr>
<tr>
<td><label for='SE_INPUT'><input type='radio' name='optional' id='SE_INPUT' value='SE'>SE (System Error, includes all unexpected errors)</label></td>
<td><img width='15' height='15' src='./tafree-svg/unknown.svg'></td>
</tr>
<tr>
<td><label for='TLE_INPUT'><input type='radio' name='optional' id='TLE_INPUT' value='TLE'>TLE (Time Limit Exceed)</label></td>
<td><img width='15' height='15' src='./tafree-svg/unknown.svg'></td>
</tr>
<tr>
<td><label for='MLE_INPUT'><input type='radio' name='optional' id='MLE_INPUT' value='MLE'>MLE (Memory Limit Exceed)</label></td>
<td><img width='15' height='15' src='./tafree-svg/unknown.svg'></td>
</tr>
<tr>
<td><label for='OLE_INPUT'><input type='radio' name='optional' id='OLE_INPUT' value='OLE'>OLE (Output Limit Exceed)</label></td>
<td><img width='15' height='15' src='./tafree-svg/unknown.svg'></td>
</tr>
<tr>
<td><label for='RF_INPUT'><input type='radio' name='optional' id='RF_INPUT' value='RF'>RF (Restricted Function)</label></td>
<td><img width='15' height='15' src='./tafree-svg/unknown.svg'></td>
</tr>
</table>
</div>
EOF;
	
		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

?>
