<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\database\UniversalConnect;
use TAFree\routes\SessionManager;

require_once('../composers/Autoloader.php');

class Stu_mail implements Product {	
	
	private $formatHelper;
	private $contentProduct;
	private $student_name;
	private $student_account;

	private $hookup;

	public function __construct () {
		$this->student_name = SessionManager::getParameter('nickname');
		$this->student_account = SessionManager::getParameter('account');
	}

	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		$this->contentProduct .=<<<EOF
<form method='POST' action='../controllers/Apply.php'>
<table id='STU_LEAVE_TABLE'>
<tr>
<td colspan='7'>
<input type='submit' name='submit' value='Apply >>'>
<br>
<br>
</td>
</tr>
<tr>
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
			$stmt = $this->hookup->prepare('SELECT * FROM apply WHERE student_account=?');
			$stmt->execute(array($this->student_account));
			while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				$this->contentProduct .= '<tr>';
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['student_name'] . '</td>';
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['student_account'] . '</td>';
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['item'] . '</td>';
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['reason'] . '</td>';
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['expected_deadline'] . '</td>';
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['allowed_deadline'] . '</td>';
				$this->contentProduct .= '<td class=\'CONTENT_TD\'>' . $row['reply'] . '</td>';
				$this->contentProduct .= '</tr>';
			} 
			
			$this->contentProduct .=<<<EOF
<tr>
<td class='CONTENT_TD'>{$this->student_name}</td>
<td class='CONTENT_TD'>{$this->student_account}</td>
<td class='CONTENT_TD'>
<select name='item'>
EOF;
			$stmt = $this->hookup->prepare('SELECT item FROM problem');
			$stmt->execute();
			while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				$this->contentProduct .= '<option value=\'' . $row['item'] . '\'>' . $row['item'] . '</option>';
			}
			
			$this->contentProduct .=<<<EOF
</select>
</td>
<td class='CONTENT_TD'><textarea name='reason' row='30' cols='50'></textarea></td>
<td class='CONTENT_TD'>
<input type='date' name='date'><br>
<input type='number' name='hour' min='0' max='23' value='00'>&nbsp;:&nbsp;
<input type='number' name='minute' min='0' max='59' value='00'>
</td>
<td class='CONTENT_TD'>
</td>
<td class='CONTENT_TD'>
</td>
</tr>
EOF;
			$this->contentProduct .= '</table></form>';
			
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
