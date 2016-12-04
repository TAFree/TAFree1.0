<?php
namespace TAFree\database;

use TAFree\secrete\IConnectInfo;

require_once('../composers/Autoloader.php');

class UniversalConnect implements IConnectInfo {
	
	private static $servername = IConnectInfo::HOST;
	private static $dbname = IConnectInfo::DBNAME;
	private static $username = IConnectInfo::UNAME;
	private static $password = IConnectInfo::PW;
	private static $conn;

	public static function doConnect() {
		self::$conn = new \PDO('mysql::host=' . self::$servername . ';dbname=' . self::$dbname, self::$username, self::$password);
		self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return self::$conn;	
	}
}

?>
