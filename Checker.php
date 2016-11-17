<?php

abstract class Checker {

	private $context;

	public abstract function query ($context);

	public function result ($obj) {
		$this->context = $obj;
		return $this->query($this->context);;
	}
}

?>
