<?php

include_once('FormatHelper.php');
include_once('Product.php');

class Admin implements Product{
	
	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		$this->contentProduct .=<<<EOF

<form method='POST' action='./Initial.php' enctype='multipart/form-data'>
<table id='ADMIN_TABLE'>
<tr>
<td colspan='2'>
<input name='submit' type='submit' value='Save >>'><br><br>
<br>
<br>
</td>
</tr>
<tr>
<td>
<table>
<tr>
<td><button id='ADMIN_PROB_BUTTON' class='ADMIN_BUTTON' type='button'><b>+</b></button></td>
<th class='TITLE_TD'>Item</th>
<th class='TITLE_TD'>Number of subitems</th>
</tr>
<tr class='HIDDEN_PROB'>
<td><button class='ADMIN_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'>
<input name='item[]' type='text'>
</td>
<td class='CONTENT_TD'><input name='item_num[]' type='text' value='Only integer'></td>
</tr>
<tr>
<td><button class='ADMIN_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'>
<input name='item[]' type='text'>
</td>
<td class='CONTENT_TD'><input name='item_num[]' type='text' value='Only integer'></td>
</tr>
</table>
</td>
<td>
Student Account List&nbsp;&nbsp;<input name='stu_list' type='file'><br>
<p style='text-align:left;'>File(.csv) format is like:<br>
[student name], [student account], [student password]<br>
[student name], [student account], [student password]
</p>
</td>
<tr>
<td colspan='2'>
<table>
<tr>
<td><button id='ADMIN_FAC_BUTTON' class='ADMIN_BUTTON' type='button'><b>+</b></button></td>
<th class='TITLE_TD'>Faculty Name</th>
<th class='TITLE_TD'>Account</th>
<th class='TITLE_TD'>Password</th>
<th class='TITLE_TD'>Email</th>
</tr>
<tr class='HIDDEN_FAC'>
<td><button class='ADMIN_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input name='fac_name[]' type='text' value=''></td>
<td class='CONTENT_TD'><input name='fac_acc[]' type='text' value='Only alphabet or number '></td>
<td class='CONTENT_TD'><input name='fac_pass[]' type='password' value='Only alphabet or number'></td>
<td class='CONTENT_TD'><input name='fac_email[]' type='text' value='Email with @'></td>
</tr>
<tr>
<td><button class='ADMIN_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input name='fac_name[]' type='text' value=''></td>
<td class='CONTENT_TD'><input name='fac_acc[]' type='text' value='Only alphabet or number '></td>
<td class='CONTENT_TD'><input name='fac_pass[]' type='text' value='Only alphabet or number'></td>
<td class='CONTENT_TD'><input name='fac_email[]' type='text' value='Email with @'></td>
</tr>
</table>
</td>
</tr>
</table>
</form>
EOF;
		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

