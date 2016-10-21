<?php

abstract class Handler {

	protected $successor;
	protected $handle;

	abstract public function handleRequest($request);	
	abstract public function setSuccessor($nextService);
	
}

?>
