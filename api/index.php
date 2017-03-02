<?php
require_once 'config/connection.php';
require_once 'models/Route.php';

if(isset($_GET['action'])) {

	$action = $_GET['action'];

	switch($_GET['action']) {
		case 'jobsearch':
			Route::Search($_GET['job'], $_GET['location'], $_GET['minsal']);
			break;

		case 'alljobs':
			Route::All();
			break;

		default:
			echo "Test";
			break;
	}

} else {
	$action = "error";
	Route::Get($action);
}

?>