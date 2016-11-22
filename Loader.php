<?php 

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
		header ('Content-Description: File Transfer');		
		header ('Content-Type: application/octet-stream');		
		header ('Content-Disposition: attachment; filename="' . basename($this->filename) . '"');		
		header ('Expires: 0');		
		header ('Cache-Control: must-revalidate');		
		header ('Pragma: public');		
		header ('Content-Length: ' . filesize($this->filename));		
		readfile($this->filename);
		unlink($this->filename);
		exit();
	}
	
}

?>
