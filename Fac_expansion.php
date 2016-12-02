<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');
}

class Fac_expansion implements Product {	

	private $formatHelper;
	private $contentProduct;
	private $generalJudges;
	private $exts = array();
	private $cmds = array();
	private $hookup;

	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<form method='POST' action='./Expand.php' enctype='multipart/form-data'>
<div id='FAC_EXPANSION_DIV'>
<input type='submit' value='Expand >>'>
</div>
<table id='EXPANSION_TABLE'>
<tr>
<th colspan='2' class='TITLE_TD'><input type='checkbox' name='service[]' value='plugin'>Plug In</th>
</tr>
<tr>
<td class='CONTENT_TD'>Explanation</td>
<td class='CONTENT_TD'>
<pre>
TAFree accepts an executable command in bash,
For example, python3 hello.py
File Extension: py
Executing Command: python3
</pre>
</td>
</tr>
<tr>
<td class='CONTENT_TD'>File Extension</td>
<td class='CONTENT_TD'><input type='text' class='FILL_INPUT' name='ext'></td>
</tr>
<tr>
<td class='CONTENT_TD'>Executing Command</td>
<td class='CONTENT_TD'><input type='text' class='FILL_INPUT' name='cmd'></td>
</tr>
<tr>
<th colspan='2' class='TITLE_TD'><input type='checkbox' name='service[]' value='plugout'>Plug Out</th>
</tr>
<tr>
<td class='CONTENT_TD'>Judge Script</td>
<td class='CONTENT_TD'>
<select id='JUDGE_SELECT' name='judge'>
<option value='no'>No</option>
EOF;
		
		$generalJudges = glob('judge/*');
		foreach ($generalJudges as $file) {
			$file = (string)$file;
			$filename = substr($file, strripos($file, '/') + 1);
			$this->contentProduct .= '<option value=\'' . $filename . '\'>' . $filename . '</option>';
		}
		
		$this->contentProduct .=<<<EOF
</select>
</td>
</tr>
EOF;
				
		try {
			$this->hookup = UniversalConnect::doConnect();						

			$stmt = $this->hookup->prepare('SELECT ext, cmd FROM support');
			$stmt->execute();

			while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				array_push($this->exts, $row['ext']);
				array_push($this->cmds, $row['cmd']);
			}
				
			$this->contentProduct .= '<tr><td class=\'CONTENT_TD\' rowspan=\'' . count($this->exts) . '\'>Language Support</td>';
			
			for ($i = 0; $i < count($this->exts); $i += 1) {
				$this->contentProduct .= '<td class=\'CONTENT_TD\'><input type=\'checkbox\' name=\'support[]\' value=\'' . $this->exts[$i] . '\'>' . $this->cmds[$i]. ' Hello.' . $this->exts[$i] . '</td></tr>';
			}
	
			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
		

		$this->contentProduct .= '</table></form>';

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
