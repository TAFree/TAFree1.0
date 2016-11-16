<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');
}

class Fac_assign implements Product {	

	private $formatHelper;
	private $contentProduct;
	private $generalJudges;

	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<h1>{$_GET['item']}_{$_GET['subitem']}</h1>
<form method='POST' action='./Upload.php' enctype='multipart/form-data'>
<div class='FAC_ASSIGN_DIV'>
<input type='submit' value='Upload >>'>
<input type='hidden' name='item' value='{$_GET['item']}'>
<input type='hidden' name='subitem' value='{$_GET['subitem']}'>
</div>
<table id='PROBLEM_TABLE'>
<tr>
<th colspan='2' class='TITLE_TD'>Problem</th>
</tr>
<tr>
<td class='CONTENT_TD'>Description</td>
<td class='CONTENT_TD'><input type='file' name='description'></td>
</tr>
<tr>
<td class='CONTENT_TD'>Hint</td>
<td class='CONTENT_TD'><textarea name='hint'></textarea></td>
</tr>
<tr>
<td class='CONTENT_TD'>Judge</td>
<td class='CONTENT_TD'>
<select id='JUDGE_SELECT' name='judge'>
EOF;
		
		$generalJudges = glob('judge/*');
		foreach ($generalJudges as $file) {
			$file = (string)$file;
			$filename = substr($file, strripos($file, '/') + 1);
			$this->contentProduct .= '<option value=\'' . $filename . '\'>' . $filename . '</option>';
		}
		
		$this->contentProduct .= '<option value=\'other\'>other</option>';

		if (!isset($generalJudges)) {
			$this->contentProduct .= '<input type=\'file\' name=\'judge_file\'>';
		}
		else {
			$this->contentProduct .= '<input id=\'OTHER_INPUT\' type=\'file\' name=\'judge_file\'>';
		}
		
		$this->contentProduct .=<<<EOF
</select>
</td>
</tr>
</table>
<table id='SOLUTION_TABLE'>
<tr>
<th></th>
<th colspan='2' class='TITLE_TD'>Solution</th>
</tr>
<tr>
<td><button class='ADD_BUTTON' type='button'><b>+</b></button></td>
<td class='TITLE_TD'>Filename (.java, .cpp, .py)</td>
<td class='TITLE_TD'>Upload</td>
</tr>
<tr class='HIDDEN_TR'>
<td><button class='DEL_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text' name='solution_filename[]'></td>
<td class='CONTENT_TD'><textarea name='solution_content[]'></textarea></td>
</tr>
<tr class='SHOW_TR'>
<td><button class='DEL_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text' name='solution_filename[]'></td>
<td class='CONTENT_TD'><textarea name='solution_content[]'></textarea></td>
</tr>
</table>
<table id='TESTDATA_TABLE'>
<tr>
<th></th>
<th colspan='2' class='TITLE_TD'>Test Data</th>
</tr>
<tr>
<td><button class='ADD_BUTTON' type='button'><b>+</b></button></td>
<td class='TITLE_TD'>Filename (.in)</td>
<td class='TITLE_TD'>Separate by Space</td>
</tr>
<tr class='HIDDEN_TR'>
<td><button class='DEL_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text' name='testdata_filename[]'></td>
<td class='CONTENT_TD'><textarea name='testdata_content[]'></textarea></td>
</tr>
<tr class='SHOW_TR'>
<td><button class='DEL_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text' name='testdata_filename[]'></td>
<td class='CONTENT_TD'><textarea name='testdata_content[]'></textarea></td>
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
