<?php

class JobsController {

	public function show() {
		if(!isset($_GET['id']))
			return call('pages', 'error');

		$job = Job::find($_GET['id']);
		require_once 'views/jobs/show.php';
	}

	public function count() {
		Job::count();
	}

}

?>