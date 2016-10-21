<?php

class Request {
	
	private $service;
	
	public function __construct ($service) {
		$this->service = $service;
	}

	public function getService() {
		return $this->service;
	}
}

?>
