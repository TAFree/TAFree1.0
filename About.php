<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

class About implements Product{
	
	private $msg = array (
		'Information' => '<a class=\'DOC_A\' href=\'http://github.com/TAFree\'>TAFree</a>  is an online judge system for NTU CE Computer Programming course; it is open-source and welcome to keep hacking.<br>',
		'Contributors' => 'Developers:<br>林照傑(edlin851206)<br>簡翰鈺(weavile182)<br>周琪雅(v06c)<br>張如嫻(JoyChal)<br>吳育姿(derailment)<br><br>Advisor:<br>吳軒竹(GGJason)<br>陳家陞(qitar888)',
		'History' => 'TAFree緣起於台大土木系計算機程式課程，由於近年選課學生的增加，使得以往的批改作業方式及繁瑣的管理程序造成課程助教業務量增大，為了消弭人工作業的諸多不便，一個輔助助教的作業批改系統由此誕生。<br><br>
		104年暑假，周琪雅，簡翰鈺，林照傑，張如嫻，吳軒竹完成前端的互動功能TAFreeUI。<br>
		105年學期，吳育姿延續TAFreeUI完成第一代平台TAFree1.0。<br>',
		'Version' => 'TAFree1.0 is available for Google Chrome 54.0.2840.59'
	);	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .= '<table id=\'ABOUT_TABLE\'';
		foreach($this->msg as $key => $value) {
			$this->contentProduct .= '<tr><td class=\'TITLE_TD\'><b>' . $key .'</b></td></tr><tr><td class=\'CONTENT_TD\'>' . $value . '</td></tr>';
		}
		$this->contentProduct .= '</table>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

if (isset($router)) {
	$router->run();
}
else {
	include_once('SetRouter.php');
	$router->run();
}

?>
