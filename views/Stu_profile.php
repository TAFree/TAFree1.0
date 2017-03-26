<?php
namespace TAFree\views;

use TAFree\classes\Product;
use TAFree\helpers\FormatHelper;
use TAFree\routes\SessionManager;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

require_once('../composers/Autoloader.php');

class Stu_profile implements Product {	

	private $formatHelper;
	private $contentProduct;
	private $guest;
	private $account;
	private $email;

	public function getContent() {

		// Get guest, account, email
		$this->guest = SessionManager::getParameter('guest');
		$this->account = SessionManager::getParameter('account');
		$this->email = $this->account . '@ntu.edu.tw';
		
		$this->formatHelper = new FormatHelper(get_class($this));
		$this->contentProduct .= $this->formatHelper->addTop();
		$this->contentProduct .=<<<EOF
<form method='POST' action='../controllers/StudentProfile.php' enctype='multipart/form-data'>
<table id='PROFILE_TABLE'>
<tr><th colspan=2 class='TITLE_TD'>Profile</th></tr>
<tr>
<td class='TITLE_TD'>Guest</td>
<td class='CONTENT_TD'>{$this->guest}</td>
</tr>
<tr>
<td class='TITLE_TD'>Account</td>
<td class='CONTENT_TD'>{$this->account}<input type='hidden' name='account' value='{$this->account}'></td>
</tr>
<tr>
<td class='TITLE_TD'>Email</td>
<td class='CONTENT_TD'>{$this->email}</td>
</tr>
<tr>
<td class='TITLE_TD'>Password</td>
<td class='CONTENT_TD'><input class='FILL_INPUT' type='password' name='password'><input class='CLICKABLE' type='submit' value='Change'></td>
</tr>
</table>
</form>
EOF;
		$this->contentProduct .= $this->formatHelper->closeUp();		
		return $this->contentProduct;
	}	 

}

require_once('../routes/Dispatcher.php');

?>
