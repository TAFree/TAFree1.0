<?php

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

include_once('FormatHelper.php');
include_once('Product.php');
include_once('SetRouter.php');

class Stu_prob implements Product {	

	private $formatHelper;
	private $contentProduct;
	
	public function getContent() {
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		
		$this->contentProduct .=<<<EOF
<div id='CODE_DIV'>
<form>
<input type='submit' value='Submit >>'><a class='CLICKABLE' href="down_pdf.php">Download PDF</a>
<div class='BLOCK_DIV'>
<div class='TITLE_DIV'>Circle1.java<img class='ZOOM_IMG'></div>
<div class='CODE_DIV'>
<textarea class='BLANK'> 
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
}
</textarea>
</div>
</div>
<div class='BLOCK_DIV'>
<div class='TITLE_DIV'>Circle2.java<img class='ZOOM_IMG'></div>
<div class='CODE_DIV'>
<pre>
                    
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
}
</pre>
</div>
</div>
<div class='BLOCK_DIV'>
<div class='TITLE_DIV'>Circle3.java<img class='ZOOM_IMG'></div>
<div class='CODE_DIV'>
<img src='./tafree-svg/ghost.svg'>
</div>
</div>
<div class='BLOCK_DIV'>
<div class='TITLE_DIV'>Circle4.java<img class='ZOOM_IMG'></div>
<div class='CODE_DIV'>
<pre>

import  java.util.Scanner;
<input type='text' size='100'>
{
    public static void main(String[] args)
    {	
        Scanner s = new Scanner(System.in);
<input type='text' size='100'>
        String name = s.nextLine();
        System.out.println( "Hello " + name + "!" );
    }
}
</pre>
</div>
</div>
</form>
</div>
EOF;
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
