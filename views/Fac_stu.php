<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');
require_once('../routes/SetRouter.php');

class Fac_stu implements Product{
	
	// Should be assign	
	private $links = array (
		'Add/Delete' => '../views/Fac_add_del_stu.php',
		'All' => '../views/Fac_all.php',
		'Leave' => '../views/Fac_leave.php'				     
	);	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .= '<div id=\'FAC_DIV\'>';
		foreach ($this->links as $key => $value) {
			if ($key !== 'Leave') {
				$this->contentProduct .= '<a class=\'FAC_A\' href=\'' . $value . '\'>' . $key . '</a><br><br>';
			}else {
				$this->contentProduct .= '<a id=\'FAC_LEAVE\' class=\'FAC_A\' href=\'' . $value . '\'>' . $key . '</a><br><br>';
			}
		}
		$this->contentProduct .= '</div>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

$router->run();

?>
