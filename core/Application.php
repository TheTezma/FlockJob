<?php

class Application {

	public function Route() {

		if (isset($_GET['controller']) && isset($_GET['action'])) {
		  $controller = $_GET['controller'];
		  $action     = $_GET['action'];
		} else {
		  $controller = 'pages';
		  $action     = 'home';
		}

		require_once 'views/layout.php';

	}

	public function Redirect($url) {
		die("<script>location.href = '$url'</script>");
	}

}

?>