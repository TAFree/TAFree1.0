<?php

class Util {
	
	public static function fixInput ($input) {
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		return $input;
	}		 
}

?>
