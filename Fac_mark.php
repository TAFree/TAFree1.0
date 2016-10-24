<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

class Fac_mark implements Product {	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF

<form>
<table id='MARK_TABLE'>
<tr>
<th class='TITLE_TD'>Problem</th>
<th class='TITLE_TD'><a class='CLICKABLE' href="down_pdf.php">Download PDF</a><a class='CLICKABLE' href="down_zips.php">Download All ZIPs</a></th>
<th class='TITLE_TD'>Manual
<input type='submit' value='Save >>'>
</th>
</tr>
<tr>
<td class='TITLE_TD'>Account</td>
<td class='TITLE_TD'>Score</td>
<td class='TITLE_TD'>File</td>
</tr>
<tr>
<td class='CONTENT_TD'>abby8050</td>
<td class='CONTENT_TD'>
<input type='text' value='100' width='50px'>
</td>
<td class='CONTENT_TD'>
<a class='CLICKABLE' href="down_zip.php">Download ZIP</a>
</td>
</tr>
<tr>
<td class='CONTENT_TD'>abby8050</td>
<td class='CONTENT_TD'>
<input type='text' value='100' width='50px'>
</td>
<td class='CONTENT_TD'>
<a class='CLICKABLE' href="down_zip.php">Download ZIP</a>
</td>
</tr>
<tr>
<td class='CONTENT_TD'>abby8050</td>
<td class='CONTENT_TD'>
<input type='text' value='100' width='50px'>
</td>
<td class='CONTENT_TD'>
<a class='CLICKABLE' href="down_zip.php">Download ZIP</a>
</td>
</tr>
</table>
</form>
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
