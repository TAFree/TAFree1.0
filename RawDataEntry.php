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
	
	public function algorithm () {
		
		if (isset($_POST['submit'])) {
	
			// Get items
			$items = $_POST['item'];
			$item_nums = $_POST['item_num'];
			// i = 0 is hidden row
			for ($i = 1; $i < count($items); $i += 1 ) {
				
				$this->items[$i - 1] = $items[$i];
				
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
			if (move_uploaded_file($tmp_name, $dir . '/' . $basename)){
				
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
				new Viewer ('Msg', 'Successful initialization !' . '<br>');
				fclose($file);
				unlink($dir . '/' . $basename);
			
			}
			else{
				new Viewer ('Msg', $basename . ' is not uploaded...');
				fclose($file);
				unlink($dir . '/' . $basename);
				exit();
			}

		}
		
	}
			
}

?>
