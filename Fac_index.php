
<?php

include_once('FormatHelper.php');
include_once('Product.php');

class Fac_index implements Product{
	
	// Should be assign	
	private $links = array (
		'Problem' => './Fac_chooser.php',
		'Student' => './Fac_stu.php',
		'Score' => './Fac_score.php',
		'Expansion' => './Fac_expansion.php'
	);	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() { 
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .= '<table class="CIR_TABLE"><tr>';
		foreach($this->links as $key => $value) {
			$this->contentProduct .=<<<EOF
<td>
<a href='$value'>
<svg class='CIR_SVG'>
<circle class='BIG_CIRCLE'></circle>
<circle class='SMALL_CIRCLE'></circle>
<text class='CIR_TEXT' x='68px' y='160px' font-size='50px' font-family='fantasy'>$key</text>
</svg>
</a>
</td>
EOF;
		}
		$this->contentProduct .= '</tr></table>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

?>
