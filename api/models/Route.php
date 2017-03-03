<?php

class Route {

	public static function All() {
		require_once "controllers/job_controller.php";
		Job::All();
	}

	public static function Search($job, $location, $minsal) {
		require_once 'controllers/job_controller.php';
		Job::Search($job, $location, $minsal);
	}

	public static function Locations() {
		require_once 'controllers/location_controller.php';
		Location::All();
	}

}

?>