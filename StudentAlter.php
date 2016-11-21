<?php
	
include_once('Util.php');

class StudentAlter implements IStrategy {
	
	private $del_accs = array();
	private $add_names = array();
	private $add_accs = array();
	private $add_passs = array();
	
	private $hookup;
	
	public function algorithm () {
		
		if (isset($_POST['submit'])) {
	
			// Get deleted list
			if(isset($_POST['del_account'])) {
				$this->del_accs = $_POST['del_account'];
			}
			else{
				$this->del_accs = null;
			}
			
			// Get added list
			$add_names = $_POST['add_name'];
			$add_accs = $_POST['add_account'];
			$add_passs = $_POST['add_password'];
			// i = 0 is hidden row
			for ($i = 1; $i < count($add_names); $i += 1 ) {
				
				$this->add_names[$i - 1] = Util::fixInput($add_names[$i]);
				
				if (Util::anFilter($add_accs[$i])) {
					$this->add_accs[$i - 1] = $add_accs[$i];
				}
				else {
					new Viewer ('Msg', $add_accs[$i] .  ' is not only alphabet or number...' . '<br>');
					exit();

				}
				
				if (Util::anFilter($add_passs[$i])) {
					$this->add_passs[$i - 1] = $add_passs[$i];
				}
				else {
					new Viewer ('Msg', $add_passs[$i] .  ' is not only alphabet or number...' . '<br>');	
					exit();
				}
			}
				
			try {
				$this->hookup = UniversalConnect::doConnect();
				
				// Delete student
				$this->deleteStudent();

				// Add student
				$this->addStudent();
				
				$this->hookup = null;
				
				new Viewer ('Msg', 'Successfully altered tables !' . '<br>');
			
			}
			catch (PDOException $e) {
				echo 'Error: ' . $e->getMessage() . '<br>';
			}
				
		}

		
		
	}

	public function deleteStudent() {
		
		// column of closeup & row of student
		for ($i = 0; $i < count($this->del_accs); $i += 1) {
			$stmt_del_closeup = $this->hookup->prepare('ALTER TABLE closeup DROP COLUMN ' . $this->del_accs[$i]);
			$stmt_del_closeup->execute();
			$stmt_del_student = $this->hookup->prepare('DELETE FROM student WHERE student_account=\'' . $this->del_accs[$i] . '\'');
			$stmt_del_student->execute();
		}
		
		// column of items & subitems
		$stmt_item = $this->hookup->prepare('SELECT item FROM problem');
		while($row_item = $stmt_item->fetch(PDO::FETCH_ASSOC)){
			$item = $row_item['item'];
			$stmt_del_item = $this->hookup->prepare('ALTER TABLE ' . $item . ' DROP COLUMN ' . $this->del_accs[$i]);
			$stmt_del_item->execute();
			$stmt_subitem = $this->hookup->prepare('SELECT subitem FROM ' . $item);
			while ($row_subitem = $stmt_subitem->fetch(PDO::FETCH_ASSOC)) {
				$subitem = $row_subitem['subitem'];	
				for ($i = 0; $i < count($this->del_accs); $i += 1) {
					$stmt_del_subitem = $this->hookup->prepare('ALTER TABLE ' . $item . '_' . $subitem . ' DROP COLUMN ' . $this->del_accs[$i]);
					$stmt_del_subitem->execute();
				}
			}
		}
	}

	public function addStudent() {
		// column of closeup & row of student	
		for ($i = 0; $i < count($this->add_accs); $i += 1) {
			$stmt_add_closeup = $this->hookup->prepare('ALTER TABLE closeup ADD ' . $this->add_accs[$i] . ' DATETIME DEFAULT NULL');
			$stmt_add_closeup->execute();
			$stmt_add_student = $this->hookup->prepare('INSERT INTO student(student_name, student_account, student_password) VALUES(:student_name, :student_account, :student_password)');
			
			$stmt_add_student->bindParam(':student_name', $name);
			$stmt_add_student->bindParam(':student_account', $account);
			$stmt_add_student->bindParam(':student_password', $password);
			$name = $this->add_names[$i];
			$account = $this->add_accs[$i];
			$password = $this->add_passs[$i];
			$stmt_add_student->execute();
		
		}
		// column of items & subitems
		for ($j = 0; $j < count($this->add_accs); $j += 1) {	
			$stmt_item = $this->hookup->prepare('SELECT item, number FROM problem');
			$stmt_item->execute();
			while($row_item = $stmt_item->fetch(PDO::FETCH_ASSOC)){
				$item = $row_item['item'];
				$stmt_add_item = $this->hookup->prepare('ALTER TABLE ' . $item . ' ADD ' . $this->add_accs[$j] . ' VARCHAR(30) NOT NULL DEFAULT "NULL"');
				$stmt_add_item->execute();
				for ($k = 1; $k <= $row_item['number']; $k += 1) {
					$stmt_add_subitem = $this->hookup->prepare('ALTER TABLE ' . $item . '_' . $k . ' ADD ' . $this->add_accs[$j] . ' TEXT');
					$stmt_add_subitem->execute();
				}
			}
		}
		
	}
	
}

?>
