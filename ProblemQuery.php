<?php

class ProblemQuery implements IStrategy {

	private $item;
	private $num_subitem;
	private $status = 'OK';

	private $hookup;

	public function algorithm() {
	
		// Get item
		$this->item = $_POST['item'];
		
		try {
			$this->hookup = UniversalConnect::doConnect();
			
			$stmt_num = $this->hookup->prepare('SELECT number FROM problem WHERE item=\'' . $this->item . '\'');
			$stmt_num->execute();
			$row_num = $stmt_num->fetch(PDO::FETCH_ASSOC);
			$this->num_subitem = $row_num['number'];
			
			for ($i = 1; $i <= $this->num_subitem; $i += 1) {
				$stmt_modi = $this->hookup->prepare('SELECT modified_source FROM ' . $this->item . '_' . $i);
				$stmt_modi->execute();
				if (!$stmt_modi->fetch()) {
					$this->status = 'YET';
					echo $this->status;
					return;
				}
			}
				
			$this->hookup = null;
		}
		catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage() . '<br>';
		}
	
		echo $this->status;
		return;
	}

}

?>

