<?php
namespace TAFree\secrete;

interface IConnectInfo {

	const HOST = 'localhost';
	const UNAME = 'TAFree';
	const PW = 'tafreedb';
	const DBNAME = 'TAFreeDB';

	public static function doConnect();
}

?>
