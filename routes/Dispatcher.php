<?php
use TAFree\routes\Router;
use TAFree\routes\Janitor;
use TAFree\routes\SessionManager;
use TAFree\utils\Viewer;
use TAFree\controllers as controllers;
use TAFree\fetchers as fetchers;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

$router = new Router();

$router->match('GET', '/', function () {
	SessionManager::init();
	new Viewer('Login');
});

$router->match('GET', 'Login.php', function () {
	SessionManager::init();
	new Viewer('Login');
});

$router->match('GET', 'About.php', function () {
	new Viewer('About');
});

$router->match('GET', 'Instruction.php', function () {
	new Viewer('Instruction');
});

$router->match('GET', 'Support.php', function () {
	new Viewer('Support');
});

$router->match('GET', 'Discussion.php', function () {
	new Viewer('Discussion');
});

$router->match('POST', 'MessagePull.php', function () {
	new controllers\MessagePull();
});

$router->match('GET', 'MessagePull.php', function () {
	new Viewer('Sneaker');
});

$router->match('POST', 'MessagePush.php', function () {
	new controllers\MessagePush();
});

$router->match('GET', 'MessagePush.php', function () {
	new Viewer('Sneaker');
});

$router->match('POST', 'Index.php', function() {
	new controllers\Index();
});

$router->match('GET', 'Index.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', 'Initial.php', function() {
	new controllers\Initial();
});

$router->match('GET', 'Initial.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', 'ProblemStatus.php', function() {
	new controllers\ProblemStatus();
});

$router->match('GET', 'ProblemStatus.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', 'AssignControl.php', function() {
	new controllers\AssignControl();
});

$router->match('GET', 'AssignControl.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', 'Setup.php', function() {
	new controllers\Setup();
});

$router->match('GET', 'Setup.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', 'Present.php', function() {
	new controllers\Present();
});

$router->match('GET', 'Present.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', 'Apply.php', function() {
	new controllers\Apply();
});

$router->match('GET', 'Apply.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', 'Ratify.php', function() {
	new controllers\Ratify();
});

$router->match('GET', 'Ratify.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', 'Alter.php', function() {
	new controllers\Alter();
});

$router->match('GET', 'Alter.php', function() {
	new Viewer('Sneaker');
});

$router->match('GET', 'Fac_problems.php', function() {
	if (SessionManager::getParameter('guest') === 'faculty') {
		new Viewer('Fac_problems');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', 'Fac_prob.php', function() {
	session_start();
	if (isset($_SESSION['faculty'])) {
		new Viewer('Fac_prob');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', 'Fac_stu.php', function() {
	session_start();
	if (isset($_SESSION['faculty'])) {
		new Viewer('Fac_stu');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', 'Fac_leave.php', function() {
	session_start();
	if (isset($_SESSION['faculty'])) {
		new Viewer('Fac_leave');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', 'Fac_expansion.php', function() {
	session_start();
	if (isset($_SESSION['faculty'])) {
		new Viewer('Fac_expansion');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('POST', 'Expand.php', function() {
	new controllers\Expand();
});

$router->match('GET', 'Expand.php', function() {
	new Viewer('Sneaker');
});

$router->match('GET', 'Fac_all.php', function() {
	session_start();
	if (isset($_SESSION['faculty'])) {
		new Viewer('Fac_all');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', 'Fac_add_del_stu.php', function() {
	session_start();
	if (isset($_SESSION['faculty'])) {
		new Viewer('Fac_add_del_stu');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', 'Fac_look.php', function() {
	session_start();
	if (isset($_SESSION['faculty'])) {
		new Viewer('Fac_look');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', 'Fac_coders.php', function() {
	session_start();
	if (isset($_SESSION['faculty'])) { 
		new viewer('Fac_coders');
	} else {
		new viewer('sneaker');
	}
});

$router->match('GET', 'Fac_assign.php', function() {

	$looker = new fetchers\KeyQuery($_GET['item']);
	
	session_start();

	if (!isset($_SESSION['key_to_assign'])) {
		$_SESSION['key_to_assign'] = $_GET['key_to_assign'];
	}

	if (isset($_SESSION['faculty']) && $_SESSION['key_to_assign'] === $looker->findKey()) {
		$_SESSION['key_to_assign'] = '19911010';
		$_SESSION['key_to_upload'] = $looker->findKey();
		new Viewer('Fac_assign');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('POST', 'Upload.php', function() {
	
	$looker = new fetchers\KeyQuery($_POST['item']);
	
	session_start();

	if (isset($_SESSION['key_to_upload']) && $_SESSION['key_to_upload'] === $looker->findKey()) {
		unset($_SESSION['key_to_upload']); 
		$_SESSION['key_to_handout'] = $looker->findKey();
		new controllers\Upload();
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', 'Upload.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', 'Handout.php', function() {
	
	$looker = new fetchers\KeyQuery($_POST['item']);
	
	session_start();

	if (isset($_SESSION['key_to_handout']) && $_SESSION['key_to_handout'] === $looker->findKey()) {
		unset($_SESSION['key_to_handout']); 
		new controllers\Handout();
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', 'Handout.php', function() {
	new Viewer('Sneaker');
});

$router->match('GET', 'Fac_score.php', function() {
	if (SessionManager::getParameter('guest') === 'faculty') {
		new Viewer('Fac_score');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', 'ScoreTar.php', function() {
	new Viewer('Sneaker');
});

$router->match('POST', 'ScoreTar.php', function() {
	if (SessionManager::getParameter('guest') === 'faculty') {
		new fetchers\ScoreTar();
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', 'Stu_score.php', function() {
	session_start();
	if (isset($_SESSION['student'])) {
		new Viewer('Stu_score');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', 'Stu_record.php', function() {
	session_start();
	if (isset($_SESSION['student'])) {
		new Viewer('Stu_record');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', 'SourceWatch.php', function() {
	session_start();
	foreach ($_SESSION as $key => $value) {
		if ($key === 'student' || $key === 'faculty') {
			new Viewer('SourceWatch');
			return;
		}
	}
	new Viewer('Sneaker');
});

$router->match('GET', 'Stu_chooser.php', function() {

	session_start();

	$_SESSION['key_to_write'] = true;

	if (isset($_SESSION['student'])) {
		new Viewer('Stu_chooser');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', 'Stu_prob.php', function() {
	
	session_start();
	
	if (isset($_SESSION['student']) && isset($_SESSION['key_to_write'])) {

		unset($_SESSION['key_to_write']);
		$registry = array();
		$registry['guest'] = 'student';
		$registry['account'] = (string)$_SESSION['student'];
		$registry['destination'] = 'Stu_prob';
		$registry['time'] = date('Y-m-d H:i:s');
		$registry['item'] = $_GET['item'];

		$watchman = new Janitor($registry);
		
		if ($watchman->openDoor()) {
			$info = array (
				'stu_account' => $_SESSION['student'],
				'item' => $_GET['item'],
				'subitem' => $_GET['subitem']
			);
			new Viewer('Stu_prob', $info);
		}
		else {
			new Viewer('Msg', $watchman->dialogue());
		}

	} else {
		new Viewer('Sneaker');
	}

});

$router->match('GET', 'Stu_leave.php', function() {
	session_start();
	if (isset($_SESSION['student'])) { 
		new Viewer('Stu_leave');
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('GET', 'JudgeAdapter.php', function() {
	session_start();
	if (isset($_SESSION['student'])) { 
		new controllers\JudgeAdapter();
	} else {
		new Viewer('Sneaker');
	}
});

$router->match('POST', 'Handin.php', function() {

	session_start();
	
	if (isset($_SESSION['student'])) {
	
		$data = file_get_contents('php://input'); 
		$obj = json_decode($data); 
		
		// Configure registry array
		$registry = array();
		$registry['guest'] = 'student';
		$registry['account'] = (string)$_SESSION['student'];
		$registry['destination'] = 'Handin';
		$registry['time'] = date('Y-m-d H:i:s');
		$registry['item'] = $obj->item;

		$watchman = new Janitor($registry);
		
		if ($watchman->openDoor()) {
			new controllers\Handin();
		}
		else {
			new Viewer('Msg', $watchman->dialogue());
		}

	} else {
		new Viewer('Sneaker');
	}

});

$router->match('GET', 'Handin.php', function() {
	new Viewer('Sneaker');

});

$router->run();

?>
