<?php
namespace TAFree\models;

use TAFree\classes\IStrategy;
use TAFree\utils\Viewer;
use TAFree\database\UniversalConnect;
use TAFree\routes\SessionManager;

require_once('../composers/Autoloader.php');

class LeaveApply implements IStrategy {
	
	private $name;
	private $account;
	private $item;
	private $reason;
	private $expected;
	private $reply;
	private $emails = array();

	private $hookup;
	
	public function __construct () {
		$this->name = SessionManager::getParameter('nickname');
		$this->account = SessionManager::getParameter('account');
	}

	public function algorithm () {
		
		if (isset($_POST['submit'])) {
	
			// Get leave apply parameters
			$this->item = $_POST['item'];
			$this->reason = $_POST['reason'];
			$expected_date = $_POST['date'];
			$expected_hr = $_POST['hour'];
			$expected_min = $_POST['minute'];
			$this->expected = $expected_date . ' ' . $expected_hr . ':' . $expected_min . ':' . '59';
			if (strpos($this->expected, '-') === false) {
				new Viewer ('Msg', 'Forgot to choose expected date...' . '<br>');
				exit();
			}
			$this->reply = 'Wait';
	
			try {
				$this->hookup = UniversalConnect::doConnect();						
				
				// Insert table
				$this->insertTable();
				
				// Query Table
				$this->queryTable();

				$this->hookup = null;
			}
			catch (\PDOException $e) {
				echo 'Error: ' . $e->getMessage() . '<br>';
			}
			
			// Send email to faculty
			foreach ($this->emails as $email) {
				$command = 'echo \'This is a student writing apply sent from TAFree. Please reply him/her via http://' . $_SERVER['SERVER_ADDR'] . '\' | mail -s \'Student Writing Apply\' ' . $email;
				$handler = popen('at now + 1 minute', 'w');
				fwrite($handler, $command);
				fclose($handler);
			}
			
			new Viewer ('Msg', 'Already sent an email to faculty ! <br>Please wait their reply.');
		
		}
		
	}
	
	public function insertTable () {
		
		// apply
		$stmt = $this->hookup->prepare('INSERT INTO apply(student_name, student_account, item, reason, expected_deadline, reply) VALUES(:name, :account, :item, :reason, :expected, :reply)');
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':account', $account);
		$stmt->bindParam(':item', $item);
		$stmt->bindParam(':reason', $reason);
		$stmt->bindParam(':expected', $expected);
		$stmt->bindParam(':reply', $reply);
		$name = $this->name;
		$account = $this->account;
		$item = $this->item;
		$reason = $this->reason;
		$expected = $this->expected;
		$reply = $this->reply;
		$stmt->execute();
	}
	
	public function queryTable () {
		
		// faculty
		$stmt = $this->hookup->prepare('SELECT faculty_email FROM faculty');
		$stmt->execute();
		$i = 0;
		while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
			$this->emails[$i] = $row['faculty_email'];
			$i += 1;
		}
	}

}

?>
