<?php
namespace TAFree\models;

use TAFree\classes\IStrategy;
use TAFree\utils\Viewer;
use TAFree\database\UniversalConnect;

require_once('../composers/Autoloader.php');

class SourcePlagiarism implements IStrategy {
	
	private $item;
	private $subitem;
	private $classname;
	private $students = array();

	private $hookup;
	
	public function algorithm () {
		
		// Get item, subitem, classname
		$this->item = $_GET['item'];
		$this->subitem = $_GET['subitem'];
		$this->classname = $_GET['classname'];
		
		
		try {
			
			$this->hookup = UniversalConnect::doConnect();		
			
			// Get student list
			$stmt_stu = $this->hookup->prepare('SELECT student_account FROM student');
			$stmt_stu->execute();
			while ($row_stu = $stmt_stu->fetch(\PDO::FETCH_ASSOC)) {
				array_push($this->students, $row_stu['student_account']);
			}
			
			// Download student source codes per classname
			$stmt = $this->hookup->prepare('SELECT * FROM ' . $this->item . '_' . $this->subitem . ' WHERE classname=\'' . $this->classname . '\'');
			$stmt->execute();
			$row = $stmt->fetch(\PDO::FETCH_ASSOC); 
			for ($i = 0; $i < count($this->students); $i += 1) {
				$dir = '../tmp/' . uniqid(time(), true) . '_' . $this->classname;
				mkdir($dir);
				$filename = $dir . '/' . $this->students[$i];
				$handle = fopen($filename, 'w') or die('Unable to open file !');
				fwrite($handle, $row[$this->students[$i]]);
				fclose($handle);
			}
	
			$this->hookup = null;

			new Viewer('Msg', 'OK');

		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
	
	}	
		
}

?>

