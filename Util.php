<?php

class Util {
	
	public static function fixInput ($input) {
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		return $input;
	}

	public static function intFilter ($input) {
		if (!filter_var($input, FILTER_VALIDATE_INT) === false){
			return true;	
		}
		else {
			return false;
		}
	}		 
	
	public static function anFilter ($input) {
		if (ctype_alnum($input)) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public static function mailFilter ($input) {
		if (!filter_var($input, FILTER_VALIDATE_EMAIL) === false){
			return true;	
		}
		else {
			return false;
		}	
	}

}

?>
