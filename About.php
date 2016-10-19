<?php

include_once('FormatHelper.php');
include_once('Product.php');

class About implements Product{
	
	// Should be assign	
	private $links = array (
		'Information' => 'TAFree is an online judge system for NTU CE Computer Programming Course; it is open-source and welcome to hack.',
		'Contributors' => 'Cannot type Traditional Chinese',
		'History' => '2016 Summer...',
		'Version' => 'TAFree1.0 is available for Google Chrome 53.0.2785.101'
	);	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .= '<table id=\'ABOUT_TABLE\'';
		foreach($this->links as $key => $value) {
			$this->contentProduct .= '<tr><td class=\'TITLE_TD\'><b>' . $key .'</b></td></tr><tr><td class=\'CONTENT_TD\'>' . $value . '</td></tr>';
		}
		$this->contentProduct .= '</table>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

$worker = new About();
echo $worker->getContent();

?>

