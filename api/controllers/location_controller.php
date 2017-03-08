<?php

class Location {

	public function All($location) {
		$db = Db::getInstance();

		$req = $db->query("SELECT * FROM towns ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

		if(empty($location)) {
			$arr = array("locations" => $req);
		} else {
			$req2 = $db->query("SELECT location FROM jobs WHERE location_id = '$location' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
			$arr = array("searchLocation" => $req2['location'],
						 "locations" => $req);
		}

		header("content-type: application/json");
		echo json_encode($arr);
	}

}

?>