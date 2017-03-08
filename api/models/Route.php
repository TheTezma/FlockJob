<?php

class Route {

	public function All() {
		require_once "controllers/job_controller.php";
		$Job = new Job;
		$Job->All();
	}

	public function Search($job, $location, $minsal) {
		require_once 'controllers/job_controller.php';
		$Job = new Job;
		$Job->Search($job, $location, $minsal);
	}

	public function Locations($location) {
		require_once 'controllers/location_controller.php';
		$Location = new Location;
		$Location->All($location);
	}

	public function UserData() {
		require_once 'controllers/user_controller.php';
		$User = new User;
		$User->Data();
	}

}

?>