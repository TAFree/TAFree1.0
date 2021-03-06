<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Login implements Product{	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<form method='POST' action='../controllers/Index.php'>
<table id='LOGIN_TABLE'>
<tr>
<td>Account</td>
<td><input type='text' name='account'></td>
</tr>
<tr>
<td>Password</td>
<td><input type='password' name='password'></td>
</tr>
<tr>
<td colspan='2'>
<br>
<select name='person'>
<option value='student'>Student</option>
<option value='faculty'>Faculty</option>
<option value='administer'>Administer</option>
</select>
<br>
<br>
</td>
</tr>
<tr>
<td colspan='2'>
<input type='submit' class='CLICKABLE' name='submit' value='Login'>
</td>
</tr>
</table>
</form>
EOF;

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

require_once('../routes/Dispatcher.php');

?>

