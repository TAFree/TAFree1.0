<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');
}

class Fac_add_del_stu implements Product {	

	private $formatHelper;
	private $contentProduct;
	private $hookup;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<form method='POST' action='./Alter.php'>
<table id='ADD_DEL_STU_TABLE'>
<tr>
<td colspan='4'>
<input type='submit' name='submit' value='Change >>'>
<br>
<br>
</td>
</tr>
<tr>
<th><button id='ADD_BUTTON' class='ADD_DEL_BUTTON' type='button'><b>+</b></button></td>
<th class='TITLE_TD'>Student Name</th>
<th class='TITLE_TD'>Student Account</th>
<th class='TITLE_TD'>Student Password</th>
</tr>
EOF;
		try {
			$this->hookup = UniversalConnect::doConnect();
			$stmt = $this->hookup->prepare('SELECT * FROM student');
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				if ($row['student_name'] !== 'Super Tester') {
					$this->contentProduct .=<<<EOF
<tr>
<td>
<button class='SUB_ADD_DEL_BUTTON' type='button'><b>-</b></button>
</td>
<td class='CONTENT_TD'>{$row['student_name']}</td>
<td class='CONTENT_TD'>{$row['student_account']}</td>
<td class='CONTENT_TD'>{$row['student_password']}</td>
<td><input type='hidden' value='{$row['student_account']}'></td>
</tr>
EOF;
				}
			}
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}		
		
		$this->contentProduct .=<<<EOF

<tr class='HIDDEN_TR'>
<td><button class='ADD_DEL_BUTTON' type='button'><b>-</b></button></td>
<td class='CONTENT_TD'><input type='text' name='add_name[]'></td>
<td class='CONTENT_TD'><input type='text' name='add_account[]'></td>
<td class='CONTENT_TD'><input type='password' name='add_password[]'></td>
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
