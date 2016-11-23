<?php

class AnswerEntry implements IStrategy {
	
	private $item;
	private $subitem;
	private $stu_account;
	private $stu_source;

	private $hookup;
	
	public function algorithm () {
		
		$data = file_get_contents('php://input'); 
		$obj = json_decode($data); 
		
		// Get item, subitem, stu_account, stu_source
		$this->item = $obj->item;
		$this->subitem = $obj->subitem;
		$this->stu_account = $obj->stu_account;
		$this->stu_source = $obj->stu_source;
	
		try {
			$this->hookup = UniversalConnect::doConnect();						
		
			// Update item_subitem
			foreach ($this->stu_source as $id => $pkg) {
				
				$classname = $pkg->classname;
				$content = $pkg->source;
				$source;
				
				if (is_array($content)) {
					$source = $this->mergeSource($content);
				}
				else if ($content === 'Locked'){
					
					$stmt = $this->hookup->prepare('SELECT original_source FROM ' . $this->item . '_' . $this->subitem . ' WHERE classname=\'' . $classname . '\'');
					$stmt->execute();	
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					$source = $row['original_source'];
			
				}

				$stmt = $this->hookup->prepare('UPDATE ' . $this->item . '_' . $this->subitem . ' SET ' . $this->stu_account . '=\'' . $source . '\' WHERE classname=\'' . $classname . '\'');
				$stmt->execute();	
			
			}
				
			$this->hookup = null;

		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}

}

?>

