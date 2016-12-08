<?php
namespace TAFree\routes;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Janitor {
		
	private $controlArea = array (
		'Stu_problem' => 'TAFree\models\TimeChecker',
		'Handin' => 'TAFree\models\TimeChecker'
	);
	private $destination;
	private $identification;
	private $go;
	private $bye = 'Bye bye.';
	
	public function __construct ($registry) {
		
		$this->destination = $registry['destination'];
		
		// Identify guest access permission if destination is in control area 
		if (array_key_exists($this->destination, $this->controlArea)) {
			$this->identification = new $this->controlArea[$this->destination]();
			if ($this->identification->result($registry)) {
				$this->go = true;
			}
			else {
				$this->go = false;
				if ($this->identification->fail() !== null) {
					$this->bye = $this->identification->fail();
				}
			}
		}
		else {
			$this->go = true;
		}
	}

	public function dialogue () {
		return $this->bye;
	}

	public function openDoor() {
		return $this->go;
	}

}

?>
