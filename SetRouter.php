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

$router->match('GET', '/Support.php', function () {
	new Viewer('Support');
});

$router->match('GET', '/Discussion.php', function () {
	new Viewer('Discussion');
});

$router->match('POST', '/MessagePull.php', function () {
	new MessagePull();
});

$router->match('GET', '/MessagePull.php', function () {
	new Viewer('Sneaker');
});

$router->match('POST', '/MessagePush.php', function () {
	new MessagePush();
});

$router->match('GET', '/MessagePush.php', function () {
	new Viewer('Sneaker');
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

$router->match('POST', '/AssignControl.php', function() {
	new AssignControl();
});

$router->match('GET', '/AssignControl.php', function() {
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
	if ($_SESSION['faculty']) { 
		new viewer('Fac_coders');
	} else {
		new viewer('sneaker');
	}
});

$router->match('GET', '/Fac_assign.php', function() {

	$looker = new KeyQuery($_GET['item']);
	
	session_start();

	if ($_SESSION['faculty'] && $_SESSION['key_to_assign'] === $looker->findKey()) {
		unset($_SESSION['key_to_assign']);
		$_SESSION['key_to_upload'] = $looker->findKey();
		new Viewer('Fac_assign');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('POST', '/Upload.php', function() {
	
	$looker = new KeyQuery($_POST['item']);
	
	session_start();

	if ($_SESSION['key_to_upload'] === $looker->findKey()) {
		unset($_SESSION['key_to_upload']); 
		$_SESSION['key_to_handout'] = $looker->findKey();
		new Upload();
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', '/Upload.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', '/Handout.php', function() {
	
	$looker = new KeyQuery($_POST['item']);
	
	session_start();

	if ($_SESSION['key_to_handout'] === $looker->findKey()) {
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
		$registry['time'] = date('Y-m-d H:i:s');
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

$router->match('POST', '/Handin.php', function() {

	session_start();
	
	if ($_SESSION['student']) {
	
		$registry = array();
		$registry['guest'] = 'student';
		$registry['account'] = (string)$_SESSION['student'];
		$registry['destination'] = 'Handin';
		$registry['time'] = date('Y-m-d H:i:s');
		$registry['item'] = $_POST['item'];

		$watchman = new Janitor($registry);
		
		if ($watchman->openDoor()) {
			new Viewer('Handin');
		}
		else {
			new Viewer('Msg', $watchman->dialogue());
		}

	} else {
		new Viewer('Sneaker');
	}

});

$router->match('GET', '/Handin.php', function() {
	new Viewer('Sneaker');

});

?>
