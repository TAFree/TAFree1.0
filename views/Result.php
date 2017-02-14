<?php
namespace TAFree\views;

use TAFree\database\UniversalConnect;
use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;

require_once('../composers/Autoloader.php');

class Result implements Product{
	
	private $content;

	private $formatHelper;
	private $contentProduct;

	private $hookup;
	
	public function __construct ($id) {
		
		try {
			$this->hookup = UniversalConnect::doConnect();
			$stmt = $this->hookup->prepare('SELECT view FROM process WHERE id=\'' . $id . '\'');	
			$stmt->execute();
			$row =	$stmt->fetch(\PDO::FETCH_ASSOC);	
			$this->content = $row['view'];
			$this->hookup = null;
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
			exit();
		}
	}
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		$this->contentProduct .= $this->content;
		$this->contentProduct .= $this->formatHelper->closeUp();
		return $this->contentProduct;
	}	 

}

require_once('../routes/Dispatcher.php');

?>

