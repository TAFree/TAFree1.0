<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

function __autoload($class_name) {
	include_once($class_name . '.php');
}

class Fac_modify implements Product {	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<form method='POST'>
<div class='FAC_MODIFY_DIV'>
<input type='submit' value='Save >>'>
</div>
EOF;
		$this->contentProduct .=<<<EOF
<table class='CODES_TABLE'>
<tr>
<td>
<div class='BLOCK_DIV'>
<div class='TITLE_DIV'><p class='TITLE_P'>Circle1.java</p><img class='ZOOM_IMG'></div>
<div class='CODE_DIV'>
<pre class='MODIFY_ORIGIN_PRE'>
import  java.util.Scanner;
public class ScannerAndKeyboard
{
	public static void main(String[] args)
	{	
            Scanner s = new Scanner(System.in);
            System.out.print( "Enter your name: "  );
            String name = s.nextLine();
            System.out.println( "Hello " + name + "!" );
        }
}</pre>
</div>
<div class='MODIFY_BAR_DIV'>
<table class='MODIFY_TABLE'>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/line.svg' title='Cut out line'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/block.svg' title='Cut out block'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/all.svg' title='Cut out all'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/rubber.svg' title='Remove line'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/undo.svg' title='Restore'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/lock.svg' title='Lock all'></td></tr>
</table>
</div>
</div>
</td>
<td>
<div class='BLOCK_DIV'>
<div class='TITLE_DIV'><p class='TITLE_P'>Circle2.java</p><img class='ZOOM_IMG'></div>
<div class='CODE_DIV'>
<pre class='MODIFY_ORIGIN_PRE'>
import  java.util.Scanner;
public class ScannerAndKeyboard
{
	public static void main(String[] args)
	{	
            Scanner s = new Scanner(System.in);
            System.out.print( "Enter your name: "  );
            String name = s.nextLine();
            System.out.println( "Hello " + name + "!" );
        }
}</pre>
</div>
<div class='MODIFY_BAR_DIV'>
<table class='MODIFY_TABLE'>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/line.svg' title='Cut out line'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/block.svg' title='Cut out block'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/all.svg' title='Cut out all'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/rubber.svg' title='Remove line'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/undo.svg' title='Restore'></td></tr>
<tr><td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/lock.svg' title='Lock all'></td></tr>
</table>
</div>
</div>
</td>
</tr>
</table>
EOF;
		
		$this->contentProduct .= '</div>';
		
		$this->contentProduct .= $this->formatHelper->closeUp();
		
		return $this->contentProduct;
	}	 

}

if ($router) {
	$router->run();
}
else {
	include_once('SetRouter.php');
	$router->run();
}

?>
