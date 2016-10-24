<?php

class Tester extends Handler {

	public function setSuccessor($nextService) {
		$this->successor = $nextService;
	}
	public function handleRequest ($request) {
		$this->handle = 'tester';
		if ($request->getService() === $this->handle) {
			new Viewer('Test');
		}
		else if ($this->successor !== NULL) {
			$this->successor->handleRequest($request);
		}
	}

}

?>
