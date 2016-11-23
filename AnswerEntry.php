<?php

class AnswerEntry implements IStrategy {
	
	private $item;
	private $subitem;
	private $stu_account;
	private $judge_script;
	private $judge_ext;
	private $judge_cmd;
	private $result;
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
			
			// Get judge_script
			$stmt = $this->hookup->prepare('SELECT judgescript FROM ' . $this->item . ' WHERE subitem=\'' . $this->subitem . '\'');
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->judge_script = $row['judgescript'];

			// Get judge_ext
			$this->judge_ext = substr($this->judge_script, strrpos($this->judge_script, '.') + 1);
			
			// Get judge_cmd
			$stmt = $this->hookup->prepare('SELECT cmd FROM support WHERE ext=\'' . $this->judge_ext . '\'');
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->judge_cmd = $row['cmd'];
			
			$this->hookup = null;

		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
		// Start judge process and get its return view
		$this->result = system($this->judge_cmd . ' ' . './problem/judge/' . $this->item . '/' . $this->subitem . '/' . $this->judge_script . ' ' . $this->stu_account, $retval);
		if ($retval !== 0) {
			new Viewer('Msg', 'Judge process error... (status: ' . $retval . ')');
			exit();
		}else {
			new Viewer('Msg', $this->result);
			exit();
		}

	}

	public function mergeSource ($content) {
		$source;
		$filename = './tar/' . uniqid(time(), true) . '-source.tmp';
		$handle = fopen($filename, 'w');
		foreach ($content as $key => $value) {
			fwrite($handle, $value . '\n');
		}
		fclose($handle);
		if (file_exists($filename)) {
			$source = file_get_contents($filename);
			unlink($filename);
		}
		else {
			new Viewer('Msg', 'Temporaey file is missing...');
		}
		return $source;
	}
	
}

?>

