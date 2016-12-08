<?php
namespace TAFree\models;

use TAFree\classes\Checker;
use TAFree\database\UniversalConnect;

require_once('../composers/Autoloader.php');

class ProblemChecker extends Checker {
	
	private $item;
	private $item_num;

	private $hookup;
	
	public function query ($context) {
		
		$this->item = $context['item'];
		
		try {
			$this->hookup = UniversalConnect::doConnect();						
			$stmt_num = $this->hookup->prepare('SELECT number FROM problem WHERE item=\'' . $this->item . '\'');
			$stmt_num->execute();
			$this->item_num = $stmt_num->fetch(\PDO::FETCH_ASSOC)['number'];
				
			for ($i = 1; $i <= $this->item_num; $i += 1) {
				$stmt_subitem = $this->hookup->prepare('SELECT modified_source FROM ' . $this->item . '_' . $i);
				$stmt_subitem->execute();
				if ($stmt_subitem->rowCount() === 0) {
					return false;
				}
			}
			return true;
					
			$this->hookup = null;
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
	
	}

}

?>

