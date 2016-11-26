<?php
	
include_once('Util.php');

class RawDataEntry implements IStrategy {
	
	private $items = array();
	private $item_nums = array();
	private $fac_names = array();
	private $fac_accs = array();
	private $fac_passs = array();
	private $fac_emails = array();
	private $stu_names = array();
	private $stu_accs = array();
	private $stu_passs = array();
	
	private $hookup;
	
	public function algorithm () {
		
		if (isset($_POST['submit'])) {
	
			// Get items
			$items = $_POST['item'];
			$item_nums = $_POST['item_num'];
			// i = 0 is hidden row
			for ($i = 1; $i < count($items); $i += 1 ) {
				
				if (Util::anFilter($items[$i])) {
					$this->items[$i - 1] = $items[$i];
				}
				else {
					new Viewer ('Msg', $items[$i] .  ' is not only alphabet or number...' . '<br>');
					exit();

				}
				
				if (Util::intFilter($item_nums[$i])) {
					$this->item_nums[$i - 1] = $item_nums[$i];
				}
				else {
					new Viewer('Msg', $item_nums[$i] . ' is not an integer...' . '<br>');
					exit();
				}
			}
			
			// Get faculty list
			$fac_names = $_POST['fac_name'];
			$fac_accs = $_POST['fac_acc'];
			$fac_passs = $_POST['fac_pass'];
			$fac_emails = $_POST['fac_email'];
			// i = 0 is hidden row
			for ($i = 1; $i < count($fac_names); $i += 1 ) {
				
				$this->fac_names[$i - 1] = Util::fixInput($fac_names[$i]);
				
				if (Util::anFilter($fac_accs[$i])) {
					$this->fac_accs[$i - 1] = $fac_accs[$i];
				}
				else {
					new Viewer ('Msg', $fac_accs[$i] .  ' is not only alphabet or number...' . '<br>');
					exit();

				}
				
				if (Util::anFilter($fac_passs[$i])) {
					$this->fac_passs[$i - 1] = $fac_passs[$i];
				}
				else {
					new Viewer ('Msg', $fac_passs[$i] .  ' is not only alphabet or number...' . '<br>');	
					exit();
				}

				if (Util::mailFilter($fac_emails[$i])) {
					$this->fac_emails[$i - 1] = $fac_emails[$i];
				}
				else {
					new Viewer ('Msg', $fac_emails[$i] . 'is not a valid email...' . '<br>');
					exit();
				}
		
			}
			
			// Get student list
			$tmp_name = $_FILES['stu_list']['tmp_name'];
			$basename = basename($_FILES['stu_list']['name']);
			$dir = './tmp';
			if (!move_uploaded_file($tmp_name, $dir . '/' . $basename)){
				new Viewer ('Msg', $basename . ' is not uploaded...');
				exit();
			}
			else{
				$file = fopen($dir . '/' . $basename, 'r');	
		
				$i = 0;	
				while (!feof($file)) {
					
					$row = fgetcsv($file);
					
					$this->stu_names[$i] = $row[0];
					
					if (Util::anFilter($row[1])) {
						$this->stu_accs[$i] = $row[1];
					}
					else {
						new Viewer ('Msg', $row[1] . ' is not only alphabet or number...' . '<br>');
						fclose($file);
						unlink($dir . '/' . $basename);
						exit();
					}

					
					if (Util::anFilter($row[2])) {
						$this->stu_passs[$i] = $row[2];
					}
					else {
						new Viewer ('Msg', $row[2] . ' is not only alphabet or number...' . '<br>');
						fclose($file);
						unlink($dir . '/' . $basename);
						exit();
					}
					
					$i += 1;
				}
				fclose($file);
				unlink($dir . '/' . $basename);
				
				try {
					// Manipulate tables
					$this->hookup = UniversalConnect::doConnect();
					
					// Delete tables
					$this->deleteTable();
					
					// Create tables
					$this->createTable();

					// Insert tables
					$this->insertTable();

					$this->hookup = null;

					// Create directories if they do not exist 
					if (!file_exists('./tmp')) {
						mkdir('./tmp');
					}
					if (!file_exists('./tar')) {
						mkdir('./tar');
					}
					if (!file_exists('./process')) {
						mkdir('./process');
					}
					if (!file_exists('./problem')) {
						mkdir('./problem');
					}
					if (!file_exists('./problem/judge')) {
						mkdir('./problem/judge');
					}
					if (!file_exists('./problem/testdata')) {
						mkdir('./problem/testdata');
					}
					if (!file_exists('./problem/description')) {
						mkdir('./problem/description');
					}
					if (!file_exists('./judge')) {
						mkdir('./judge');
					}

					// Delete problem directories	
					$delete_dir_msg = system('rm -rf ./problem/description/* ./problem/judge/* ./problem/testdata/*', $retval);
					if ($retval !== 0) {
						new Viewer ('Msg', $delete_dir_msg);
						exit();
					}
					// Create problem directories
					for ($i = 0; $i < count($this->items); $i += 1) {
						mkdir('./problem/description/' . $this->items[$i]);
						mkdir('./problem/judge/' . $this->items[$i]);
						mkdir('./problem/testdata/' . $this->items[$i]);
						for ($j = 1; $j <= $this->item_nums[$i]; $j += 1) {
							mkdir('./problem/description/' . $this->items[$i] . '/' . $j);
							mkdir('./problem/judge/' . $this->items[$i] . '/' . $j);
							mkdir('./problem/testdata/' . $this->items[$i] . '/' . $j);
						}
					}

					new Viewer ('Msg', 'Successful initialization !' . '<br>');

					
				}
				catch (PDOException $e) {
					echo 'Error: ' . $e->getMessage() . '<br>';
					exit();
				}
									
			}

		}
		
	}

	public function createTable () {

		// student, faculty, problem, apply, support, discussion
		$sql = '';
		$sql .= 'CREATE TABLE student(
			student_name VARCHAR(30),
			student_account VARCHAR(20),
			student_password VARCHAR(20),
			PRIMARY KEY(student_account)	
		);';	
		$sql .= 'CREATE TABLE faculty(
			faculty_name VARCHAR(30),
			faculty_account VARCHAR(20),
			faculty_password VARCHAR(20),
			faculty_email VARCHAR(50),
			PRIMARY KEY(faculty_account)	
		);';
		$sql .= 'CREATE TABLE problem(
			item VARCHAR(50),
			number TINYINT(20) UNSIGNED DEFAULT 1,
			showup DATETIME DEFAULT NULL,
			backup DATETIME DEFAULT NULL,
			status VARCHAR(30) NOT NULL DEFAULT "Uninitialized",
			unique_key VARCHAR(50),
			PRIMARY KEY(item)	
		);';
		$sql .= 'CREATE TABLE discussion(
			id INT NOT NULL AUTO_INCREMENT,
			timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			subject VARCHAR(50),
			message TEXT(500),	
			PRIMARY KEY(id)
		);';		
		$sql .= 'CREATE TABLE support(
			ext VARCHAR(50),
			cmd VARCHAR(100),
			PRIMARY KEY(ext)	
		);';		
		$sql .= 'CREATE TABLE apply(
			id INT NOT NULL AUTO_INCREMENT,
			timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			student_name VARCHAR(30),
			student_account VARCHAR(20),
			item VARCHAR(50),
			reason TEXT(500),
			expected_deadline DATETIME DEFAULT NULL,
			allowed_deadline DATETIME DEFAULT NULL,
			reply VARCHAR(20),
			PRIMARY KEY(id)
		);';

		
		$stmt = $this->hookup->prepare($sql);
		$stmt->execute();
		
		// closeup
		$stu_len = count($this->stu_accs);
		$sql = 'CREATE TABLE closeup(item VARCHAR(50),';
		for ($i = 0; $i < $stu_len; $i += 1) {
			$sql .= $this->stu_accs[$i] . ' DATETIME DEFAULT NULL';
			if ($i < $stu_len - 1) {
				$sql .= ',';
			}
		}
		$sql .= ');';
		
		$stmt = $this->hookup->prepare($sql);
		$stmt->execute();

		// items					
		$item_len = count($this->items);
		for ($i = 0; $i < $item_len; $i += 1) {
			$sql = 'CREATE TABLE ' . $this->items[$i] . '(
				subitem TINYINT(20) UNSIGNED DEFAULT 1,
				description VARCHAR(100),
				judgescript VARCHAR(100),
				hint TEXT,';
			for ($j = 0; $j < $stu_len; $j += 1) {
				$sql .= $this->stu_accs[$j] . ' VARCHAR(30) NOT NULL DEFAULT "NULL"';
				if ($j < $stu_len - 1) {
					$sql .= ',';
				}
			}
			$sql .= ');';
			$stmt = $this->hookup->prepare($sql);
			$stmt->execute();
		}
		
		// subitems					
		$item_nums_len = count($this->item_nums);
		for ($i = 0; $i < $item_nums_len; $i += 1) {
			for ($k = 1; $k <= $this->item_nums[$i]; $k += 1) {
				$sql = 'CREATE TABLE ' . $this->items[$i] . '_' . $k . '(
					classname VARCHAR(100),
					main CHAR(1),
					original_source TEXT,
					modified_source TEXT,';
				for ($j = 0; $j < $stu_len; $j += 1) {
					$sql .= $this->stu_accs[$j] . ' TEXT';
					if ($j < $stu_len - 1) {
						$sql .= ',';
					}
				}
				$sql .= ', PRIMARY KEY(classname));';
				$stmt = $this->hookup->prepare($sql);
				$stmt->execute();
			}
		}
	}

	public function insertTable () {
		
		// student
		$stmt = $this->hookup->prepare('INSERT INTO student(student_name, student_account, student_password) VALUES(:stu_name, :stu_acc, :stu_pass)');
		$stmt->bindParam(':stu_name', $stu_name);
		$stmt->bindParam(':stu_acc', $stu_acc);
		$stmt->bindParam(':stu_pass', $stu_pass);
		for ($i = 0; $i < count($this->stu_accs); $i += 1) {
			$stu_name = $this->stu_names[$i];
			$stu_acc = $this->stu_accs[$i];
			$stu_pass = $this->stu_passs[$i];
			$stmt->execute();
		}	
		
		// faculty
		$stmt = $this->hookup->prepare('INSERT INTO faculty(faculty_name, faculty_account, faculty_password, faculty_email) VALUES(:fac_name, :fac_acc, :fac_pass, :fac_email)');
		$stmt->bindParam(':fac_name', $fac_name);
		$stmt->bindParam(':fac_acc', $fac_acc);
		$stmt->bindParam(':fac_pass', $fac_pass);
		$stmt->bindParam(':fac_email', $fac_email);
		for ($i = 0; $i < count($this->fac_accs); $i += 1) {
			$fac_name = $this->fac_names[$i];
			$fac_acc = $this->fac_accs[$i];
			$fac_pass = $this->fac_passs[$i];
			$fac_email = $this->fac_emails[$i];
			$stmt->execute();
		}	
		
		// problem
		$stmt = $this->hookup->prepare('INSERT INTO problem(item, number) VALUES(:item, :number)');
		$stmt->bindParam(':item', $item);
		$stmt->bindParam(':number', $number);
		for ($i = 0; $i < count($this->items); $i += 1) {
			$item = $this->items[$i];
			$number = $this->item_nums[$i];
			$stmt->execute();
		}	
		
		// closeup
		$stmt = $this->hookup->prepare('INSERT INTO closeup(item) VALUES(:item)');
		$stmt->bindParam(':item', $item);
		for ($i = 0; $i < count($this->items); $i += 1) {
			$item = $this->items[$i];
			$stmt->execute();
		}	
		
		// items
		for ($i = 0; $i < count($this->items); $i += 1) {
			$stmt = $this->hookup->prepare('INSERT INTO ' . $this->items[$i] . '(subitem) VALUES(:subitem)');
			$stmt->bindParam(':subitem', $subitem);
			for ($j = 1; $j <= $this->item_nums[$i]; $j += 1) {
				$subitem = $j;
				$stmt->execute();
			}
		}	
		
		// support: PHP, Python3, bash shell script
		$stmt = $this->hookup->prepare('INSERT INTO support(ext, cmd) VALUES(:ext, :cmd)');
		$stmt->bindParam(':ext', $ext);
		$stmt->bindParam(':cmd', $cmd);
		$ext = 'php'; 
		$cmd = 'php';
		$stmt->execute();
		$ext = 'py'; 
		$cmd = 'python3';
		$stmt->execute();
		$ext = 'sh'; 
		$cmd = 'sh';
		$stmt->execute();
		
	}

	public function deleteTable () {
		
		$stmt_table = $this->hookup->query('SHOW TABLES');
		while($row = $stmt_table->fetch(PDO::FETCH_NUM)){
			$stmt = $this->hookup->prepare('DROP TABLE ' . $row[0]);
			$stmt->execute();					
			
		}
	}
	
}

?>
