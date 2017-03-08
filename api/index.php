<?php
session_start();

require_once 'config/connection.php';
require_once 'models/Route.php';

$App = new Route;

if(isset($_GET['action'])) {

	$action = $_GET['action'];

	switch($_GET['action']) {
		case 'jobsearch':
			$App->Search($_GET['job'], $_GET['location'], $_GET['minsal']);
			break;

		case 'locations':
			$App->Locations($_GET['location']);
			break;

		case 'userdata':
			$App->UserData();
			break;

		default:
			echo "Test";
			break;
	}

} else {
	$action = "error";
	$App->Get($action);
}

?>