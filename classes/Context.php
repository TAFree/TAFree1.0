<?php
namespace TAFree\classes;

use TAFree\classes\IStrategy;

require_once('../composers/Autoloader.php');

class Context {
	
	private $strategy;
	
	public function __construct (IStrategy $strategy) {
		$this->strategy = $strategy;
	}
	
	public function algorithm () {
		$this->strategy->algorithm();
	}

}
?>
