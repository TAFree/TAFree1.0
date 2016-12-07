<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\database\UniversalConnect;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Fac_problems implements Product {	

	private $formatHelper;
	private $contentProduct;
	
	private $hookup;
	
	public function getContent() {
		
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		$this->contentProduct .= '<table id=\'FAC_CHOOSER_TABLE\'>';
		try {
			// Load items
			$this->hookup = UniversalConnect::doConnect();
			$stmt_items = $this->hookup->prepare('SELECT item, number, status FROM problem');	
			$stmt_items->execute();
			while ($row_item = $stmt_items->fetch(\PDO::FETCH_ASSOC)) {
				// Setup item time	
				$this->contentProduct .=<<<EOF
<tr class='ITEM_TR'>
<td>
<img class='ITEM_STATUS_IMG' title='{$row_item['status']}' height='50' width='50'>
<br>
<br>
Pages will show up at 
<input type='date'>
<input type='number' min='0' max='23' value='00'>&nbsp;:&nbsp;
<input type='number' min='0' max='59' value='00'>
<br>
<br>
Pages will close up at 
<input type='date'>
<input type='number' min='0' max='23' value='00'>&nbsp;:&nbsp;
<input type='number' min='0' max='59' value='00'>
<br>
<br>
Score will back up at 
<input type='date'>
<input type='number' min='0' max='23' value='00'>&nbsp;:&nbsp;
<input type='number' min='0' max='59' value='00'>
<br>
<br>
<input type='button' class='SETUP_BUTTON' value='Setup'>
</td>
EOF;
				$this->contentProduct .= '<td><img class=\'PRE_IMG\' height=\'30\' width=\'30\' src=\'../public/tafree-svg/previous.svg\'><svg id=\'' . $row_item['item'] . '\' class=\'POLYGON_SVG\'></svg><input class=\'NUMBER_SUBITEM_HIDDEN\' type=\'hidden\' value=\'' . $row_item['number'] . '\'><img class=\'NEXT_IMG\' height=\'30\' width=\'30\' src=\'../public/tafree-svg/next.svg\'></td></tr>';
			
				// Load student list
				$this->contentProduct .= '<tr><td colspan=\'2\'><table class=\'PRESENT_TABLE\'>';
				$this->contentProduct .= '<tr><th>Student Name</th><th>Student Account</th><th>Closeup Time</th><th>Present</th></tr>';
				$stmt_students = $this->hookup->prepare('SELECT * FROM student');
				$stmt_students->execute();
				while ($row_stu = $stmt_students->fetch(\PDO::FETCH_ASSOC)) {
					$this->contentProduct .= '<tr>';
					$this->contentProduct .= '<td>' . $row_stu['student_name'] . '</td>';
					$this->contentProduct .= '<td>' . $row_stu['student_account'] . '</td>'; 
					$stmt_closeup = $this->hookup->prepare('SELECT * FROM closeup WHERE item=\'' . $row_item['item'] . '\'');
					$stmt_closeup->execute();
					$row_time = $stmt_closeup->fetch(\PDO::FETCH_ASSOC);
					$this->contentProduct .= '<td>' . $row_time[$row_stu['student_account']] . '</td>';
					if ($row_time[$row_stu['student_account']] === null) {
						$this->contentProduct .= '<td><input type=\'checkbox\' class=\'HERE_CHECKBOX\'><img src=\'../public/tafree-svg/unknown.svg\' height=\'15\' width=\'15\'></td>';
					}else{
						$this->contentProduct .= '<td><input type=\'checkbox\' class=\'HERE_CHECKBOX\' checked=\'true\'><img src=\'../public/tafree-svg/right.svg\' height=\'15\' width=\'15\'></td>';
					}
					$this->contentProduct .= '</tr>';
				}
				$this->contentProduct .= '</table></td></tr>';
			}
		}	
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		$this->contentProduct .= '</table>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;	
	}	 

}

require_once('../routes/Dispatcher.php');

?>
