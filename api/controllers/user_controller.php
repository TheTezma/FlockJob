<?php

class User {

	public function Data() {
		$db = Db::getInstance();
		$req = $db->prepare("SELECT id,username,email FROM users WHERE id = :id");
		$req->execute(array(":id" => $_GET['id']));

		$res = $req->fetch(PDO::FETCH_ASSOC);

		header("content-type: application/json");

		echo json_encode($res);
	}

}

?>