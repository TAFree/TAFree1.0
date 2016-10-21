<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

class Login implements Product{	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<form id='LOGIN_FORM' method='POST' action='./Index.php'>
Account&nbsp;&nbsp;&nbsp;<input type='text' name='account'><br><br>
Password&nbsp;&nbsp;<input type='password' name='password'><br><br>
<select name='person'>
<option value='student'>Student</option>
<option value='faculty'>Faculty</option>
<option value='administer'>Administer</option>
<option value='tester'>Tester</option>
</select><br><br>
<input type='submit' name='submit' value='Login'>
</form>
EOF;

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

if (isset($router)) {
	$router->run();
}
else {
	include_once('SetRouter.php');
	$router->run();
}

?>

