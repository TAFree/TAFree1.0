<?php

class Student extends Handler {

	public function setSuccessor($nextService) {
		$this->successor = $nextService;
	}
	public function handleRequest ($request) {
		$this->handle = 'student';
		if ($request->getService() === $this->handle) {
			echo 'stu';
		}
		else if ($this->successor !== NULL) {
			$this->successor->handleRequest($request);
		}
	}

}

?>
