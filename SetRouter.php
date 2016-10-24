<?php

include_once('Router.php');
include_once('Viewer.php');

$router = new Router();

$router->match('GET', '/', function () {
	new Viewer('Login');
});

$router->match('GET', '/Login.php', function () {
	new Viewer('Login');
});

$router->match('GET', '/About.php', function () {
	new Viewer('About');
});

$router->match('GET', '/Hack.php', function () {
	new Viewer('Hack');
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

$router->match('GET', '/Fac_prob.php', function() {
	new Viewer('Fac_prob');
});
/*
$router->match('GET', '/Fac_prob.php', function() {
	new Viewer('Sneaker');
});*/

$router->match('GET', '/Fac_stu.php', function() {
	new Viewer('Fac_stu');
});
/*
$router->match('GET', '/Fac_prob.php', function() {
	new Viewer('Sneaker');
});*/

$router->match('GET', '/Fac_leave.php', function() {
	new Viewer('Fac_leave');
});
/*
$router->match('GET', '/Fac_leave.php', function() {
	new Viewer('Sneaker');
});*/

$router->match('GET', '/Fac_all.php', function() {
	new Viewer('Fac_all');
});
/*
$router->match('GET', '/Fac_all.php', function() {
	new Viewer('Sneaker');
});*/

$router->match('GET', '/Fac_add_del_stu.php', function() {
	new Viewer('Fac_add_del_stu');
});
/*
$router->match('GET', '/Fac_add_del_stu.php', function() {
	new Viewer('Sneaker');
});*/

$router->match('GET', '/Fac_mark.php', function() {
	new Viewer('Fac_mark');
});
/*
$router->match('GET', '/Fac_mark.php', function() {
	new Viewer('Sneaker');
}*/

$router->match('GET', '/Fac_assign.php', function() {
	new Viewer('Fac_assign');
});
/*
$router->match('GET', '/Fac_assign.php', function() {
	new Viewer('Sneaker');
}*/

$router->match('GET', '/Fac_keygen.php', function() {
	new Viewer('Fac_keygen');
});
/*
$router->match('GET', '/Fac_keygen.php', function() {
	new Viewer('Sneaker');
}*/

$router->match('GET', '/Fac_score.php', function() {
	new Viewer('Fac_score');
});
/*
$router->match('GET', '/Fac_score.php', function() {
	new Viewer('Sneaker');
}*/

$router->match('GET', '/Stu_score.php', function() {
	new Viewer('Stu_score');
});
/*	
$router->match('GET', '/Stu_score.php', function() {
	new Viewer('Sneaker');
}*/

$router->match('GET', '/Stu_prob.php', function() {
	new Viewer('Stu_prob');
});
/*
$router->match('GET', '/Stu_prob.php', function() {
	new Viewer('Sneaker');
}*/

$router->match('GET', '/Stu_leave.php', function() {
	new Viewer('Stu_leave');
});
/*
$router->match('GET', '/Stu_leave.php', function() {
	new Viewer('Sneaker');
}*/

?>
