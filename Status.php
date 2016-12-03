<?php

class Status extends Handler {

	private $item;
	private $subitem;
	private $stu_account;

	public function setSuccessor($nextService) {
		$this->successor = $nextService;
	}
	
	public function __construct ($abbr) {
		$this->handle = $abbr;
		$this->item = $_POST['item'];
		$this->subitem = $_POST['subitem'];
		$this->stu_account = $_POST['stu_account'];
	}
	
	public function handleRequest ($request) {
		
		// If this handler is responsible for verifying one of judge tasks
		if (in_array($this->handle, $request->getService())) {
			
			$info = array (
				'stu_account' => $this->stu_account,
				'item' => $this->item,
				'subitem' => $this->subitem
			);
		
			// Mock to do assignment	
			new Viewer('Sheet', $info);		

			$checker = new TaskChecker();
			$mock = array (
				'account' => $this->stu_account,
				'item' => $this->item,
				'subitem' => $this->subitem,
				'task' => $this->handle
			);

			if (!$checker->query($mock)) { // Judge task failed in this handler
				new Viewer('Msg', $this->handle . ' task failed, please <a class=\'DOC_A\' href=\'./Fac_prob.php?item=' . $this->item . '&subitem=' . $this->subitem . '\'>reassign</a> ! ');
				return false;
			}
			else if ($this->successor !== NULL) { // Judge task succeed in this handler and go to the next handler
			//	$this->successor->handleRequest($request);
			}
			else { // Judge task succeed in this handler and this is the final handler
				return true;
			}	
			
		}
		else if ($this->successor !== NULL) {
			$this->successor->handleRequest($request);
		}
	}

}

?>
