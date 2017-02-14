<?php
namespace TAFree\controllers;

use TAFree\utils\Viewer;
use TAFree\database\UniversalConnect;
use TAFree\routes\SessionManager;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class JudgeAdapter {
	
	private $id;
	private $submitter;
	private $stu_account;
	private $stu_name;	
	private $item;
	private $subitem;

	private $hookup;
	
	public function __construct () {
		
		// Get item, subitem, stu_account, stu_name, ip
		$this->item = SessionManager::getParameter('item');
		$this->subitem = SessionManager::getParameter('subitem');
		$this->stu_account = SessionManager::getParameter('account');
		$this->stu_name = SessionManager::getParameter('nickname');
		$this->submitter = SessionManager::getParameter('ip');
	
		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			// Create id & set id as session variable
			$this->id = uniqid();
			SessionManager::setParameter('id', $this->id);

			// Add judge process row in process table
			$stmt = $this->hookup->prepare('INSERT INTO process (id, submitter, student_account, student_name, item, subitem) VALUES (:id, :submitter, :student_account, :student_name, :item, :subitem)');
			$stmt->bindParam(':id', $this->id);
			$stmt->bindParam(':student_account', $this->stu_account);
			$stmt->bindParam(':student_name', $this->stu_name);
			$stmt->bindParam(':submitter', $this->submitter);
			$stmt->bindParam(':item', $this->item);
			$stmt->bindParam(':subitem', $this->subitem);
			$stmt->execute();

			// Update judge status as 'Pending'
			$stmt = $this->hookup->prepare('UPDATE ' . $this->item . ' SET ' . $this->stu_account . '=\'Pending\' WHERE subitem=\'' . $this->subitem . '\'');
			$stmt->execute();

			// Output pending view
			new Viewer('Pending'); 
			
			$this->hookup = null;
			exit();
			
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}

}

require_once('../routes/Dispatcher.php');

?>

