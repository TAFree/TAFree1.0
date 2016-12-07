<?php
namespace TAFree\routes;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class SessionManager {


	public static function init() {

		if (self::existSession()) {
			self::destroyAll();
		}
		
		self::start();

		$_SESSION['guest'] = '';
		$_SESSION['nickname'] = '';
		$_SESSION['account'] = '';
		$_SESSION['item'] = '';
		$_SESSION['subitem'] = '';

	}

	public static function setParameter($key, $value) {
		if (!self::existSession()) {
			self::start();
		}
		if (!self::hasParameter($key)) {
			return false;
		}	
		$_SESSION[$key] = $value;
	}
	
	public static function getParameter($key) {
		if (!self::existSession()) {
			self::start();
		}
		if (self::hasParameter($key)) {
			return $_SESSION[$key];
		}
		return false;
	}
	
	private static function existSession() {
		return isset($_SESSION);
	}
	
	private static function hasParameter($key) {
		if (isset($_SESSION[$key])) {
			return true;
		}
		return false;
	}		

	private static function destroyAll() {
	
		session_unset();
		session_destroy();
	
	}

	private static function start() {
		if (session_status() === \PHP_SESSION_NONE) {
			session_start();
		}
	}

}

?>
