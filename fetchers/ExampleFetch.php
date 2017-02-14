<?php 
namespace TAFree\fetchers;

use TAFree\classes\Product;
use TAFree\database\UniversalConnect;

require_once('../composers/Autoloader.php');

class ExampleFetch implements Product {
	
	private $examples;

	public function getContent() {
		
		$this->examples = '';
	
		$sources = glob('../public/tafree-php/*');
	
		foreach ($sources as $key => $value) {
			$filename = substr($value, strrpos($value, '/') + 1);
			$content = file_get_contents($value);
			$this->examples .= '<h4>' . $filename . '</h4>';
			$this->examples .= '<pre><code>' . htmlspecialchars($content) . '</code></pre><br>';
		}
		
		return $this->examples;
	
	}

}

?>


