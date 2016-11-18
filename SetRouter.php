<?php

include_once('Router.php');
include_once('Viewer.php');

$router = new Router();

$router->match('GET', '/', function () {
	session_start();
	if (isset($_SESSION)) {
		session_unset();
		session_destroy();
		session_start();
	}
	new Viewer('Login');
});

$router->match('GET', '/Login.php', function () {
	session_start();
	if (isset($_SESSION)) {
		session_unset();
		session_destroy();
		session_start();
	}
	new Viewer('Login');
});

$router->match('GET', '/About.php', function () {
	new Viewer('About');
});

$router->match('GET', '/Instruction.php', function () {
	new Viewer('Instruction');
});

$router->match('GET', '/Language.php', function () {
	new Viewer('Language');
});

$router->match('GET', '/Discussion.php', function () {
	new Viewer('Discussion');
});

$router->match('POST', '/Index.php', function() {
	new Index();
});

$router->match('GET', '/Index.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', '/Initial.php', function() {
	new Initial();
});

$router->match('GET', '/Initial.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', '/ProblemStatus.php', function() {
	new ProblemStatus();
});

$router->match('GET', '/ProblemStatus.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', '/Setup.php', function() {
	new Setup();
});

$router->match('GET', '/Setup.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', '/Present.php', function() {
	new Present();
});

$router->match('GET', '/Present.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', '/Apply.php', function() {
	new Apply();
});

$router->match('GET', '/Apply.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', '/Ratify.php', function() {
	new Ratify();
});

$router->match('GET', '/Ratify.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', '/Alter.php', function() {
	new Alter();
});

$router->match('GET', '/Alter.php', function() {
	new Viewer('Sneaker');
});

$router->match('GET', '/Fac_chooser.php', function() {
	session_start();
	if ($_SESSION['faculty']) {
		new Viewer('Fac_chooser');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', '/Fac_prob.php', function() {
	session_start();
	if ($_SESSION['faculty']) {
		new Viewer('Fac_prob');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', '/Fac_stu.php', function() {
	session_start();
	if ($_SESSION['faculty']) {
		new Viewer('Fac_stu');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', '/Fac_leave.php', function() {
	session_start();
	if ($_SESSION['faculty']) {
		new Viewer('Fac_leave');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', '/Fac_all.php', function() {
	session_start();
	if ($_SESSION['faculty']) {
		new Viewer('Fac_all');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', '/Fac_add_del_stu.php', function() {
	session_start();
	if ($_SESSION['faculty']) {
		new Viewer('Fac_add_del_stu');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', '/Fac_look.php', function() {
	session_start();
	if ($_SESSION['faculty']) {
		new Viewer('Fac_look');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', '/Fac_coders.php', function() {
	session_start();
	if ($_SESSION['FACULTY']) {
		NEW VIEWER('FAC_CODERS');
	} ELSE {
		NEW VIEWER('SNEAKER');
	}
});

$router->match('GET', '/Fac_assign.php', function() {
	session_start();
	if ($_SESSION['faculty'] && $_SESSION['key_to_assign']) {
		unset($_SESSION['key_to_assign']);
		$_SESSION['key_to_upload'] = true;
		new Viewer('Fac_assign');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('POST', '/Upload.php', function() {
	session_start();
	if ($_SESSION['key_to_upload']) {
		unset($_SESSION['key_to_upload']); 
		$_SESSION['key_to_handout'] = true;
		new Upload();
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', '/Upload.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', '/Handout.php', function() {
	session_start();
	if ($_SESSION['key_to_handout']) {
		unset($_SESSION['key_to_handout']); 
		new Handout();
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', '/Handout.php', function() {
	new Viewer('Sneaker');
});


$router->match('GET', '/Fac_score.php', function() {
	session_start();
	if ($_SESSION['faculty']) {
		new Viewer('Fac_score');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', '/Stu_score.php', function() {
	session_start();
	if ($_SESSION['student']) {
		new Viewer('Stu_score');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', '/Stu_chooser.php', function() {
	session_start();
	if ($_SESSION['student']) {
		new Viewer('Stu_chooser');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', '/Stu_prob.php', function() {
	
	session_start();
	
	if ($_SESSION['student']) {
	
		$registry = array();
		$registry['guest'] = 'student';
		$registry['account'] = (string)$_SESSION['student'];
		$registry['destination'] = 'Stu_prob';
		$registry['time'] = date('Y-m-d H:m:s');
		$registry['item'] = $_GET['item'];

		$watchman = new Janitor($registry);
		
		if ($watchman->openDoor()) {
			new Viewer('Stu_prob');
		}
		else {
			new Viewer('Msg', $watchman->dialogue());
		}

	} else {
		new Viewer('Sneaker');
	}

});

$router->match('GET', '/Stu_leave.php', function() {
	session_start();
	if ($_SESSION['student']) { 
		new Viewer('Stu_leave');
	} else {
		new Viewer('Sneaker');
	}
});

?>
