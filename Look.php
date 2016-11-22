<?php

class Look implements Product {	
	

	private $contentProduct;

	private $item;
	private $subitem;
	private $hint;

	private $hookup;

	public function __construct($item, $subitem) {
		$this->item = $item;
		$this->subitem = $subitem;
	}	

	public function getContent() {
		try {
			$this->hookup = UniversalConnect::doConnect();
			
			$stmt = $this->hookup->prepare('SELECT hint FROM ' . $this->item . ' WHERE subitem=\'' . $this->subitem . '\'');
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->hint = $row['hint'];	
			$this->contentProduct .=<<<EOF
<div class='HINT_DIV'>{$this->hint}</div>
<input type='button' class='CLICKABLE' value='Download'>
<table class='CODES_TABLE'>
<tr>
EOF;
			
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
<div class='WRITE_DIV'>{$row['modified_source']}</div>
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
