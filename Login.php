<?php

include_once('FormatHelper.php');
include_once('Product.php');

class Login implements Product{
	
	// Should be assigned	
	private $file = './Client.php';	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<form id='LOGIN_FORM' action='$this->file'>
Account&nbsp;&nbsp;&nbsp;<input type='text' name='account'><br><br>
Password&nbsp;&nbsp;<input type='password' name='password'><br><br>
<select name='student'>
<option value='student'>Student</option>
<option value='faculty'>Faculty</option>
<option value='administer'>Administer</option>
<option value='tester'>Tester</option>
</select><br><br>
<input type='submit' value='Login'>
</form>
EOF;

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

?>

