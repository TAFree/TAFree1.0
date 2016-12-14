<?php
namespace TAFree\helpers;

use TAFree\routes\SessionManager;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class FormatHelper {

	private $page_identifier;
	private $topper;
	private $bottom;
	private $guest;
	private $nickname;
	private $account;
	private $item;
	private $subitem;
	
	public function __construct($identifier) {
		$id = strtolower($identifier);
		$this->page_identifier = substr($id, strrpos($id, '\\') + 1);
		$this->guest = SessionManager::getParameter('guest');
		$this->nickname = SessionManager::getParameter('nickname');
		$this->account = SessionManager::getParameter('account');
		$this->item = SessionManager::getParameter('item');
		$this->subitem = SessionManager::getParameter('subitem');
	}

	public function addTop() {
		$this->topper =<<<EOF
<!DOCTYPE html>
<html>
<title>TAFree Online Judge</title>
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
<nav>
EOF;

	if (!empty($this->guest) && $this->guest !== false) {
		switch ($this->guest) {
		case 'student':
			$this->topper .= '<img title=\'Hi!\' src=\'../public/tafree-svg/greet.svg\' class=\'NAV_IMG\'><p class=\'NICKNAME_P\'>' . $this->nickname . '</p>';
			$this->topper .= '<a href=\'../views/Stu_problems.php\' class=\'NAV_A\'>Problems</a>';
			$this->topper .= '<a href=\'../views/Stu_record.php\' class=\'NAV_A\'>Record</a>';
			$this->topper .= '<a href=\'../views/Stu_mail.php\' id=\'MAIL_A\' class=\'NAV_A\'>Mail<img class=\'NAV_IMG\' id=\'FLAG_IMG\' src=\'../public/tafree-svg/flag.svg\'></a>';
			$this->topper .= '<a href=\'../views/Stu_score.php\' class=\'NAV_A\'>Score</a>';
			$this->topper .= '<a href=\'../views/Login.php\' class=\'NAV_A\'>Logout</a>';
			if (!empty($this->item)) {
					$this->topper .= '<a href=\'../views/Stu_problem.php?item=' . $this->item . '&subitem=' . $this->subitem . '\' class=\'NAV_PROB_A\'>' . $this->item . '_' . $this->subitem . '</a>';
			}	
			break;
		case 'faculty':
			$this->topper .= '<img title=\'Hi!\' src=\'../public/tafree-svg/greet.svg\' class=\'NAV_IMG\'><p class=\'NICKNAME_P\'>' . $this->nickname . '</p>';
			$this->topper .= '<a href=\'../views/Fac_problems.php\' class=\'NAV_A\'>Problems</a>';
			$this->topper .= '<a href=\'../views/Fac_score.php\' class=\'NAV_A\'>Score</a>';
			$this->topper .= '<a href=\'../views/Fac_mail.php\' id=\'MAIL_A\' class=\'NAV_A\'>Mail<img class=\'NAV_IMG\' id=\'FLAG_IMG\' src=\'../public/tafree-svg/flag.svg\'></a>';
			$this->topper .= '<a href=\'../views/Fac_students.php\' class=\'NAV_A\'>Students</a>';
			$this->topper .= '<a href=\'../views/Fac_expansion.php\' class=\'NAV_A\'>Expansion</a>';
			$this->topper .= '<a href=\'../views/Fac_dashboard.php\' class=\'NAV_A\'>DashBoard</a>';
			$this->topper .= '<a href=\'../views/Login.php\' class=\'NAV_A\'>Logout</a>';
			if (!empty($this->item)) {
					$this->topper .= '<a href=\'../views/Fac_assign.php?item=' . $this->item . '&subitem=' . $this->subitem . '\' class=\'NAV_PROB_A\'>' . $this->item . '_' . $this->subitem . '</a>';
					$this->topper .= '<a href=\'../views/Fac_coders.php\' class=\'NAV_PROB_A\'>Coders</a>';
					$this->topper .= '<a href=\'../views/Fac_display.php\' class=\'NAV_PROB_A\'>Display</a>';
			}
			break;
		case 'administer':
			$this->topper .= '<img title=\'Hi!\' src=\'../public/tafree-svg/greet.svg\' class=\'NAV_IMG\'><p class=\'NICKNAME_P\'>' . $this->nickname . '</p>';
			$this->topper .= '<a href=\'../views/Login.php\' class=\'NAV_A\'>Logout</a>';
			break;
		}
	}
		
		$this->topper .=<<<EOF
</nav>
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
<script src='../public/tafree-js/asset/gamelife.js'></script>
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
