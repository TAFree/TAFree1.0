<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\database\UniversalConnect;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Fac_expansion implements Product {	

	private $formatHelper;
	private $contentProduct;
	private $generalJudges;
	private $exts = array();
	private $cmds = array();
	private $judgescripts = array();
	private $hookup;

	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<form method='POST' action='../controllers/Expand.php' enctype='multipart/form-data'>
<div class='PUT_BUTTON_DIV'>
<input class='CLICKABLE' type='submit' value='Expand'>
</div>
<table id='EXPANSION_TABLE'>
<tr>
<th colspan='2' class='TITLE_TD'><input type='checkbox' name='service[]' value='plugin'>Plug In</th>
</tr>
<tr>
<td class='CONTENT_TD'>General Judge Script</td>
<td class='CONTENT_TD'>
<input type='file' name='add_judge'>
</td>
</tr>
<tr>
<td class='CONTENT_TD'>
<pre>python3 Hello.py</pre>
</td>
<td class='CONTENT_TD'>
<pre>
<input type='text' class='EXPAND_INPUT' name='cmd'> Hello.<input type='text' class='EXPAND_INPUT' name='ext'>
</pre>
</td>
</tr>
<tr>
<th colspan='2' class='TITLE_TD'><input type='checkbox' name='service[]' value='plugout'>Plug Out</th>
</tr>
EOF;
		try {
			$this->hookup = UniversalConnect::doConnect();						
			
			// Get general judge script
			$stmt_judgescript = $this->hookup->prepare('SELECT judgescript FROM general');
			$stmt_judgescript->execute();
			while($row = $stmt_judgescript->fetch(\PDO::FETCH_ASSOC)) {
				array_push($this->judgescripts, $row['judgescript']);
			}
			$this->contentProduct .= '<tr><td class=\'CONTENT_TD\'>General Judge Script</td><td class=\'CONTENT_TD\'><select id=\'JUDGE_SELECT\' name=\'del_judge\'><option value=\'no\'>No</option>';
			for ($i = 0; $i < count($this->judgescripts); $i += 1) {
				$this->contentProduct .= '<option value=\'' . $this->judgescripts[$i] . '\'>' . $this->judgescripts[$i] . '</option>';
			}
			$this->contentProduct .= '</select></td></tr>';
		
			// Get script language support
			$stmt_support = $this->hookup->prepare('SELECT ext, cmd FROM support');
			$stmt_support->execute();
			while($row = $stmt_support->fetch(\PDO::FETCH_ASSOC)) {
				array_push($this->exts, $row['ext']);
				array_push($this->cmds, $row['cmd']);
			}
			$this->contentProduct .= '<tr><td class=\'CONTENT_TD\' rowspan=\'' . count($this->exts) . '\'>Script Language Support</td>';
			for ($i = 0; $i < count($this->exts); $i += 1) {
				$this->contentProduct .= '<td class=\'CONTENT_TD\'><pre><input type=\'checkbox\' name=\'support[]\' value=\'' . $this->exts[$i] . '\'>' . $this->cmds[$i]. ' Hello.' . $this->exts[$i] . '</pre></td></tr>';
			}
	
			$this->hookup = null;
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		

		$this->contentProduct .= '</table></form>';

		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

require_once('../routes/Dispatcher.php');

?>
