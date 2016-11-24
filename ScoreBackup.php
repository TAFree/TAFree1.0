<?php 

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

function __autoload($class_name) {
	include_once($class_name . '.php');	
}

class ScoreBackup {
	
	private $item;
	private $handle;
	private $filename;
	private $fields = array();
	private $emails = array();

	public function __construct() {
		
		// Get item
		$this->item = $_SERVER['argv'][1];	  	
					
		$this->filename = './tar/' . uniqid(time(), true) . '-backup-' . $this->item . '.csv';
		$this->handle = fopen($this->filename, 'w');
		
		try {
			$this->hookup = UniversalConnect::doConnect();
			
			// Get faculty emails
			$stmt = $this->hookup->prepare('SELECT faculty_email FROM faculty');
			$stmt->execute();
			$i = 0;
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$this->emails[$i] = $row['faculty_email'];
				$i += 1;
			}

			// Configure csv file content		
			$stmt_prob = $this->hookup->prepare('SELECT item, number FROM problem WHERE item=\'' . $this->item . '\'');
			$stmt_prob->execute();
			while($row_prob = $stmt_prob->fetch(PDO::FETCH_ASSOC)) {
				array_push($this->fields, 'Student Name');
				array_push($this->fields, 'Student Account');
				for ($i = 1; $i <= $row_prob['number']; $i += 1){
					array_push($this->fields, $i);
				}
				fputcsv($this->handle, $this->fields);
				$this->fields = array();
				$stmt_stu = $this->hookup->prepare('SELECT student_name, student_account FROM student');
				$stmt_stu->execute();
				while($row_stu = $stmt_stu->fetch(PDO::FETCH_ASSOC)) {
					array_push($this->fields, $row_stu['student_name']);
					array_push($this->fields, $row_stu['student_account']);
					for ($i = 1; $i <= $row_prob['number']; $i += 1){			
						
						$stmt_item = $this->hookup->prepare('SELECT ' . $row_stu['student_account'] . ' FROM ' . $row_prob['item'] . ' WHERE subitem=\'' . $i . '\'');
						$stmt_item->execute();
						$row_item = $stmt_item->fetch(PDO::FETCH_ASSOC);
						$score = ($row_item[$row_stu['student_account']] === 'AC') ? 1 : 0;
						array_push($this->fields, $score);
					}
					fputcsv($this->handle, $this->fields);
					$this->fields = array();				
				}	
			}
	
			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}		
		
		fclose($this->handle);
		
		// Send email to faculty
		foreach ($this->emails as $email) {
			system('echo \'This is a score backup sent from TAFree.\' | mail -s \'Score Backup\' -A ' . $this->filename . ' ' . $email, $retval);
		}
		
		sleep(30);
	
		// Remove backup file
		unlink($this->filename);
	}

}

$worker = new ScoreBackup();

?>

