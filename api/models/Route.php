<?php

class Route {

	public static function Get($action, $class, $func) {
		require_once 'controllers/' . $action . "_controller.php";
		$class::$func();
	}

}

?>