<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\database\UniversalConnect;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');
require_once('../routes/SetRouter.php');

class Fac_leave implements Product {	
	
	private $formatHelper;
	private $contentProduct;

	private $hookup;

	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		$this->contentProduct .=<<<EOF
<form method='POST' action='../controllers/Ratify.php'>
<table id='FAC_LEAVE_TABLE'>
<tr>
<td colspan='8'>
<input type='submit' name='submit' value='Ratify >>'>
<br>
<br>
</td>
</tr>
<tr>
<th class='TITLE_TD'>Timestamp</th>
<th class='TITLE_TD'>Name</th>
<th class='TITLE_TD'>Account</th>
<th class='TITLE_TD'>Item</th>
<th class='TITLE_TD'>Reason</th>
<th class='TITLE_TD'>Expected</th>
<th class='TITLE_TD'>Allowed</th>
<th class='TITLE_TD'>Reply</th>
</tr>
EOF;
		try {
			$this->hookup = UniversalConnect::doConnect();
			$stmt = $this->hookup->prepare('SELECT * FROM apply');
			$stmt->execute();
			
			while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				if ($row['reply'] !== 'Wait') {
					$this->contentProduct .= '<tr>';
					$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['timestamp'] . '</td>';
					$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['student_name'] . '</td>';
					$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['student_account'] . '</td>';
					$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['item'] . '</td>';
					$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['reason'] . '</td>';
					$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['expected_deadline'] . '</td>';
					$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['allowed_deadline'] . '</td>';
					$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['reply'] . '</td>';
					$this->contentProduct .= '</tr>';
				}
			} 
			
			$stmt = $this->hookup->prepare('SELECT * FROM apply');
			$stmt->execute();
			while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				if ($row['reply'] === 'Wait') {
					$this->contentProduct .= '<tr>';
					$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['timestamp'] . '</td>';
					$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['student_name'] . '</td>';
					$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['student_account'] . '</td>';
					$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['item'] . '</td>';
					$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['reason'] . '</td>';
					$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['expected_deadline'] . '</td>';

					$this->contentProduct .=<<<EOF
<td class='CONTENT_TD'>
<input type='date' name='date[]'><br> 
<input type='number' name='hour[]' min='0' max='23' value='00'>&nbsp;:&nbsp;
<input type='number' name='minute[]' min='0' max='59' value='00'> 
</td>
<td class='CONTENT_TD'>
<select name='reply[]'>
<option value='Approve'>Approve</option>
<option value='Deny'>Deny</option>
</select></td>
<td>
<input type='hidden' name='id[]' value='{$row['id']}'>
<input type='hidden' name='email[]' value='{$row['student_account']}@ntu.edu.tw'>
<input type='hidden' name='account[]' value='{$row['student_account']}'>
<input type='hidden' name='item[]' value='{$row['item']}'>
</td>
</tr>
EOF;
				}
			} 
			
			$this->contentProduct .= '</table></form>';
			
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage();
		}
		
		$this->contentProduct .= $this->formatHelper->closeUp();
		return $this->contentProduct;
	
	}	 

}

$router->run();

?>
