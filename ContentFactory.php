<?php

include_once('Creator.php');
include_once('Product.php');

class ContentFactory extends Creator {
	
	private $content;
	
	protected function factoryMethod(Product $product) {
		$this->content = $product;
		return($this->content->getContent());
	
	}

}

?>
