<?php

include_once('Checker.php');

class TimeChecker extends Checker {
	
	private $registry_guest;
	private $registry_account;
	private $registry_time;
	private $registry_item;
	private $showup_time;
	private $closeup_time;
	private $error_msg;

	private $hookup;
	
	public function query ($context) {
		$this->registry_guest = $context['guest'];				
		$this->registry_account = $context['account'];
		$this->registry_time = $context['time'];
		$this->registry_item = $context['item'];
		
		// Get showup and closeup time	
		try {
			$this->hookup = UniversalConnect::doConnect();						

			// Get closeup time of registry student
			if ($this->registry_guest !== 'student') {
				return false;
			}	
			else {
				$stmt = $this->hookup->prepare('SELECT ' . $this->registry_account . ' FROM closeup WHERE item=\'' . $this->registry_item . '\'');
				$stmt->execute();
				$result = $stmt->fetch(PDO::FETCH_ASSOC);	
				$this->closeup_time = $result[$this->registry_account];
			}

			// Get showup time of every student
			$stmt = $this->hookup->prepare('SELECT showup FROM problem WHERE item=\'' . $this->registry_item . '\'');
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);	
			$this->showup_time = $result['showup'];
		
			
			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
		// Compare registry, showup and closeup time 
		if (empty($this->showup_time)) {
			$this->error_msg = 'This problem is not open for everyone yet.';
			return false;
		}
		else if (empty($this->closeup_time)) {
			$this->error_msg = 'You do not have permission to write this problem ! Please <a id=\'APPLY_A\' href=\'./Stu_leave.php\'>apply for writing</a> with proper reason.';
			return false;
		}
		else if (strtotime($this->closeup_time) < strtotime($this->registry_time)) {
			$this->error_msg = 'Time out ! Please <a id=\'APPLY_A\' href=\'./Stu_leave.php\'>apply for writing</a> with proper reason.';
			return false;
		}
		else {
			return true;
		}
		
	}
	
	public function fail () {
		return $this->error_msg;
	}		
}

?>
