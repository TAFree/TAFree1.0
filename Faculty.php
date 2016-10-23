<?php

class Faculty extends Handler {

	public function setSuccessor($nextService) {
		$this->successor = $nextService;
	}
	public function handleRequest ($request) {
		$this->handle = 'faculty';
		if ($request->getService() === $this->handle) {
			$trigger = new DBOperator();
			$trigger->queryFaculty();
		}
		else if ($this->successor !== NULL) {
			$this->successor->handleRequest($request);
		}
	}

}

?>
