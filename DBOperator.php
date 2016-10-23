<?php

class DBOperator {
	
	public function initial() {
		$context = new Context(new RawDataEntry);
		$context->algorithm();
	}		

	public function queryStudent() {
		$context = new Context(new StudentQuery);
		$context->algorithm();
	}
}

?>
