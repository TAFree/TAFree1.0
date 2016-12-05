<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');
require_once('../routes/SetRouter.php');

class Fac_prob implements Product{
	
	private $links = array (
		'Coders' => '../views/Fac_coders.php',
		'Look' => '../views/Fac_look.php'
	);	
	private $item;
	private $subitem;

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		
		// Get item, subitem
		$this->item = $_GET['item'];
		$this->subitem = $_GET['subitem'];
		
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .= '<div id=\'FAC_DIV\'>';
		$this->contentProduct .= '<input type=\'hidden\' name=\'item\' value=\'' . $this->item . '\'>';
		$this->contentProduct .= '<input type=\'hidden\' name=\'subitem\' value=\'' . $this->subitem . '\'>';
		$this->contentProduct .= '<h1>Here is ' . $this->item . '_' . $this->subitem . '</h1>';	

		// Clear key_to_assign session variable
		if (isset($_SESSION['key_to_assign'])) {
			unset($_SESSION['key_to_assign']);
		}
	
		$this->contentProduct .= '<input type=\'button\' id=\'ASSIGN_INPUT\' class=\'CLICKABLE\' value=\'Assign\'>';
		
		foreach ($this->links as $key => $value) {
			$this->contentProduct .= '<a class=\'FAC_A\' href=\'' . $value . '?item=' . $this->item . '&subitem=' . $this->subitem. '\'>' . $key . '</a><br><br>';
		}
		
		$this->contentProduct .= '</div>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

$router->run();

?>
