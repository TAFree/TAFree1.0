<?php

class Tester extends Handler {

	public function setSuccessor($nextService) {
		$this->successor = $nextService;
	}
	public function handleRequest ($request) {
		$this->handle = 'tester';
		if ($request->getService() === $this->handle) {
			echo 'tester';
		}
		else if ($this->successor !== NULL) {
			$this->successor->handleRequest($request);
		}
	}

}

?>
