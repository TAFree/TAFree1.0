<?php

class AnswerEntry implements IStrategy {
	
	private $item;
	private $subitem;
	private $stu_account;
	private $judge;
	private $result;
	private $classnames = array();
	private $stu_sources = array();

	private $hookup;
	
	public function algorithm () {
		
		// Get item, subitem, stu_account
		$this->item = $_POST['item'];
		$this->subitem = $_POST['subitem'];
		$this->stu_account = $_POST['stu_account'];

		// Get classnames, stu_sources
		$this->classnames = $_POST['classnames'];
		$this->stu_sources = $_POST['stu_sources'];
		
		try {
			$this->hookup = UniversalConnect::doConnect();						
		
			// Insert item_subitem
			for ($i = 0; $i < count($this->classnames); $i += 1) {
				$stmt = $this->hookup->prepare('UPDATE ' . $this->item . '_' . $this->subitem . ' SET ' . $this->stu_account . '=\'' . $this->stu_sources[$i] . '\' WHERE classname=\'' . $this->classnames[$i] . '\'');
				$stmt->execute();	
			}
			
			// Get judge
			$stmt = $this->hookup->prepare('SELECT judgescript FROM ' . $this->item . ' WHERE subitem=\'' . $this->subitem . '\'');
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->judge = $row['judgescript'];

			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
		// Start judge process and get its return view
		
		
		$this->result = system(, $retval);
		
		if ($retval !== 0) {
			new Viewer('Msg', 'Judge process error... (status: ' . $retval . ')');
			exit();
		}else {
			new Viewer('Msg', $this->result);
			exit();
		}

	}
	
}

?>

