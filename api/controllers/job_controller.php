<?php

class Job {

	public function All() {
		$db = Db::getInstance();
		$req = $db->prepare("SELECT * FROM jobs ORDER BY rand() LIMIT 15");
		$req->execute();

		$res = $req->fetchAll(PDO::FETCH_ASSOC);

		header("content-type: application/json");
		echo json_encode($res);
	}

}

?>