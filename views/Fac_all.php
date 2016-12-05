<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\database\UniversalConnect;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');
require_once('../routes/SetRouter.php');

class Fac_all implements Product {	

	private $formatHelper;
	private $contentProduct;

	private $hookup;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<form>
<table id='ALL_TABLE'>
<tr>
<th class='TITLE_TD'>Student Name</th>
<th class='TITLE_TD'>Student Account</th>
<th class='TITLE_TD'>Student Password</th>
</tr>
EOF;
		try {
			$this->hookup = UniversalConnect::doConnect();
			$stmt = $this->hookup->prepare('SELECT * FROM student');
			$stmt->execute();
			while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				$this->contentProduct .=<<<EOF
<tr>
<td class='CONTENT_TD'>{$row['student_name']}</td>
<td class='CONTENT_TD'>{$row['student_account']}</td>
<td class='CONTENT_TD'>{$row['student_password']}</td>
</tr>
EOF;
			}
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}		
		
		$this->contentProduct .= '</table></form>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

$router->run();

?>