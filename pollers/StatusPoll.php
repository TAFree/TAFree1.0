<?php
namespace TAFree\pollers;

use TAFree\database\UniversalConnect;
use TAFree\routes\SessionManager;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class StatusPoll {
	
	private $item;
	private $subitem;
	private $stu_account;
	private $id;
	private $result;
	private $times = 30;

	private $hookup;
	
	public function __construct () {
		
		$this->item = SessionManager::getParameter('item');
		$this->subitem = SessionManager::getParameter('subitem');
		$this->stu_account = SessionManager::getParameter('account');
		$this->id = SessionManager::getParameter('id');
		
		try {
			$this->hookup = UniversalConnect::doConnect();						
		
			// Poll database during judge status is pending	
			for ($i = 0; $i < $this->times; $i += 1) {
				$stmt_judge = $this->hookup->prepare('SELECT ' . $this->stu_account . ' FROM ' . $this->item . ' WHERE subitem=\'' . $this->subitem . '\'');	
				$stmt_judge->execute();
				$row_judge = $stmt_judge->fetch(\PDO::FETCH_ASSOC);
				
				if ($row_judge[$this->stu_account] !== 'Pending') { 
					
					// Check if view of judge result is prepared
					while (is_null($this->result)) {
						$stmt_result = $this->hookup->prepare('SELECT view FROM process WHERE id=\'' . $this->id . '\'');
						$stmt_result->execute();
						$row_result = $stmt_result->fetch(\PDO::FETCH_ASSOC);
						$this->result = $row_result['view'];
					}
					
					// Output view of judge result 
					echo '../views/Result.php?id=' . $this->id;
				
					$this->hookup = null;
					exit();			
				
				}
				sleep(1);
			}
			
			// System error when there is no any judge client catch this submission 
			$stmt_proc = $this->hookup->prepare('UPDATE process SET status=\'SE\', judger=\'Vacancy\' WHERE id=\'' . $this->id . '\'');
			$stmt_proc->execute();
			$stmt_item = $this->hookup->prepare('UPDATE ' . $this->item . ' SET ' . $this->stu_account . '=\'SE\' WHERE subitem=\'' . $this->subitem . '\'');
			$stmt_item->execute();
				
			// Output error message
			$error_output = 'TAFree judger are too buzy. <p class=\'WARN_P\'>Please retry :)</p>'; 
			echo '../views/Msg.php?view=' . $error_output;
			
			exit();

		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}

}

require_once ('../routes/Dispatcher.php');

?>

