<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Fac_rejudge implements Product {	

	private $formatHelper;
	private $contentProduct;

	public function getContent() {

		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<form method='POST' action='../controllers/Rejudge.php'>
<h2>Re-judge an assignment</h2>
<p class='WARN_P'>This might affect scores of several students that already was displayed !</p>
<table id='REJUDGE_TABLE'>
<tr>
<td>Item</td>
<td><input type='text' name='item'></td>
</tr>
<tr>
<td>Subitem</td>
<td><input type='text' name='subitem'></td>
</tr>
<tr>
<td colspan='2'>
<br>
<input type='submit' class='CLICKABLE' name='submit' value='Rejudge'>
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
