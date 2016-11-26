<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

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
				
				$stmt = $this->hookup->prepare('UPDATE ' . $this->item . '_' . $this->subitem . ' SET ' . $this->stu_account . '=:source WHERE classname=:classname');
				
			
				$stmt->bindParam(':source', $source);
				$stmt->bindParam(':classname', $classname);

				$classname = $pkg->classname;
				$content = $pkg->source;
				
				if (is_array($content)) {
					$source = $this->mergeSource($content);
				}
				else if ($content === 'Locked'){
					
					$stmt = $this->hookup->prepare('SELECT original_source FROM ' . $this->item . '_' . $this->subitem . ' WHERE classname=\'' . $classname . '\'');
					$stmt->execute();	
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					$source = $row['original_source'];
			
				}

				$stmt->execute();	
			
			}
				
			$this->hookup = null;
			
			echo true;

		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}

	public function mergeSource ($content) {

		$filename = './tar/' . uniqid(time(), true) . '-source.tmp';
		$tmp_res = fopen($filename, 'w');
		fclose($tmp_res);

		foreach ($content as $key => $value) {
			$line = $value . PHP_EOL;
			file_put_contents($filename, $line, FILE_APPEND);
		}
		
		$resource = fopen($filename, 'r');
		$source = fread($resource, filesize($filename));
		fclose($resource);

		unlink($filename);

		return $source;
	}

}

?>

