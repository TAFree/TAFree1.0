<?php
namespace TAFree\fetchers;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\database\UniversalConnect;

require_once('../composers/Autoloader.php');

class Look implements Product {	
	
	private $contentProduct;

	private $item;
	private $subitem;

	private $hookup;

	public function __construct($item, $subitem) {
		$this->item = $item;
		$this->subitem = $subitem;
	}	

	public function getContent() {
		try {
			$this->hookup = UniversalConnect::doConnect();
			
			$stmt = $this->hookup->prepare('SELECT hint, description FROM ' . $this->item . ' WHERE subitem=\'' . $this->subitem . '\'');
			$stmt->execute();
			$row = $stmt->fetch(\PDO::FETCH_ASSOC);

			$this->contentProduct .= '<h1>' . $this->item . '_' . $this->subitem . '</h1>';
			if (!empty($row['description'])) {
				$this->contentProduct .=<<<EOF
<a class='CLICKABLE_LEFT' href='../problem/description/{$this->item}/{$this->subitem}/{$row['description']}' download='{$row['description']}'>Description</a>
EOF;
			}
			$this->contentProduct .= '<div class=\'HINT_DIV\'>' . $row['hint'] . '</div>';
			$this->contentProduct .= '<table class=\'CODES_TABLE\'><tr>';
			$stmt = $this->hookup->prepare('SELECT classname, modified_source FROM ' . $this->item . '_' . $this->subitem);
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
<div class='WRITE_DIV'>{$row['modified_source']}</div>
</div>
</td>
EOF;
			}
			$this->contentProduct .= '</tr></table>';
			
			$this->hookup = null;
			
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}		
		
		return $this->contentProduct;
	
	}	 

}

?>
