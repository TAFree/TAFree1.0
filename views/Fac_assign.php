<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\database\UniversalConnect;
use TAFree\routes\SessionManager;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Fac_assign implements Product {	

	private $formatHelper;
	private $contentProduct;

	private $item;
	private $subitem;
	private $generalJudges;

	private $hookup;

	public function __construct () {
		$this->item = SessionManager::getParameter('item');
		$this->subitem = SessionManager::getParameter('subitem');
	}

	public function getContent() {
	
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<form method='POST' action='../controllers/Upload.php' enctype='multipart/form-data'>
<div class='PUT_BUTTON_DIV'>
<h1>{$this->item}_{$this->subitem}</h1>
<input type='submit' class='CLICKABLE' value='Upload' id='UPLOAD_INPUT'>
EOF;
		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			$stmt = $this->hookup->prepare('SELECT number FROM problem WHERE item=\'' . $this->item . '\'');
			$stmt->execute();
			$row = $stmt->fetch(\PDO::FETCH_ASSOC);

			if ($row['number'] !== '1' && $this->subitem === $row['number']) {
				$this->contentProduct .= '<label id=\'DELETE_LABEL\' for=\'DELETE_INPUT\'><input type=\'checkbox\' id=\'DELETE_INPUT\' name=\'delete\' value=\'\'>Delete</label>';
			}

			$this->hookup = null;
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
		$this->contentProduct .=<<<EOF
<input type='hidden' name='item' value='{$this->item}'>
<input type='hidden' name='subitem' value='{$this->subitem}'>
</div>
<table id='PROBLEM_TABLE'>
<tr>
<th colspan='2' class='TITLE_TD'>Problem</th>
</tr>
<tr>
<td class='CONTENT_PRE_TD'>Problem Description</td>
<td class='CONTENT_TD'><input type='file' name='description'></td>
</tr>
<tr>
<td class='CONTENT_PRE_TD'>Hint</td>
<td class='CONTENT_TD'><textarea class='FILL_TEXTAREA' name='hint'></textarea></td>
</tr>
<tr>
<td class='CONTENT_PRE_TD'>Judge Script</td>
<td class='CONTENT_TD'>
<select id='JUDGE_SELECT' name='judge'>
EOF;
		
		$generalJudges = glob('../judge/*');
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
<tr>
<td class='CONTENT_PRE_TD'>Safe Mode</td>
<td class='CONTENT_TD'>
<input type='checkbox' id='SAFE_INPUT' value='isolate' checked name='safe'><p class='WARN_P'>(Do not deselect safe mode if your judge script does not concern about security !)</p>
</td>
</tr>
</table>
<table id='SOLUTION_TABLE'>
<tr>
<th></th>
<th colspan='2' class='TITLE_TD'>Solution</th>
</tr>
<tr>
<td class='ADMIN_BUTTON_TD'><button class='ADD_BUTTON' type='button'><b>+</b></button></td>
<td class='TITLE_TD'>Filename (.java)</td>
<td class='TITLE_TD'>Upload</td>
</tr>
<tr class='HIDDEN_TR'>
<td class='ADMIN_BUTTON_TD'><button class='DEL_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text' name='solution_filename[]'></td>
<td class='CONTENT_TD'><textarea class='FILL_TEXTAREA' name='solution_content[]'></textarea></td>
</tr>
<tr class='SHOW_TR'>
<td class='ADMIN_BUTTON_TD'><button class='DEL_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text' name='solution_filename[]'></td>
<td class='CONTENT_TD'><textarea class='FILL_TEXTAREA' name='solution_content[]'>// This block must include main function</textarea></td>
</tr>
</table>
<table id='TESTDATA_TABLE'>
<tr>
<th></th>
<th colspan='2' class='TITLE_TD'>Test Data</th>
</tr>
<tr>
<td class='ADMIN_BUTTON_TD'><button class='ADD_BUTTON' type='button'><b>+</b></button></td>
<td class='TITLE_TD'>Filename (.in)</td>
<td class='TITLE_TD'>Separate by Space</td>
</tr>
<tr class='HIDDEN_TR'>
<td class='ADMIN_BUTTON_TD'><button class='DEL_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text' name='testdata_filename[]'></td>
<td class='CONTENT_TD'><textarea class='FILL_TEXTAREA' name='testdata_content[]'></textarea></td>
</tr>
<tr class='SHOW_TR'>
<td class='ADMIN_BUTTON_TD'><button class='DEL_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text' name='testdata_filename[]'></td>
<td class='CONTENT_TD'><textarea class='FILL_TEXTAREA' name='testdata_content[]'></textarea></td>
</tr>
</table>
</form>
EOF;
		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

require_once('../routes/Dispatcher.php');

?>
