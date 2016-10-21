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

<form method='POST' action='./Initial.php'>
<table id='ADMIN_TABLE'>
<tr>
<td colspan='2'>
<input type='submit' value='Save >>'></td><br><br>
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
<select>
<option>Lab</option>
<option>Quiz</option>
<option>Midterm</option>
<option>Final</option>
</select>
</td>
<td class='CONTENT_TD'><input type='text'></td>
</tr>
<tr>
<td><button class='ADMIN_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'>
<select>
<option>Lab</option>
<option>Quiz</option>
<option>Midterm</option>
<option>Final</option>
</select>
</td>
<td class='CONTENT_TD'><input type='text'></td>
</tr>
</table>
</td>
<td>
Student Account List&nbsp;&nbsp;<input type='file'>
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
<td class='CONTENT_TD'><input type='text'></td>
<td class='CONTENT_TD'><input type='text'></td>
<td class='CONTENT_TD'><input type='password'></td>
<td class='CONTENT_TD'><input type='text'></td>
</tr>
<tr>
<td><button class='ADMIN_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text'></td>
<td class='CONTENT_TD'><input type='text'></td>
<td class='CONTENT_TD'><input type='password'></td>
<td class='CONTENT_TD'><input type='text'></td>
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

