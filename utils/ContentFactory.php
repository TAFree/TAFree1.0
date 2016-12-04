<?php
namespace TAFree\utils;

use TAFree\classes\Product;
use TAFree\classes\Creator;

class ContentFactory extends Creator {
	
	private $content;
	
	protected function factoryMethod(Product $product) {
		$this->content = $product;
		return($this->content->getContent());
	
	}

}

?>
