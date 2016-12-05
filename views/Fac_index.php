<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;

require_once('../composers/Autoloader.php');

class Fac_index implements Product{
	
	// Should be assign	
	private $links = array (
		'Problem' => '../views/Fac_chooser.php',
		'Student' => '../views/Fac_stu.php',
		'Score' => '../views/Fac_score.php',
		'Expansion' => '../views/Fac_expansion.php'
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
