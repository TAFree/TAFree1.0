<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');

class Fac_verify implements Product {	
	
	private $formatHelper;
	private $contentProduct;

	private $item;
	private $subitem;
	private $stu_account;
	private $judge;

	private $hookup;
	
	public function __construct($fullitem) {
		
		// Get item, subitem, stu_account, judge
		$this->item = substr($fullitem, 0, strrpos($fullitem, '_'));
		$this->subitem = substr($fullitem, strrpos($fullitem, '_') + 1);
		$this->stu_account = 'tester';
		
		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			$stmt = $this->hookup->prepare('SELECT judgescript FROM ' . $this->item . ' WHERE subitem=\'' . $this->subitem . '\'');
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->judge = $row['judgescript'];

			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		
	}

	public function getContent() {
		
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<h1>{$this->item}_{$this->subitem}</h1>
<form method='POST' action='./Verify.php'>
<div class='HIDDEN_DIV'>
<input type='hidden' value='{$this->item}' name='item'>
<input type='hidden' value='{$this->subitem}' name='subitem'>
<input type='hidden' value='{$this->stu_account}' name='stu_account'>
<input type='hidden' value='{$this->judge}' name='judge'>
</div>
<div id='FAC_VERIFY_DIV'>
<input type='submit' class='CLICKABLE' value='Verify >>'>
<pre>
Select tasks for testing judge script:
A qualified judge script is at least able to distinguish status of Accept (AC) & Wrong Answer (WA) from student's source code.
<label for='AC_INPUT'><input type='checkbox' id='AC_INPUT' value='AC' disabled checked name='task[]'>AC (Accept)<input type='hidden' value='AC' name='task[]'></label>
<label for='WA_INPUT'><input type='checkbox' id='WA_INPUT' value='WA' disabled checked name='task[]'>WA (Wrong Anwser)<input type='hidden' value='WA' name='task[]'></label>
<label for='NA_INPUT'><input type='checkbox' id='NA_INPUT' value='NA' name='task[]'>NA (Not Accept, passed part of testdata, not all)</label>
<label for='CE_INPUT'><input type='checkbox' id='CE_INPUT' value='CE' disable name='task[]'>CE (Compile Error)</label>
<label for='RE_INPUT'><input type='checkbox' id='RE_INPUT' value='RE' name='task[]'>RE (Runtime Error)</label>
<label for='SE_INPUT'><input type='checkbox' id='SE_INPUT' value='SE' name='task[]'>SE (System Error, includes all unexpected errors)</label>
<label for='TLE_INPUT'><input type='checkbox' id='TLE_INPUT' value='TLE' name='task[]'>TLE (Time Limit Exceed)</label>
<label for='MLE_INPUT'><input type='checkbox' id='MLE_INPUT' value='MLE' name='task[]'>MLE (Memory Limit Exceed)</label>
<label for='OLE_INPUT'><input type='checkbox' id='OLE_INPUT' value='OLE' name='task[]'>OLE (Output Limit Exceed)</label>
<label for='RF_INPUT'><input type='checkbox' id='RF_INPUT' value='RF' name='task[]'>RF (Restricted Function)</label>
</pre>
</div>
</form>
EOF;
	
		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

?>
