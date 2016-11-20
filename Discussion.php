<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

class Discussion implements Product{

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		$this->contentProduct .= '<div id=\'DISCUSSION_DIV\'><div id=\'RECORD_DIV\'></div><div id=\'TALK_DIV\'>';
		$this->contentProduct .=<<<EOF
<select id='SUBJECT_SELECT'>
<option value='Comment'>Comment</option>
<option value='Bug'>Bug</option>
<option value='Question'>Question</option>
<option value='News'>News</option>
</select>
<input type='text' id='TALK_INPUT'>
EOF;
		$this->contentProduct .= '<button id=\'TALK_BUTTON\'>Talk</button></div></div>';	
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

