<?php

class DBOperator {
	
	public function initial() {
		$context = new Context(new RawDataEntry);
		$context->algorithm();
	}		
}

?>
