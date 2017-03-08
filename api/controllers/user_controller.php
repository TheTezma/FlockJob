<?php

class User {

	public function Data() {
		$db = Db::getInstance();
		$req = $db->prepare("SELECT id,name,email FROM users WHERE id = :id");
		$req->execute(array(":id" => $_SESSION['user']['id']));

		$res = $req->fetch(PDO::FETCH_ASSOC);

		if(empty($_SESSION['user'])) {
			$isLoggedIn = "false";
		} else {
			$isLoggedIn = "true";
		}

		header("content-type: application/json");

		$Res = array("userdata" => $res,
					 "status" => $isLoggedIn);

		echo json_encode($Res);
	}

}

?>