<?php

class ProblemQualify {
	
	private $item;
	private $item_num;
	private $subitem;

	private $hookup;
	
	public function __construct () {
		
		// Get item, subitem
		$this->item = $_POST['item'];
		$this->subitem = $_POST['subitem'];

		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			// Update subitem table
			$this->updateSubitem();
		
			// Test judge script for it basic tasks
			new Viewer('Fac_verify', $this->item . '_' . $this->subitem);
/*			
	public function cloneJudge () {
		
		// Clone judge file from ./judge to ./problem/judge/[item]/[subitem] 
		if (!copy('./judge/' . $this->judge, './problem/judge/' . $this->item . '/' . $this->subitem . '/' . $this->judge)) {
			new Viewer ('Msg', $this->judge . ' copy failed...');
			exit();
		}
	}
*/
/*	
			// Check other subitem tables for changing problem status into 'Available'
			if ($this->areAllFinished()) {
				$trigger = new DBOperator();
				$trigger->colorProblem($this->item, 'Available');
			}
*/			
			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}

//		new Viewer('Msg', $this->item . '_' . $this->subitem . ' already handout !' . '<br>' . 'Make sure this is final version or not to give students writing permission.');
		
	}
	
	public function areAllFinished () {
		$stmt_num = $this->hookup->prepare('SELECT number FROM problem WHERE item=\'' . $this->item . '\'');
		$stmt_num->execute();
		$this->item_num = $stmt_num->fetch(PDO::FETCH_ASSOC)['number'];
			
		for ($i = 1; $i <= $this->item_num; $i += 1) {
			$stmt_subitem = $this->hookup->prepare('SELECT modified_source FROM ' . $this->item . '_' . $i);
			$stmt_subitem->execute();
			if ($stmt_subitem->rowCount() === 0) {
				return false;
			}
		}
		return true;
	}
}

?>

