<?php

class MessageQuery implements IStrategy {

	private $content;
	
	private $hookup;

	public function algorithm() {
			
		try {
			$this->hookup = UniversalConnect::doConnect();
			$stmt = $this->hookup->prepare('SELECT * FROM discussion WHERE timestamp < ' . '\'' . date('Y-m-d H:m:s') . '\'');
			$stmt->execute();
			$this->content = '';
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$this->content .= '<img class=\'DISCUSSION_SUBJECT_IMG\' src=\'./tafree-svg/' . strtolower($row['subject']) . '.svg\'><pre class=\'DISCUSSION_MSG_PRE\'>' . $row['message'] . '</pre><br>';
			}
			
			$this->hookup = null;
	
			echo $this->content;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
	
	}

}

?>

