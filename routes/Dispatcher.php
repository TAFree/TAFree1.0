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

$router->match('POST', 'MessagePush.php', function () {
	new controllers\MessagePush();
});

$router->match('POST', 'Index.php', function() {
	new controllers\Index();
});

$router->match('POST', 'Initial.php', function() {
	if (SessionManager::getParameter('guest') === 'administer') {
		new controllers\Initial();
	}
});

$router->match('POST', 'ProblemStatus.php', function() {
	if (SessionManager::getParameter('guest') === 'faculty') {
		new controllers\ProblemStatus();
	}
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('POST', 'Setup.php', function() {
	if (SessionManager::getParameter('guest') === 'faculty') {
		new controllers\Setup();
	}
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('POST', 'Present.php', function() {
	if (SessionManager::getParameter('guest') === 'faculty') {
		new controllers\Present();
	}
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('POST', 'Apply.php', function() {
	if (SessionManager::getParameter('guest') === 'student' && SessionManager::getParameter('key_to_apply')) {
		SessionManager::deleteParameter('key_to_apply');
		new controllers\Apply();
	}
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('POST', 'Ratify.php', function() {
	if (SessionManager::getParameter('guest') === 'faculty' && SessionManager::getParameter('key_to_ratify')) {
		SessionManager::deleteParameter('key_to_ratify');
		new controllers\Ratify();
	}
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('POST', 'Alter.php', function() {
	if (SessionManager::getParameter('guest') === 'faculty' && SessionManager::getParameter('key_to_alter')) {
		SessionManager::deleteParameter('key_to_alter');
		new controllers\Alter();
	}
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('GET', 'Fac_problems.php', function() {
	if (SessionManager::getParameter('guest') === 'faculty') {
		new Viewer('Fac_problems');
	} 
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('GET', 'Fac_students.php', function() {
	if (SessionManager::getParameter('guest') === 'faculty') {
		SessionManager::setParameter('key_to_alter', true);
		new Viewer('Fac_students');
	} 
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('GET', 'Fac_mail.php', function() {
	if (SessionManager::getParameter('guest') === 'faculty') {
		SessionManager::setParameter('key_to_ratify', true);
		new Viewer('Fac_mail');
	} 
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('GET', 'Fac_expansion.php', function() {
	if (SessionManager::getParameter('guest') === 'faculty') {
		SessionManager::setParameter('key_to_expand', true);
		new Viewer('Fac_expansion');
	} 
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('POST', 'Expand.php', function() {
	if (SessionManager::getParameter('guest') === 'faculty' && SessionManager::getParameter('key_to_expand')) {
		SessionManager::deleteParameter('key_to_expand');
		new controllers\Expand();
	}
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('GET', 'Fac_display.php', function() {
	if (SessionManager::getParameter('guest') === 'faculty') {
		new Viewer('Fac_display');
	} 
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('GET', 'Fac_coders.php', function() {
	if (SessionManager::getParameter('guest') === 'faculty') {
		new viewer('Fac_coders');
	} 
	else {
		new viewer('Sneaker');
		exit();
	}
});

$router->match('GET', 'Fac_assign.php', function() {

	// Set session variables of item and subitem
	if (SessionManager::getParameter('guest') === 'faculty') {
		SessionManager::setParameter('item', $_GET['item']);
		SessionManager::setParameter('subitem', $_GET['subitem']);
	}
	else {
		new Viewer('Sneaker');
		exit();
	}

	$item = SessionManager::getParameter('item');

	// Generate a key to assign problem and update this key in problem table if there is no key_to_assign session variable
	if (!SessionManager::getParameter('key_to_assign')) {
		$controller = new controllers\AssignControl($item);
		$key = $controller->getKey();
		SessionManager::setParameter('key_to_assign', $key);
	}
	
	// Query key in problem table
	$looker = new fetchers\KeyQuery($item);

	// Compare keys from problem table and session variable
	if (SessionManager::getParameter('key_to_assign') === $looker->findKey()) {
		SessionManager::deleteParameter('key_to_assign');
		SessionManager::setParameter('key_to_upload', $looker->findKey());
		new Viewer('Fac_assign');
	} 
	else {
		new Viewer('Sneaker');
		exit();
	}

});

$router->match('POST', 'Upload.php', function() {
	
	$item = SessionManager::getParameter('item');
	
	// Query key in problem table
	$looker = new fetchers\KeyQuery($item);
	
	// Compare keys from problem table and session variable
	if (SessionManager::getParameter('guest') === 'faculty' && SessionManager::getParameter('key_to_upload') === $looker->findKey()) {
		SessionManager::deleteParameter('key_to_upload');
		SessionManager::setParameter('key_to_handout', $looker->findKey());
		new controllers\Upload();
	} 
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('POST', 'Handout.php', function() {
	
	$item = SessionManager::getParameter('item');
		
	// Query key in problem table
	$looker = new fetchers\KeyQuery($item);
	
	// Compare keys from problem table and session variable
	if (SessionManager::getParameter('guest') === 'faculty' && SessionManager::getParameter('key_to_handout') === $looker->findKey()) {
		SessionManager::deleteParameter('key_to_handout');
		new controllers\Handout();
	} 
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('GET', 'Fac_score.php', function() {
	if (SessionManager::getParameter('guest') === 'faculty') {
		new Viewer('Fac_score');
	} 
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('POST', 'ScoreTar.php', function() {
	if (SessionManager::getParameter('guest') === 'faculty') {
		new fetchers\ScoreTar();
	} 
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('GET', 'Stu_score.php', function() {
	if (SessionManager::getParameter('guest') === 'student') {
		new Viewer('Stu_score');
	} 
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('GET', 'Stu_record.php', function() {
	if (SessionManager::getParameter('guest') === 'student') {
		new Viewer('Stu_record');
	} 
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('GET', 'SourceWatch.php', function() {
	if (SessionManager::getParameter('guest') === 'student' || SessionManager::getParameter('guest') === 'faculty') {
		new Viewer('SourceWatch');
	}
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('GET', 'Stu_problems.php', function() {
	if (SessionManager::getParameter('guest') === 'student') {
		new Viewer('Stu_problems');
	} 
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('GET', 'Stu_problem.php', function() {
	
	if (SessionManager::getParameter('guest') === 'student') {
	
		// Set session variables of item and subitem
		SessionManager::setParameter('item', $_GET['item']);
		SessionManager::setParameter('subitem', $_GET['subitem']);

		$registry = array();
		$registry['guest'] = SessionManager::getParameter('guest');
		$registry['account'] = SessionManager::getParameter('account');
		$registry['destination'] = 'Stu_problem';
		$registry['time'] = date('Y-m-d H:i:s');
		$registry['item'] = SessionManager::getParameter('item');

		$watchman = new Janitor($registry);
		
		if ($watchman->openDoor()) {
			$info = array (
				'stu_account' => SessionManager::getParameter('account'),
				'item' => SessionManager::getParameter('item'),
				'subitem' => SessionManager::getParameter('subitem')
			);
			new Viewer('Stu_problem', $info);
		}
		else {
			new Viewer('Msg', $watchman->dialogue());
		}

	} 
	else {
		new Viewer('Sneaker');
		exit();
	}

});

$router->match('GET', 'Stu_mail.php', function() {
	if (SessionManager::getParameter('guest') === 'student') {
		SessionManager::setParameter('key_to_apply', true);
		new Viewer('Stu_mail');
	} 
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('GET', 'JudgeAdapter.php', function() {
	if (SessionManager::getParameter('guest') === 'student') { 
		new controllers\JudgeAdapter();
	} 
	else {
		new Viewer('Sneaker');
		exit();
	}
});

$router->match('POST', 'Handin.php', function() {
	
	if (SessionManager::getParameter('guest') === 'student') {
	
		$data = file_get_contents('php://input'); 
		$obj = json_decode($data); 
		
		// Configure registry array
		$registry = array();
		$registry['guest'] = SessionManager::getParameter('guest');
		$registry['account'] = SessionManager::getParameter('account');
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

	} 
	else {
		new Viewer('Sneaker');
		exit();
	}
	
});

$router->run();

?>
