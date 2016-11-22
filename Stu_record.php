<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload ($class_name) {
	include_once($class_name . '.php');
}

class Stu_record implements Product {	

	private $formatHelper;
	private $contentProduct;

	private $stu_account;

	private $hookup;

	public function getContent() {
		
		$this->stu_account = $_SESSION['student'];

		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();

		try {
			$this->hookup = UniversalConnect::doConnect();
			
			$stmt_prob = $this->hookup->prepare('SELECT item, number, showup FROM problem');
			$stmt_prob->execute();
			while($row_prob = $stmt_prob->fetch(PDO::FETCH_ASSOC)) {
				$colspan = 3;
				$this->contentProduct .=<<<EOF
<table class='STU_RECORD_TABLE'>
<tr><th class='TITLE_TD' colspan='$colspan'>{$row_prob['item']}</tr>
EOF;
				$this->contentProduct .= '<tr><td class=\'TITLE_TD\'>Open</td>';
				$this->contentProduct .= '<td colspan=\'2\' class=\'CONTENT_TD\'>' . $row_prob['showup'] . '</td></tr>';
				
				for ($i = 1; $i <= $row_prob['number']; $i += 1){
					$this->contentProduct .= '<tr><td class=\'TITLE_TD\'>' . $i . '</td>';
					$stmt_item = $this->hookup->prepare('SELECT ' . $this->stu_account . ' FROM ' . $row_prob['item'] . ' WHERE subitem=\'' . $i . '\'');
					$stmt_item->execute();
					$row_item = $stmt_item->fetch(PDO::FETCH_ASSOC);
					$status = $row_item[$this->stu_account];
					$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $status . '</td>';
					if ($status !== 'NULL') {
						$this->contentProduct .= '<td class=\'CONTENT_TD\'><input type=\'hidden\' value=\'' . $this->stu_account . '\'><input type=\'button\' class=\'CLICKABLE\' value=\'Download\'></td>';
					}
					else {
						$this->contentProduct .='<td class=\'CONTENT_TD\'></td>';
					}
					$this->contentProduct .= '</tr>';
				
				}

				
				for ($i = 1; $i <= $row_prob['number']; $i += 1){			
				}
					
				$this->contentProduct .= '</table>';
			}
	
			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}		
		
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
