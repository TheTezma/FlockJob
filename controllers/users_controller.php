<?php

class UsersController {

	public function login() {
		$User = new User;
		$User::login();
	}

	public function register() {
		$User = new User;
		$User::register();
	}

	public function logout() {
		$User = new User;
		$User::logout();
	}

}
?>