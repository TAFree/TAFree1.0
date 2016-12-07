<?php 
namespace TAFree\fetchers;

use TAFree\classes\IStrategy;
use TAFree\database\UniversalConnect;
use TAFree\downloader\Loader;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class ScoreTar {
	
	private $item;
	private $handle;
	private $filename;
	private $fields;

	public function __construct() {
		
		// Get item
		$this->item = $_POST['item'];	
		
		// Configure csv file content		
		
		$this->filename = '../tar/' . uniqid(time(), true) . '-score-' . $this->item . '.csv';
		$this->handle = fopen($this->filename, 'w');
		
		try {
			$this->hookup = UniversalConnect::doConnect();
			
			$stmt_prob = $this->hookup->prepare('SELECT item, number FROM problem WHERE item=\'' . $this->item . '\'');
			$stmt_prob->execute();
			$row_prob = $stmt_prob->fetch(\PDO::FETCH_ASSOC);
			$this->fields = array();
			$student_name = 'Student Name';
			$student_account = 'Student Account';
			array_push($this->fields, $student_name);
			array_push($this->fields, $student_account);
			for ($i = 1; $i <= $row_prob['number']; $i += 1){
				array_push($this->fields, $i);
			}
			fputcsv($this->handle, $this->fields);
			$this->fields = array();
			$stmt_stu = $this->hookup->prepare('SELECT student_name, student_account FROM student');
			$stmt_stu->execute();
			while($row_stu = $stmt_stu->fetch(\PDO::FETCH_ASSOC)) {
				array_push($this->fields, $row_stu['student_name']);
				array_push($this->fields, $row_stu['student_account']);
				for ($i = 1; $i <= $row_prob['number']; $i += 1){			
					
					$stmt_item = $this->hookup->prepare('SELECT ' . $row_stu['student_account'] . ' FROM ' . $row_prob['item'] . ' WHERE subitem=\'' . $i . '\'');
					$stmt_item->execute();
					$row_item = $stmt_item->fetch(\PDO::FETCH_ASSOC);
					$score = ($row_item[$row_stu['student_account']] === 'AC') ? 1 : 0;
					array_push($this->fields, $score);
				}
				fputcsv($this->handle, $this->fields);
				$this->fields = array();				
			}	
			
	
			$this->hookup = null;
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}		
		
		fclose($this->handle);
		
		// Download file
		$loader = new Loader($this->filename);
		$loader->download();
	}

}

require_once('../routes/Dispatcher.php');

?>

