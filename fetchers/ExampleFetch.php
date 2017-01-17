<?php 
namespace TAFree\fetchers;

use TAFree\classes\Product;
use TAFree\database\UniversalConnect;

require_once('../composers/Autoloader.php');

class ExampleFetch implements Product {
	
	private $examples;
	private $hookup;

	public function getContent() {
		
		$this->examples = '';
			
		try {
			
			$this->hookup = UniversalConnect::doConnect();	
		
			// Get judgescript and content from general table	
			$stmt = $this->hookup->prepare('SELECT * FROM general');
			$stmt->execute();
			while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				$filename = $row['judgescript'];
				$ext = '';
				if (preg_match('/[^\.]+$/i', $filename, $matches)) {
					$ext = $matches[0];
				}
				$this->examples .= '<h4>' . $filename . '</h4>';
				$this->examples .= '<pre><code class=\'' . $ext . '\'>' . htmlspecialchars($row['content']) . '</code></pre><br>';
			}

			$this->hookup = null;
	
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}	
		
		return $this->examples;
	
	}

}

?>


