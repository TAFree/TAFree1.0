<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\database\UniversalConnect;
use TAFree\routes\SessionManager;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Fac_plagiarism implements Product {	

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
				$colspan = $row_prob['number'];
				$this->contentProduct .=<<<EOF
<table class='STU_SCORE_TABLE'>
<tr><th class='TITLE_TD' colspan='$colspan'>{$row_prob['item']}</tr>
<tr>
EOF;
				for ($i = 1; $i <= $row_prob['number']; $i += 1){
					$this->contentProduct .= '<td class=\'TITLE_TD\'>' . $i . '</td>';
				}

				$this->contentProduct .= '</tr>';
				
				for ($i = 1; $i <= $row_prob['number']; $i += 1){			
					$stmt_item = $this->hookup->prepare('SELECT classname FROM ' . $row_prob['item'] . '_' . $i);
					$stmt_item->execute();
					$this->contentProduct .= '<td class=\'CONTENT_TD\'>';
					while($row_item = $stmt_item->fetch(\PDO::FETCH_ASSOC)) {
						$this->contentProduct .= '<a class=\'CLICKABLE_LONG\' href=\'../controllers/Plagiarism.php?item=' . $row_prob['item'] . '&subitem=' . $i . '&classname=' . $row_item['classname'] . '\'>' . $row_item['classname'] . '</a>';
					}
					$this->contentProduct .= '</td>';
				}
				$this->contentProduct .= '</tr>';
					
				$this->contentProduct .= '</table>';
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

require_once('../routes/Dispatcher.php');

?>
