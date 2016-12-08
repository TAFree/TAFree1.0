<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\database\UniversalConnect;
use TAFree\routes\SessionManager;

require_once('../composers/Autoloader.php');

class Modify implements Product {	

	private $formatHelper;
	private $contentProduct;

	private $item;
	private $subitem;

	private $hookup;
	
	public function __construct($data) {
		
		// Reset key_to_assign session variable to avoid previous page clicking
		SessionManager::setParameter('key_to_assign', '19911010');
		
		$this->item = $data['item'];
		$this->subitem = $data['subitem'];
	}	

	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<h1>{$this->item}_{$this->subitem}</h1>
<form id='MODIFY_FORM' method='POST' action='../controllers/Handout.php'>
<div class='HIDDEN_DIV'>
<input type='hidden' value='{$this->item}' name='item'>
<input type='hidden' value='{$this->subitem}' name='subitem'>
</div>
<div class='FAC_MODIFY'>
<input type='button' id='HANDOUT_INPUT' class='CLICKABLE' value='Handout >>'>
</div>
<table class='CODES_TABLE'>
<tr>
EOF;
		try {
			$this->hookup = UniversalConnect::doConnect();
			$stmt = $this->hookup->prepare('SELECT classname, original_source FROM ' . $this->item . '_' . $this->subitem);
			$stmt->execute();
			$i = 0;
			while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				
				if ($i % 3 === 0 && $i !== 0)  {
					$this->contentProduct .= '</tr><tr>';
				}
				$i += 1;

				$this->contentProduct .=<<<EOF
<td>
<div class='BLOCK_DIV'>
<div class='TITLE_DIV'><p class='TITLE_P'>{$row['classname']}</p><img class='ZOOM_IMG'></div>
<div class='CODE_DIV'>
<pre class='MODIFY_ORIGIN_PRE'>{$row['original_source']}</pre>
</div>
<div class='MODIFY_BAR_DIV'>
<table class='MODIFY_TABLE'>
<tr><td><img class='MODIFY_BUTTON_IMG' src='../public/tafree-svg/line.svg' title='Cut out line'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='../public/tafree-svg/block.svg' title='Cut out block'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='../public/tafree-svg/all.svg' title='Cut out all'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='../public/tafree-svg/rubber.svg' title='Remove line'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='../public/tafree-svg/undo.svg' title='Restore'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='../public/tafree-svg/lock.svg' title='Lock all'></td></tr>
</table>
</div>
</div>
</td>
EOF;
			}
		}
		catch (\PDOException $e) {
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

?>
