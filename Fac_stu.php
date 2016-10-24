<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload ($class_name) {
	include_once($class_name . '.php');
}

class Fac_stu implements Product{
	
	// Should be assign	
	private $links = array (
		'Add/Delete' => 'Fac_add_del_stu.php',
		'All' => 'Fac_all.php',
		'Leave' => 'Fac_leave.php'				     
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

if ($router) {
	$router->run();
}
else {
	include_once('SetRouter.php');
	$router->run();
}

?>
