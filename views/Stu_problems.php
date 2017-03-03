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
	private $newest;
	private $item_number = array();

	private $hookup;
	
	public function getContent() {
		
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		try {
			$this->hookup = UniversalConnect::doConnect();				
			
			$stmt_newest = $this->hookup->prepare('SELECT item FROM problem WHERE showup=(SELECT MAX(showup) FROM problem)');
			$stmt_newest->execute();
			$row_newest = $stmt_newest->fetch(\PDO::FETCH_ASSOC);
			$this->newest = $row_newest['item'];
	
			$this->contentProduct .= '<table id=\'STU_CHOOSER_TABLE\'>';
			$stmt = $this->hookup->prepare('SELECT item, number FROM problem');	
			$stmt->execute();
			while ($row_item = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				$this->item_number[$row_item['item']] = $row_item['number'];
			}

			// Sort item buttons by show up time
			$first = false;
			foreach ($this->item_number as $key => $value) {
				if ($this->newest === $key || $first != false){
					$first = true;
				}
				else {
					continue;
				}
				$this->contentProduct .= '<tr><td><img class=\'PRE_IMG\' height=\'30\' width=\'30\' src=\'../public/tafree-svg/previous.svg\'><svg id=\'' . $key . '\' class=\'POLYGON_SVG\'></svg><input class=\'NUMBER_SUBITEM_HIDDEN\' type=\'hidden\' value=\'' . $value . '\'><img class=\'NEXT_IMG\' height=\'30\' width=\'30\' src=\'../public/tafree-svg/next.svg\'></td></tr>';	
			}
			foreach ($this->item_number as $key => $value) {
				if ($this->newest === $key){
					break;
				}
				$this->contentProduct .= '<tr><td><img class=\'PRE_IMG\' height=\'30\' width=\'30\' src=\'../public/tafree-svg/previous.svg\'><svg id=\'' . $key . '\' class=\'POLYGON_SVG\'></svg><input class=\'NUMBER_SUBITEM_HIDDEN\' type=\'hidden\' value=\'' . $value . '\'><img class=\'NEXT_IMG\' height=\'30\' width=\'30\' src=\'../public/tafree-svg/next.svg\'></td></tr>';	
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
