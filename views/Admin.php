<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;

require_once('../composers/Autoloader.php');

class Admin implements Product{
	
	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		$this->contentProduct .=<<<EOF

<form method='POST' action='../controllers/Initial.php' enctype='multipart/form-data'>
<div class='PUT_BUTTON_DIV'>
<input class='CLICKABLE' name='submit' type='submit' value='Save'>
</div>
<table class='ADMIN_TABLE'>
<tr><th class='TITLE_TD'>Student Account List</th></tr>
<tr>
<td class='CONTENT_TD'>
<pre>
File(.csv) format is like:
[student name], [student account], [student password]
[student name], [student account], [student password]
</pre>
</td>
</tr>
<tr><td class='CONTENT_TD'><input class='FILL_INPUT' name='stu_list' type='file'></td></tr>
</table>
<table class='ADMIN_TABLE'>
<tr>
<td class='ADMIN_BUTTON_TD'><button id='ADMIN_PROB_BUTTON' class='ADMIN_BUTTON' type='button'><b>+</b></button></td>
<th class='TITLE_TD'>Item</th>
<th class='TITLE_TD'>Number of subitems</th>
</tr>
<tr class='HIDDEN_PROB'>
<td class='ADMIN_BUTTON_TD'><button class='ADMIN_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'>
<input class='FILL_INPUT' name='item[]' type='text' maxlength='7'>
</td>
<td class='CONTENT_TD'><input class='FILL_INPUT' name='item_num[]' type='text' value='Only integer' maxlength='1'></td>
</tr>
<tr>
<td class='ADMIN_BUTTON_TD'><button class='ADMIN_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'>
<input class='FILL_INPUT' name='item[]' type='text' maxlength='7'>
</td>
<td class='CONTENT_TD'><input class='FILL_INPUT' name='item_num[]' type='text' value='Only integer' maxlength='1'></td>
</tr>
</table>
<table class='ADMIN_TABLE'>
<tr>
<td class='ADMIN_BUTTON_TD'><button id='ADMIN_FAC_BUTTON' class='ADMIN_BUTTON' type='button'><b>+</b></button></td>
<th class='TITLE_TD'>Faculty Name</th>
<th class='TITLE_TD'>Account</th>
<th class='TITLE_TD'>Password</th>
<th class='TITLE_TD'>Email</th>
</tr>
<tr class='HIDDEN_FAC'>
<td class='ADMIN_BUTTON_TD'><button class='ADMIN_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input class='FILL_INPUT' name='fac_name[]' type='text' value=''></td>
<td class='CONTENT_TD'><input class='FILL_INPUT' name='fac_acc[]' type='text' value='Only alphabet or number '></td>
<td class='CONTENT_TD'><input class='FILL_INPUT' name='fac_pass[]' type='text' value='Only alphabet or number'></td>
<td class='CONTENT_TD'><input class='FILL_INPUT' name='fac_email[]' type='text' value='Email with @'></td>
</tr>
<tr>
<td class='ADMIN_BUTTON_TD'><button class='ADMIN_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input class='FILL_INPUT' name='fac_name[]' type='text' value=''></td>
<td class='CONTENT_TD'><input class='FILL_INPUT' name='fac_acc[]' type='text' value='Only alphabet or number '></td>
<td class='CONTENT_TD'><input class='FILL_INPUT' name='fac_pass[]' type='text' value='Only alphabet or number'></td>
<td class='CONTENT_TD'><input class='FILL_INPUT' name='fac_email[]' type='text' value='Email with @'></td>
</tr>
</table>
</form>
EOF;
		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

