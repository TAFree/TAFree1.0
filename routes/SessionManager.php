<?php
namespace TAFree\routes;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class SessionManager {
	
	private static $sessions;

	const INIT = 'init';
	const UNINIT = 'uninit';

	private static $session_state;

	public static function init() {

		if (self::existSession()) {
			self::destroyAll();
		}

		session_start();

		$_SESSION['guest'] = null;
		$_SESSION['nickname'] = null;
		$_SESSION['account'] = null;
		$_SESSION['item'] = null;
		$_SESSION['subitem'] = null;

		self::$sessions = $_SESSION;

		self::$session_state = self::INIT;

	}

	public static function existSession() {
		return isset($_SESSION);
	}

	public static function setParameter($key, $value) {
		if (!self::hasParameter($key)) {
			return false;
		}	
		self::$sessions[$key] = $value;
	}
	
	public static function getParameter($key) {
		if (self::hasParameter($key)) {
			return self::$sessions[$key];
		}
		return false;
	}
	
	public static function hasParameter($key) {
		if (self::$session_state === self::INIT && array_key_exists($key, self::$sessions)) {
			return true;
		}
		return false;
	}		

	public static function destroyAll() {
	
		session_unset();
		session_destroy();
		
		self::$session_state = self::UNINIT;
	
	}

}

?>
