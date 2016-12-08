<?php 
namespace TAFree\controllers;

use TAFree\fetchers\MailFetch;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class MailUpdater {

	public function __construct() {
		
		$mailer = new MailFetch();
		echo $mailer->hasNewer();
	}

}

require_once('../routes/Dispatcher.php');

?>

