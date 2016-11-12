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
		
		$this->contentProduct .= '<div class=\'PREV_NEXT_DIV\'><img width=30 height=30 src=\'tafree-svg/previous.svg\'><strong>Step 2. Modify</strong><img width=30 height=30 src=\'tafree-svg/next.svg\'></div>';
		
		$this->contentProduct .=<<<EOF
                <table class='CODES_TABLE'>
		<tr><td>
		<div class='BLOCK_DIV'>
                    <div class='TITLE_DIV'>Circle1.java<img class='ZOOM_IMG'></div>
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
		    <div class='MODIFY_BAR_DIV'>
			
			<table class='MODIFY_TABLE'>
				<tr><td class='MODIFY_TR' colspan='3'>Select</td></tr>
				<tr>
					<td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/ghost.svg'></td>
					<td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/ghost.svg'></td>
					<td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/ghost.svg'></td>
				</tr>
				<tr><td class='MODIFY_TR' colspan='3'>Action</td></tr>
				<tr>
					<td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/ghost.svg'></td>
					<td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/ghost.svg'></td>
					<td><img class='MODIFY_BUTTON_IMG' src='tafree-svg/ghost.svg'></td>
				</tr>
			</table>
		    </div>
		</div>
		</td><td>
                <div class='BLOCK_DIV'>
                    <div class='TITLE_DIV'>Circle1.java<img class='ZOOM_IMG'></div>
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
                </div></td><td>
                <div class='BLOCK_DIV'>
                    <div class='TITLE_DIV'>Circle1.java<img class='ZOOM_IMG'></div>
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
                </div></td>
<tr>
</table>
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
