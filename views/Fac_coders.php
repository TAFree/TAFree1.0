<?php 
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\database\UniversalConnect;
use TAFree\routes\SessionManager;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Fac_coders implements Product {	

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
<table id='STATUS_TABLE'>
<tr><th class='TITLE_TD'>Status</th><th class='TITLE_TD'>%</th></tr>
</table>
<table id='STATUS_DOWNLOAD_TABLE'>
<tr><th colspan='4' class='TITLE_TD'>{$this->item}_{$this->subitem}</th></tr>
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
			while($row_stu = $stmt_stu->fetch(\PDO::FETCH_ASSOC)) {
				$this->contentProduct .= '<tr><td class=\'CONTENT_STU_INFO_TD\'>' . $row_stu['student_name'] . '</td>';
				$this->contentProduct .= '<td class=\'CONTENT_STU_INFO_TD\'>' . $row_stu['student_account'] . '</td>';
				
				$stmt_item = $this->hookup->prepare('SELECT ' . $row_stu['student_account'] . ' FROM ' . $this->item . ' WHERE subitem=\'' . $this->subitem . '\'');
				$stmt_item->execute();
				$row_item = $stmt_item->fetch(\PDO::FETCH_ASSOC);
				$status = $row_item[$row_stu['student_account']];
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . '<p class=\'STATUS_CODE_P\'>' . $status . '</p>' . '</td>';
				if ($status !== 'NULL') {
					$this->contentProduct .= '<td class=\'CONTENT_TD\'><a class=\'CLICKABLE\' href=\'../views/SourceWatch.php?stu_account=' . $row_stu['student_account'] . '&fullitem=' . $this->item . '_' . $this->subitem . '\'>Watch</a></td></tr>';
				}
				else {
					$this->contentProduct .= '<td class=\'CONTENT_TD\'></td></tr>';
				}
			}
	
			$this->hookup = null;
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
		$this->contentProduct .= '</table>';	

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;

	}

}	
		
require_once('../routes/Dispatcher.php');

?>
