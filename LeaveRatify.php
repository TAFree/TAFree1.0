<?php

include_once('Util.php');

class LeaveRatify implements IStrategy {
	
	private $ids = array();
	private $alloweds = array();
	private $replys = array();
	private $emails = array();
	private $accounts = array();
	private $items = array();

	private $hookup;
	
	public function algorithm () {
		
		if (isset($_POST['submit'])) {
	
			if (!isset($_POST['id'])) {
				new Viewer ('Msg', 'There is no newer ratification...' . '<br>');
				exit();
			}
			
			// Get leave ratify parameters
			$this->ids = $_POST['id'];
			$allowed_dates = $_POST['date'];
			$allowed_hrs = $_POST['hour'];
			$allowed_mins = $_POST['minute'];
			
			for ($i = 0; $i < count($this->ids); $i += 1) {	
				if (strpos($allowed_dates[$i], '-') === false) {
					new Viewer ('Msg', 'Forgot to choose allowed date...' . '<br>');
					exit();
				}
				$this->alloweds[$i] = $allowed_dates[$i] . ' ' . $allowed_hrs[$i] . ':' . $allowed_mins[$i] . ':' . '59';
				
			}
			
			$this->replys = $_POST['reply'];
			
			$this->emails = $_POST['email'];
	
			$this->accounts = $_POST['account'];

			$this->items = $_POST['item'];

			try {
				$this->hookup = UniversalConnect::doConnect();						
				
				// Update table
				$this->updateTable();

				$this->hookup = null;
			}
			catch (PDOException $e) {
				echo 'Error: ' . $e->getMessage() . '<br>';
			}
			
			// Send email to students
			foreach ($this->emails as $email) {
				$command = 'echo \'This is a student leave ratification sent from TAFree. Please check your leave apply via http://140.112.12.112\' | mail -s \'Faculty Leave Ratification\' ' . $email;
				$handler = popen('at now + 1 minute', 'w');
				fwrite($handler, $command);
				fclose($handler);
			}
			
			new Viewer ('Msg', 'Already sent an email to those students with allowed deadlines !<br>Automatically added them to \'Whitelist\'.' . '<br>');
		
		}
		
	}
	
	public function updateTable () {
		
		// apply
		for ($i = 0; $i < count($this->ids); $i += 1) {
			$id = $this->ids[$i];
			$allowed = $this->alloweds[$i];
			$reply = $this->replys[$i];		
			$stmt = $this->hookup->prepare('UPDATE apply SET allowed_deadline=\'' . $allowed . '\', reply=\'' . $reply . '\' WHERE id=\'' . $id . '\'');	
			$stmt->execute();
			// closeup 
			if ($reply === 'Approve') {
				$account = $this->accounts[$i];
				$item = $this->items[$i];
				$stmt = $this->hookup->prepare('UPDATE closeup SET ' . $account . '=\'' . $allowed . '\' WHERE item=\'' . $item . '\'');
				$stmt->execute();
			}
		}
	}
}

?>
