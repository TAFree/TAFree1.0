<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\database\UniversalConnect;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');
require_once('../routes/SetRouter.php');

class Fac_score implements Product {	

	private $formatHelper;
	private $contentProduct;

	private $hookup;

	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();

		try {
			$this->hookup = UniversalConnect::doConnect();
			
			$stmt_prob = $this->hookup->prepare('SELECT item, number FROM problem');
			$stmt_prob->execute();
			while($row_prob = $stmt_prob->fetch(\PDO::FETCH_ASSOC)) {
				$colspan = $row_prob['number'] + 2;
				$this->contentProduct .=<<<EOF
<form method='POST' action='../fetchers/ScoreTar.php'>
<input type='hidden' name='item' value='{$row_prob['item']}'>
<table class='FAC_SCORE_TABLE'>
<tr><th class='TITLE_TD' colspan='$colspan'><p class='FAC_SCORE_P'>{$row_prob['item']}</p><input type='submit' class='CLICKABLE' value='Download'></th></tr>
<tr>
<td class='TITLE_TD'>Student Name</td>
<td class='TITLE_TD'>Student Account</td>
EOF;
				for ($i = 1; $i <= $row_prob['number']; $i += 1){
					$this->contentProduct .= '<td class=\'TITLE_TD\'>' . $i . '</td>';
				}

				$this->contentProduct .= '</tr>';
				
				$stmt_stu = $this->hookup->prepare('SELECT student_name, student_account FROM student');
				$stmt_stu->execute();
				while($row_stu = $stmt_stu->fetch(\PDO::FETCH_ASSOC)) {
					$this->contentProduct .= '<tr><td class=\'CONTENT_TD\'>' . $row_stu['student_name'] . '</td>';
					$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row_stu['student_account'] . '</td>';
					for ($i = 1; $i <= $row_prob['number']; $i += 1){			
						
						$stmt_item = $this->hookup->prepare('SELECT ' . $row_stu['student_account'] . ' FROM ' . $row_prob['item'] . ' WHERE subitem=\'' . $i . '\'');
						$stmt_item->execute();
						$row_item = $stmt_item->fetch(\PDO::FETCH_ASSOC);
						$score = ($row_item[$row_stu['student_account']] === 'AC') ? 1 : 0;
						$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $score . '</td>';
					}
					$this->contentProduct .= '</tr>';
				}	
				$this->contentProduct .= '</table></form>';
			}
	
			$this->hookup = null;
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}		
		
		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

$router->run();

?>
