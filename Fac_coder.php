<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload ($class_name) {
	include_once($class_name . '.php');
}

class Fac_coder implements Product {	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<table class='STATUS_TABLE'>
<tr><th class='TITLE_TD'>Status</th><th class='TITLE_TD'>%</th></tr>
<tr><td class='CONTENT_TD'><p class='STATUS_P'>AC</p> Accept</td><td class='CONTENT_TD'>50</td></tr>
<tr><td class='CONTENT_TD'><p class='STATUS_P'>NA</p> Not Accept</td><td class='CONTENT_TD'>50</td></tr>
<tr><td class='CONTENT_TD'><p class='STATUS_P'>WA</p> Wrong Answer</td><td class='CONTENT_TD'>50</td></tr>
<tr><td class='CONTENT_TD'><p class='STATUS_P'>TLE</p> Time Limit Exceed</td><td class='CONTENT_TD'>50</td></tr>
<tr><td class='CONTENT_TD'><p class='STATUS_P'>MLE</p> Memory Limit Exceed</td><td class='CONTENT_TD'>50</td></tr>
<tr><td class='CONTENT_TD'><p class='STATUS_P'>OLE</p> Output Limit Exceed</td><td class='CONTENT_TD'>50</td></tr>
<tr><td class='CONTENT_TD'><p class='STATUS_P'>RE</p> Runtime Error</td><td class='CONTENT_TD'>50</td></tr>
<tr><td class='CONTENT_TD'><p class='STATUS_P'>RF</p> Restricted Function</td><td class='CONTENT_TD'>50</td></tr>
<tr><td class='CONTENT_TD'><p class='STATUS_P'>CE</p> Compiler Error</td><td class='CONTENT_TD'>50</td></tr>
<tr><td class='CONTENT_TD'><p class='STATUS_P'>SE</p> System Error</td><td class='CONTENT_TD'>50</td></tr>
</table>
<table class='STATUS_DOWNLOAD_TABLE'>
<tr>
<th colspan='2' class='TITLE_TD'>{$_GET['item']}_{$_GET['subitem']}</th>
<th class='TITLE_TD'><a class='CLICKABLE' href="down_zips.php">All</a></th>
</tr>
<tr>
<td class='TITLE_TD'>Account</td>
<td class='TITLE_TD'>Status</td>
<td class='TITLE_TD'>Source Code</td>
</tr>
<tr>
<td class='CONTENT_TD'>abby8050</td>
<td class='CONTENT_TD'>AC</td>
<td class='CONTENT_TD'>
<a class='CLICKABLE' href="down_zip.php">Download</a>
</td>
</tr>
<tr>
<td class='CONTENT_TD'>abby8050</td>
<td class='CONTENT_TD'>CE</td>
<td class='CONTENT_TD'>
<a class='CLICKABLE' href="down_zip.php">Download</a>
</td>
</tr>
<tr>
<td class='CONTENT_TD'>abby8050</td>
<td class='CONTENT_TD'>RE</td>
<td class='CONTENT_TD'>
<a class='CLICKABLE' href="down_zip.php">Download</a>
</td>
</tr>
</table>
EOF;
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
