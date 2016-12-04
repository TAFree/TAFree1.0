<?php
namespace TAFree\helpers;

class FormatHelper {

	private $page_identifier;
	private $topper;
	private $bottom;
	
	
	public function __construct($identifier) {
		$id = strtolower($identifier);
		$this->page_identifier = substr($id, strrpos($id, '\\') + 1);
	}

	public function addTop() {
		$this->topper =<<<EOF
<!DOCTYPE html>
<html>
<title>Title</title>
<meta charset='utf-8'>
<head>
<link type='text/css' rel='stylesheet' href='../public/tafree-css/theme.css'>		
<link type='text/css' rel='stylesheet' href='../public/tafree-css/main.css'>		
<link type='image/x-icon' rel='shortcut icon' href='../public/tafree-ico/logo.ico'>		
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.8.0/styles/ir-black.min.css">
<script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.8.0/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
</head>
<body>
<div id='HEADER_DIV'>
<header></header>
<nav></nav>
</div>
<content>
EOF;
		return $this->topper;
	}
	
	public function closeUp() {
		$this->bottom =<<<EOF
</content>
<footer></footer>
<!-- need a release schedule-->
<script src='../public/tafree-js/ns/tafree.js'></script>
<script src='../public/tafree-js/util/dom.js'></script>
<script src='../public/tafree-js/util/init.js'></script>
<script src='../public/tafree-js/asset/polygon.js'></script>
<script src='../public/tafree-js/page/data.js'></script>
<script src='../public/tafree-js/page/addon.js'></script>
<script src='../public/tafree-js/page/feature.js'></script>
<script src='../public/tafree-js/page/process.js'></script>
<script src='../public/tafree-js/page/init.js'></script>
<script src='../public/tafree-js/page/hash.js'></script>
<script>TAFree.util.Init.match('$this->page_identifier');</script>
</body>
</html>
EOF;
		return $this->bottom;
	}

}

?>
