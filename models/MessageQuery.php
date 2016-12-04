<?php
namespace TAFree\models;

use TAFree\classes\IStrategy;
use TAFree\database\UniversalConnect;

require_once('../composers/Autoloader.php');

class MessageQuery implements IStrategy {

	private $content;
	private $starttime;
	private $now;
	private $hookup;

	public function algorithm() {
			
		$this->starttime = $_POST['starttime'];
		$this->now = date('Y-m-d H:i:s');

		try {
			$this->hookup = UniversalConnect::doConnect();
			$stmt = $this->hookup->prepare('SELECT * FROM discussion WHERE timestamp BETWEEN \'' . $this->starttime . '\' AND ' . '\'' . $this->now . '\'');
			$stmt->execute();
			$this->content = $this->now . '#';
			while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				$this->content .= '<img class=\'DISCUSSION_SUBJECT_IMG\' src=\'../public/tafree-svg/' . strtolower($row['subject']) . '.svg\'><pre class=\'DISCUSSION_MSG_PRE\'>' . $row['message'] . '</pre><br>';
			}
			
			$this->hookup = null;
	
			echo $this->content;
		}
		catch (\PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
	
	}

}

?>

