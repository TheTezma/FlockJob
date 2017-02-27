<?php
require_once 'config/connection.php';
require_once 'Models/Route.php';

if(isset($_GET['action'])) {

	$action = $_GET['action'];

	switch($_GET['action']) {
		case 'user':
			$id = $_GET['id'];
			Route::Get($action, "User", "Data");
			break;

		case 'job':
			Route::Get($action, "Job", "All");
	}

} else {
	$action = "error";
	Route::Get($action);
}

?>