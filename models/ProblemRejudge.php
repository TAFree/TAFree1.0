<?php
namespace TAFree\models;

use TAFree\classes\IStrategy;
use TAFree\utils\Viewer;
use TAFree\database\UniversalConnect;

require_once('../composers/Autoloader.php');

class ProblemRejudge implements IStrategy {
	
	private $item;
	private $subitem;

	private $hookup;
	
	public function algorithm () {
		
		// Get item, subitem
		if (empty($_POST['item']) || empty($_POST['subitem'])){
			new Viewer ('Msg', 'Forgot to type item or subitem...' . '<br>');
			exit();
		}		
		else {
			$this->item = $_POST['item'];
			$this->subitem = $_POST['subitem'];
		
		}
		
		try {
			
			$this->hookup = UniversalConnect::doConnect();		
			$stmt_stu = $this->hookup->prepare('SELECT student_account FROM student');
			$stmt_stu->execute();
			
			while ($row = $stmt_stu->fetch(\PDO::FETCH_ASSOC)) {			
				$stmt = $this->hookup->prepare('UPDATE process SET judger=NULL WHERE item=:item AND subitem=:subitem AND student_account=\'' . $row['student_account'] . '\' ORDER BY id DESC LIMIT 1');
				$stmt->bindParam(':item', $this->item);
				$stmt->bindParam(':subitem', $this->subitem);
				$stmt->execute();
			}
	
			$this->hookup = null;

			new Viewer('Msg', 'Re-judge ' . $this->item . '_' . $this->subitem . 'now... <br> Please check dashboard !');

		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
	
	}
		
}

?>

