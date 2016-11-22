<?php
function __autoload ($class_name) {
	include_once($class_name . '.php');
}
$loader = new Loader($_GET['filename']);
$loader->download();
?>
