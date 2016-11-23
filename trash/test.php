<?php
$data = file_get_contents( "php://input" ); 

$obj = json_decode($data); 
foreach($obj as $key => $value) {
	echo $value[0];
}
?>
