<?php
namespace TAFree\utils;

ini_set('display_errors', '1');
ERROR_REPORTING(E_ALL);

use TAFree\classes\Context;
use TAFree\models as models;

require_once('../composers/Autoloader.php');

class DBOperator {
	
	public function initial() {
		$context = new Context(new models\RawDataEntry());
		$context->algorithm();
	}		

	public function queryStudent() {
		$context = new Context(new models\StudentQuery());
		$context->algorithm();
	}
	
	public function queryFaculty() {
		$context = new Context(new models\FacultyQuery());
		$context->algorithm();
	}
	
	public function apply() {
		$context = new Context(new models\LeaveApply());
		$context->algorithm();
	}
	
	public function ratify() {
		$context = new Context(new models\LeaveRatify());
		$context->algorithm();
	}
	
	public function alter() {
		$context = new Context(new models\StudentAlter());
		$context->algorithm();
	}

	public function setupTime() {
		$context = new Context(new models\TimeSetup());
		$context->algorithm();
	}
	
	public function present() {
		$context = new Context(new models\StudentEntry());
		$context->algorithm();
	}

	public function assignRegistry($unique_key, $item) {
		$context = new Context(new models\ProblemLock($unique_key, $item));
		$context->algorithm();
	}
	
	public function increase() {
		$context = new Context(new models\ProblemIncrease());
		$context->algorithm();
	}
	
	public function reduce() {
		$context = new Context(new models\ProblemReduce());
		$context->algorithm();
	}

	public function upload() {
		$context = new Context(new models\ProblemEntry());
		$context->algorithm();
	}
	
	public function handout() {
		$context = new Context(new models\ProblemAlter());
		$context->algorithm();
	}
	
	public function colorProblem($item, $item_status) {
		$context = new Context(new models\ProblemColoring($item, $item_status));
		$context->algorithm();
	}

	public function handin() {
		$context = new Context(new models\AnswerEntry());
		$context->algorithm();
	}
	
	public function expand() {
		$context = new Context(new models\JudgeExpansion());
		$context->algorithm();
	}

	public function rejudge() {
		$context = new Context(new models\ProblemRejudge());
		$context->algorithm();
	}
	
	public function plagiarism() {
		$context = new Context(new models\SourcePlagiarism());
		$context->algorithm();
	}

}

?>
