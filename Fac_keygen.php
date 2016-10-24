<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');
}

class Fac_keygen implements Product {	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF

<form id='KEYGEN_FORM'>
<table>
<tr>
<td>Today's Access Password</td>
<td><input type='text'>&nbsp;&nbsp;<input type='submit' value='Go!'></td>
</tr>
<tr>
<td>Page will show up</td>
<td>
at&nbsp;<input type='date'>
<input type='number' min='0' max='23' value='00'>&nbsp;:&nbsp;
<input type='number' min='0' max='59' value='00'>
</td>
</tr>
<tr>
<td>Page will close up</td>
<td>
at&nbsp;<input type='date'>
<input type='number' min='0' max='23' value='00'>&nbsp;:&nbsp;
<input type='number' min='0' max='59' value='00'>
</td>
</tr>
<tr>
<td>Score will back up</td>
<td>
at&nbsp;<input type='date'>
<input type='number' min='0' max='23' value='00'>&nbsp;:&nbsp;
<input type='number' min='0' max='59' value='00'>
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
