<?php
namespace TAFree\models;

use TAFree\classes\IStrategy;
use TAFree\utils\Viewer;
use TAFree\database\UniversalConnect;
use TAFree\tools\Moss;

require_once('../composers/Autoloader.php');

class PlagiarismDetector implements IStrategy {
	
	private $item;
	private $subitem;
	private $classname;
	private $ext;
	private $userid = '628150037';
	private $students = array();
	private $response_addr;

	private $hookup;
	
	public function algorithm () {
		
		// Get item, subitem, classname, ext
		$this->item = $_GET['item'];
		$this->subitem = $_GET['subitem'];
		$this->classname = $_GET['classname'];
		$this->ext = substr($this->classname, strrpos($this->classname, '.') + 1);
		
		try {
			
			$this->hookup = UniversalConnect::doConnect();		
			
			// Get student list
			$stmt_stu = $this->hookup->prepare('SELECT student_account FROM student');
			$stmt_stu->execute();
			while ($row_stu = $stmt_stu->fetch(\PDO::FETCH_ASSOC)) {
				array_push($this->students, $row_stu['student_account']);
			}
			
			// Configure Moss submission
			$moss = new Moss($this->userid);
			$moss->setLanguage($this->ext);

			// Download student source codes
			$stmt = $this->hookup->prepare('SELECT * FROM ' . $this->item . '_' . $this->subitem . ' WHERE classname=\'' . $this->classname . '\'');
			$stmt->execute();
			$row = $stmt->fetch(\PDO::FETCH_ASSOC); 
			$this->hookup = null;
			$dir = '../tmp/file-' . uniqid(time(), true);
			mkdir($dir);
			for ($i = 0; $i < count($this->students); $i += 1) {
				$filename = $dir . '/' . $this->students[$i];
				$handle = fopen($filename, 'w') or die('Unable to open file !');
				fwrite($handle, $row[$this->students[$i]]);
				fclose($handle);	
				$moss->addFile($filename);
			}
			$moss->setCommentString('Find copies of ' . $this->classname . ' in ' . $this->item . '_' . $this->subitem);
			
			// Send to Moss 
			$this->response_addr = $moss->send();
			
			// Remove student source codes
			system('rm -rf ' . $dir, $retval);

			// Redirect to Moss response
			header ('Location: ' . $this->response_addr);
			exit();

		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
	
	}	
		
}

?>

