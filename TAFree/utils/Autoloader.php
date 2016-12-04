<?php
namespace TAFree\util;

class Autoloader {
	static public function loader($classname) {
		$shortname = substr($classname, strpos($classname, '\\') + 1);
		$filename = '../' . str_replace('\\', '/', $shortname) . '.php';
		if (file_exists($filename)) {
			include_once($filename);
			if (class_exists($classname)) {
				return true;
			}
		}
		return false;
	}
}

spl_autoload_register('Autoloader::loader');

?>
