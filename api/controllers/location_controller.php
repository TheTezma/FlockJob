<?php

class Location {

	public function All() {
		$db = Db::getInstance();

		$req = $db->query("SELECT * FROM towns ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

		header("content-type: application/json");
		echo json_encode($req);
	}

}

?>