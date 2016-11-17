<?php

class DBOperator {
	
	public function initial() {
		$context = new Context(new RawDataEntry()                   );
		$context->algorithm();
	}		

	public function queryStudent() {
		$context = new Context(new StudentQuery());
		$context->algorithm();
	}
	
	public function queryFaculty() {
		$context = new Context(new FacultyQuery());
		$context->algorithm();
	}
	
	public function apply() {
		$context = new Context(new LeaveApply());
		$context->algorithm();
	}
	
	public function ratify() {
		$context = new Context(new LeaveRatify());
		$context->algorithm();
	}
	
	public function alter() {
		$context = new Context(new StudentAlter());
		$context->algorithm();
	}

	public function setupTime() {
		$context = new Context(new TimeSetup());
		$context->algorithm();
	}
	
	public function searchProblem() {
		$context = new Context(new ProblemQuery());
		$context->algorithm();
	}

	public function present() {
		$context = new Context(new StudentEntry());
		$context->algorithm();
	}
	
	public function upload() {
		$context = new Context(new ProblemEntry());
		$context->algorithm();
	}
	
	public function handout() {
		$context = new Context(new ProblemAlter());
		$context->algorithm();
	}

}

?>
