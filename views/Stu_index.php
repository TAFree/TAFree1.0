<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;

require_once('../composers/Autoloader.php');

class Stu_index implements Product{
	
	// Should be assign	
	private $links = array (
		'Problem' => '../views/Stu_chooser.php',
		'Score' => '../views/Stu_score.php',
		'Leave' => '../views/Stu_leave.php',
		'Record' => '../views/Stu_record.php'
	);	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
	
		$this->contentProduct .= '<table class="CIR_TABLE"><tr>';
		foreach($this->links as $key => $value) {
			if ($key !== 'Leave') {
				$this->contentProduct .=<<<EOF
<td>
<a href="$value">
<svg class='CIR_SVG'>
<circle class='BIG_CIRCLE'></circle>
<circle class='SMALL_CIRCLE'></circle>
<text class='CIR_TEXT' x='90px' y='160px' font-size='50px' font-family='fantasy'>$key</text>
</svg>
</a>
</td>
EOF;
			}else {
				$this->contentProduct .=<<<EOF
<td>
<a href="$value">
<svg id='STU_LEAVE' class='CIR_SVG'>
<circle class='BIG_CIRCLE'></circle>
<circle class='SMALL_CIRCLE'></circle>
<text class='CIR_TEXT' x='80px' y='160px' font-size='50px' font-family='fantasy'>$key</text>
</svg>
</a>
</td>
EOF;
			}
		}
		$this->contentProduct .= '</tr></table>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

?>

