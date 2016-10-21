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

?>
