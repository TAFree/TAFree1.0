<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');	
}

class Fac_chooser implements Product {	

	private $formatHelper;
	private $contentProduct;
	
	private $hookup;
	
	public function getContent() {
		
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
				
		$this->contentProduct .= '<table class=\'SETUP_TIME_TABLE\'>';
		try {
			// Load items
			$this->hookup = UniversalConnect::doConnect();
			$stmt_items = $this->hookup->prepare('SELECT item, number FROM problem');	
			$stmt_items->execute();
			while ($row_item = $stmt_items->fetch(PDO::FETCH_ASSOC)) {
				// Setup item time	
				$this->contentProduct .=<<<EOF
<tr>
<td>
Page will show up at 
<input type='date'>
<input type='number' min='0' max='23' value='00'>&nbsp;:&nbsp;
<input type='number' min='0' max='59' value='00'>
<br>
Page will close up at 
<input type='date'>
<input type='number' min='0' max='23' value='00'>&nbsp;:&nbsp;
<input type='number' min='0' max='59' value='00'>
<br>
Score will back up at 
<input type='date'>
<input type='number' min='0' max='23' value='00'>&nbsp;:&nbsp;
<input type='number' min='0' max='59' value='00'>
<br>
<br>
<input type='button' value='Setup'>
</td>
EOF;
				$this->contentProduct .= '<td><svg id=\'' . $row_item['item'] . '\' class=\'POLYGON_SVG\'></svg><input class=\'NUMBER_SUBITEM_HIDDEN\' type=\'hidden\' value=\'' . $row_item['number'] . '\'></td></tr>';
			
				// Load student list
				$this->contentProduct .= '<tr><td colspan=\'2\'><table class=\'PRESENT_TABLE\'>';
				$this->contentProduct .= '<tr><th>Student Name</th><th>Student Account</th><th>Closeup Time</th><th>Present</th></tr>';
				$stmt_students = $this->hookup->prepare('SELECT * FROM student');
				$stmt_students->execute();
				while ($row_stu = $stmt_students->fetch(PDO::FETCH_ASSOC)) {
					$this->contentProduct .= '<tr>';
					$this->contentProduct .= '<td>' . $row_stu['student_name'] . '</td>';
					$this->contentProduct .= '<td>' . $row_stu['student_account'] . '</td>'; 
					$stmt_closeup = $this->hookup->prepare('SELECT * FROM closeup WHERE item=\'' . $row_item['item'] . '\'');
					$stmt_closeup->execute();
					$row_time = $stmt_closeup->fetch(PDO::FETCH_ASSOC);
					$this->contentProduct .= '<td>' . $row_time[$row_stu['student_account']] . '</td>';
					$this->contentProduct .= '<td><input type=\'checkbox\'>Here!</td>';
					$this->contentProduct .= '</tr>';
				}
				$this->contentProduct .= '</table></td></tr>';
			}
		}	
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		$this->contentProduct .= '</table>';

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
