<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\database\UniversalConnect;

require_once('../composers/Autoloader.php');

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

class SourceWatch implements Product {	

	private $formatHelper;
	private $contentProduct;

	private $stu_account;
	private $fullitem;

	private $hookup;

	public function getContent() {
		
		$this->stu_account = $_GET['stu_account'];
		$this->fullitem = $_GET['fullitem'];

		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();

		try {
			$this->hookup = UniversalConnect::doConnect();
			
			$stmt = $this->hookup->prepare('SELECT classname, ' . $this->stu_account . ' FROM ' . $this->fullitem);
			$stmt->execute();
			while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				$this->contentProduct .= '<h1>' . $row['classname'] . '</h1>';
				$this->contentProduct .= '<pre><code>' . htmlspecialchars($row[$this->stu_account]) . '</code></pre><br>';
			}
	
			$this->hookup = null;
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}		
		
		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

require_once('../routes/Dispatcher.php');

?>
