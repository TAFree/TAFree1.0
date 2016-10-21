<?php

include_once('IConnectInfo.php');

class UniversalConnect implements IConnectInfo {
	private static $servername = IConnectInfo::HOST;
	private static $dbname = IConnectInfo::DBNAME;
	private static $username = IConnectInfo::UNAME;
	private static $password = IConnectInfo::PW;
	private static $conn;

	public function doConnect() {
		try {
			self::$conn = new PDO('mysql::host=' . self::$servername . ';dbname=' . self::$dbname, self::$username, self::$password);
			self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return self::$conn;
		}
		catch(PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
	
		}				
	}
}

?>
