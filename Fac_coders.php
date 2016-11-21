<?php 

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload ($class_name) {
	include_once($class_name . '.php');
}

class Fac_coders implements Product {	

	private $formatHelper;
	private $contentProduct;
	
	private $item;
	private $subitem;

	private $hookup;
	
	public function getContent() { 

		$this->item = $_GET['item'];
		$this->subitem = $_GET['subitem'];

		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
	
		$this->contentProduct .=<<<EOF
<table class='STATUS_TABLE'>
<tr><th class='TITLE_TD'>Status</th><th class='TITLE_TD'>%</th></tr>
</table>
<table class='STATUS_DOWNLOAD_TABLE'>
<tr>
<th colspan='3' class='TITLE_TD'>{$this->item}_{$this->subitem}</th>
<th class='TITLE_TD'><input type='button' class='CLICKABLE' value='All'></th>
</tr>
<tr>
<td class='TITLE_TD'>Student Name</td>
<td class='TITLE_TD'>Student Account</td>
<td class='TITLE_TD'>Status</td>
<td class='TITLE_TD'>Source Code</td>
</tr>
EOF;


		try {
			$this->hookup = UniversalConnect::doConnect();
			
			$stmt_stu = $this->hookup->prepare('SELECT student_name, student_account FROM student');
			$stmt_stu->execute();
			while($row_stu = $stmt_stu->fetch(PDO::FETCH_ASSOC)) {
				$this->contentProduct .= '<tr><td class=\'CONTENT_TD\'>' . $row_stu['student_name'] . '</td>';
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row_stu['student_account'] . '</td>';
				
				$stmt_item = $this->hookup->prepare('SELECT ' . $row_stu['student_account'] . ' FROM ' . $this->item . ' WHERE subitem=\'' . $this->subitem . '\'');
				$stmt_item->execute();
				$row_item = $stmt_item->fetch(PDO::FETCH_ASSOC);
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . '<p class=\'STATUS_P\'>' . $row_item[$row_stu['student_account']] . '</p>' . '</td>';
				$this->contentProduct .= '<td class=\'CONTENT_TD\'><input type=\'button\' class=\'CLICKABLE\' value=\'Download\'></td></tr>';
			}
	
			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
		$this->contentProduct .= '</table>';	

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
