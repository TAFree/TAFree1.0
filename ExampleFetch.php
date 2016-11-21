<?php 

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

class ExampleFetch implements Product {
	
	private $examples;

	public function getContent() {
		
		$this->examples = '';

		foreach (glob('./judge/*') as $filename) {
			$ext = substr($filename, strrpos($filename, '.') + 1);
			$handle = fopen($filename, 'r');
			$contents = fread($handle, filesize($filename));
			$this->examples .= '<pre><code class=\'' . $ext . '\'>' . '//' . $filename . '<br><br>' . htmlspecialchars($contents) . '</code></pre>';
			fclose($handle);
		}
		
		return $this->examples;
	}

}

?>


