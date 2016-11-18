<?php

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
			
		$this->contentProduct .=<<<EOF
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
<div class='CODE_DIV'>{$row['modified_source']}</div>
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
EOF;
		
		return $this->contentProduct;
	}	 

}

?>
