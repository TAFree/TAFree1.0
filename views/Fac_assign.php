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
<input type='hidden' name='item' value='{$this->item}'>
<input type='hidden' name='subitem' value='{$this->subitem}'>
<input type='submit' class='CLICKABLE' value='Upload' id='UPLOAD_INPUT'>
EOF;
		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			$stmt_problem = $this->hookup->prepare('SELECT number FROM problem WHERE item=\'' . $this->item . '\'');
			$stmt_problem->execute();
			$row = $stmt_problem->fetch(\PDO::FETCH_ASSOC);

			if ($row['number'] === '1') {
				$this->contentProduct .= '<label id=\'ADD_LABEL\' for=\'ADD_INPUT\'><input type=\'checkbox\' id=\'ADD_INPUT\' name=\'add\' value=\'\'>Add</label>';
			}
			else if ($this->subitem === $row['number']) {
				$this->contentProduct .= '<label id=\'DELETE_LABEL\' for=\'DELETE_INPUT\'><input type=\'checkbox\' id=\'DELETE_INPUT\' name=\'delete\' value=\'\'>Delete</label>';
				$this->contentProduct .= '<label id=\'ADD_LABEL\' for=\'ADD_INPUT\'><input type=\'checkbox\' id=\'ADD_INPUT\' name=\'add\' value=\'\'>Add</label>';
			}

			$this->contentProduct .=<<<EOF
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

			$stmt_general = $this->hookup->prepare('SELECT judgescript FROM general');
			$stmt_general->execute();
			$num_general = $stmt_general->rowCount();
			while($row = $stmt_general->fetch(\PDO::FETCH_ASSOC)) {
				$this->contentProduct .= '<option value=\'' . $row['judgescript'] . '\'>' . $row['judgescript'] . '</option>';
			}
			$this->contentProduct .= '<option value=\'other\'>other</option>';
			if ($num_general === 0) {
				$this->contentProduct .= '<input type=\'file\' name=\'judge_file\'>';
			}
			else {
				$this->contentProduct .= '<input id=\'OTHER_INPUT\' type=\'file\' name=\'judge_file\'>';
			}

			$this->hookup = null;

		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
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
<td class='ADMIN_BUTTON_TD'><button class='ADD_BUTTON' type='button'><b>+</b></button></td>
<td class='TITLE_TD'>Filename (.java)</td>
<td class='TITLE_TD'>Upload</td>
</tr>
<tr class='HIDDEN_TR'>
<td class='ADMIN_BUTTON_TD'><button class='DEL_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input class='FILENAME_INPUT' type='text' name='solution_filename[]'></td>
<td class='CONTENT_TD'><textarea class='FILL_TEXTAREA' name='solution_content[]'></textarea></td>
</tr>
<tr class='SHOW_TR'>
<td class='ADMIN_BUTTON_TD'><button class='DEL_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input class='FILENAME_INPUT' type='text' name='solution_filename[]'></td>
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
<td class='CONTENT_TD'><input class='FILENAME_INPUT' type='text' name='testdata_filename[]'></td>
<td class='CONTENT_TD'><textarea class='FILL_TEXTAREA' name='testdata_content[]'></textarea></td>
</tr>
<tr class='SHOW_TR'>
<td class='ADMIN_BUTTON_TD'><button class='DEL_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input class='FILENAME_INPUT' type='text' name='testdata_filename[]'></td>
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
