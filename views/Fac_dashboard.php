<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\database\UniversalConnect;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Fac_dashboard implements Product {	
	
	private $formatHelper;
	private $contentProduct;

	private $hookup;

	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		$this->contentProduct .=<<<EOF
<table id='FAC_DASHBOARD_TABLE'>
<tr>
<th class='TITLE_TD'>ID</th>
<th class='TITLE_TD'>Timestamp</th>
<th class='TITLE_TD'>Submitter</th>
<th class='TITLE_TD'>Judger</th>
<th class='TITLE_TD'>Student Account</th>
<th class='TITLE_TD'>Student Name</th>
<th class='TITLE_TD'>Item</th>
<th class='TITLE_TD'>Subitem</th>
</tr>
EOF;
		try {
			$this->hookup = UniversalConnect::doConnect();
			$stmt = $this->hookup->prepare('SELECT * FROM process');
			$stmt->execute();
			
			while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				$this->contentProduct .= '<tr>';
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['id'] . '</td>';
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['timestamp'] . '</td>';
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['submitter'] . '</td>';
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['judger'] . '</td>';
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['student_account'] . '</td>';
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['student_name'] . '</td>';
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['item'] . '</td>';
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['subitem'] . '</td>';
				$this->contentProduct .= '</tr>';
			} 
			
			$this->contentProduct .= '</table>';
			
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage();
		}
		
		$this->contentProduct .= $this->formatHelper->closeUp();
		return $this->contentProduct;
	
	}	 

}

require_once('../routes/Dispatcher.php');

?>
