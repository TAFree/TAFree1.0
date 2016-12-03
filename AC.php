<?php

class AC extends Handler {

	private $item;
	private $subitem;
	private $stu_account;

	public function setSuccessor($nextService) {
		$this->successor = $nextService;
	}
	
	public function __construct () {
		$this->item = $_POST['item'];
		$this->subitem = $_POST['subitem'];
		$this->stu_account = $_POST['stu_account'];
	}
	
	public function handleRequest ($request) {
		$this->handle = 'AC';
		if (in_array($this->handle, $request->getService())) {
			
			$info = array (
				'stu_account' => $this->stu_account,
				'item' => $this->item,
				'subitem' => $this->subitem,
				'task' => $this->handle
			);
		
			new Viewer('Stu_prob', $info);		

			$trigger = new DBOperator();
			if (!$trigger->checkTester($this->handle)) {
				new Viewer('Msg', $this->handle . ' task failed, please <a href=\'./Fac_prob.php?item=' . $this->item . '&subitem=' . $this->subitem . '\'>reassign</a> ! ');
				exit();	
			}
			else if ($this->successor !== NULL) {
				$this->successor->handleRequest($request);
			}
			else {
				new ProblemQualify();
				exit();
			}	
			
		}
		else if ($this->successor !== NULL) {
			$this->successor->handleRequest($request);
		}
	}

}

?>
