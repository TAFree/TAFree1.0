<?php
namespace TAFree\classes;

use TAFree\classes\Product;

abstract class Creator {

	protected abstract function factoryMethod(Product $product);

	public function doFactory($productNow) {
		$pageProduct = $productNow;
		$content = $this->factoryMethod($pageProduct);
		return $content;
		
	}
	
}

?>	
