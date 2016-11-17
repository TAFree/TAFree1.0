<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');
}

class Stu_prob implements Product {	
	
	private $formatHelper;
	private $contentProduct;

	private $item;
	private $subitem;

	private $hookup;
	
	public function getContent() {
		
		$this->item = $_GET['item'];
		$this->subitem = $_GET['subitem'];

		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<h1>{$this->item}_{$this->subitem}</h1>
<form method='POST' action='./Handin.php'>
<div class='HIDDEN_DIV'>
<input type='hidden' value='{$this->item}' name='item'>
<input type='hidden' value='{$this->subitem}' name='subitem'>
</div>
<div class='STU_WRITE_DIV'>
<input type='submit' id='HANDIN_INPUT' class='CLICKABLE' value='Handin >>' name='submit'>
</div>
<table class='CODES_TABLE'>
<tr>
EOF;
		try {
			$this->hookup = UniversalConnect::doConnect();
			$stmt = $this->hookup->prepare('SELECT classname, modified_source FROM ' . $this->item . '_' . $this->subitem);
			$stmt->execute();
			$i = 0;
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				
				if ($i % 3 === 0 && $i !== 0)  {
					$this->contentProduct .= '</tr><tr>';
				}
				$i += 1;

				$this->contentProduct .=<<<EOF
<td>
<div class='BLOCK_DIV'>
<div class='TITLE_DIV'><p class='TITLE_P'>{$row['classname']}</p><img class='ZOOM_IMG'></div>
<div class='CODE_DIV'>
<pre class='MODIFY_ORIGIN_PRE'>{$row['modified_source']}</pre>
</div>
<div class='MODIFY_BAR_DIV'>
<table class='MODIFY_TABLE'>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/line.svg' title='Cut out line'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/block.svg' title='Cut out block'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/all.svg' title='Cut out all'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/rubber.svg' title='Remove line'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/undo.svg' title='Restore'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/lock.svg' title='Lock all'></td></tr>
</table>
</div>
</div>
</td>
EOF;
			}
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}		
		

		$this->contentProduct .=<<<EOF
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
