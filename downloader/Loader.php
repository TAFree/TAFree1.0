<?php 
namespace TAFree\downloader;

use TAFree\utils\Viewer;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Loader {
	
	private $filename;

	public function __construct($filename) {		
		
		if (file_exists($filename)) {
			$this->filename = $filename; 
		}
		else {
			new Viewer ('Msg', 'The file does not exist...');
			exit();
		}
	}
	
	public function download() {		
		header ('Content-Type: text/html');		
		header ('Content-Disposition: attachment; filename="' . basename($this->filename) . '"');		
		header ('Expires: 0');		
		header ('Pragma: no-cache');			
		readfile($this->filename);
		unlink($this->filename);
		exit();
	}
	
}

?>
