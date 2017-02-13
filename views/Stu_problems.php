<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\database\UniversalConnect;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Stu_problems implements Product {	

	private $formatHelper;
	private $contentProduct;
	
	private $hookup;
	
	public function getContent() {
		
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		try {
			$this->hookup = UniversalConnect::doConnect();				
			
			$stmt_newest = $this->hookup->prepare('SELECT item, number FROM problem WHERE showup=(SELECT MAX(showup) FROM problem)');
			$stmt_newest->execute();
			$row_newest = $stmt_newest->fetch(\PDO::FETCH_ASSOC);
			$this->contentProduct .= '<table id=\'NEWEST_TABLE\'><tr><th class=\'TITLE_TD\' colspan=\'' . $row_newest['number'] . '\'>' . $row_newest['item'] . '<img id=\'NEWEST_IMG\' src=\'../public/tafree-svg/flag.svg\'><br>(Today\'s lab assignment !)</th></tr><tr>';
			for ($i = 1; $i <= intval($row_newest['number']); $i += 1) {
				$this->contentProduct .= '<td class=\'CONTENT_TD\'><a class=\'NEWEST_A\' href=\'../views/Stu_problem.php?item=' . $row_newest['item'] . '&subitem=' . $i . '\'>' . $i . '</a></td>';
			}
			$this->contentProduct .= '</tr></table>';
			$this->contentProduct .= '<table id=\'STU_CHOOSER_TABLE\'>';
			$stmt = $this->hookup->prepare('SELECT item, number FROM problem');	
			$stmt->execute();
			while ($row_item = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				$this->contentProduct .= '<tr><td><img class=\'PRE_IMG\' height=\'30\' width=\'30\' src=\'../public/tafree-svg/previous.svg\'><svg id=\'' . $row_item['item'] . '\' class=\'POLYGON_SVG\'></svg><input class=\'NUMBER_SUBITEM_HIDDEN\' type=\'hidden\' value=\'' . $row_item['number'] . '\'><img class=\'NEXT_IMG\' height=\'30\' width=\'30\' src=\'../public/tafree-svg/next.svg\'></td></tr>';	
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
