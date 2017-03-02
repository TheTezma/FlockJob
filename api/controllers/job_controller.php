<?php

class Job {

	public function All() {
		$db = Db::getInstance();

		$req = $db->prepare("SELECT * FROM jobs ORDER BY rand() LIMIT 15");
		$req->execute();

		$req2 = $db->query("SELECT count(*) AS Total FROM jobs")->fetchColumn();

		$req3 = $db->query("SELECT SUM(salary) AS TotalSalary FROM jobs;")->fetch();

		$res = $req->fetchAll(PDO::FETCH_ASSOC);

		$Avg = $req3['TotalSalary'] / $req2;

		$Formatted_Avg = number_format($Avg);

		$FinalFormat = "$" . $Formatted_Avg;

		$JobObj = array("count" => $req2,
						"avgSalary" => $FinalFormat,
						"jobs" => $res);

		header("content-type: application/json");
		echo json_encode($JobObj);
	}

	public function Search($job, $location, $minsal) {
		$db = Db::getInstance();

		if(empty($job)) {

			$query = "SELECT * FROM jobs WHERE location_id = :location AND salary >= :minsal LIMIT 15";
			$req = $db->prepare($query);
			$req->execute(array(":location" => $location, ":minsal" => $minsal));

			$res = $req->fetchAll(PDO::FETCH_ASSOC);

			$req2 = $db->query("SELECT count(*) AS Total FROM jobs WHERE location_id = '$location' AND salary >= '$minsal'")->fetchColumn();

			$req3 = $db->query("SELECT SUM(salary) AS TotalSalary FROM jobs WHERE location_id = '$location' AND salary >= '$minsal'")->fetch();

			$Avg = $req3['TotalSalary'] / $req2;

			$Formatted_Avg = number_format($Avg);

			$FinalFormat = "$" . $Formatted_Avg;

			if($req2 >= 2) {
				$JobsInfo = " Jobs";
			} else {
				$JobsInfo = " Job";
			}

			$JobObj = array("topinfo" => $req2 . $JobsInfo . " in Australia with a minimum salary of $",
							"count" => $req2,
							"avgSalary" => $FinalFormat,
							"jobs" => $res);

			header("content-type: application/json");
			echo json_encode($JobObj);

		} else {

			$query = "SELECT * FROM jobs WHERE title LIKE :title AND location_id = :location AND salary >= :minsal LIMIT 15";
			$req = $db->prepare($query);
			$req->execute(array(":title" => "%".$job."%", ":location" => $location, ":minsal" => $minsal));

			$res = $req->fetchAll(PDO::FETCH_ASSOC);

			$req2 = $db->query("SELECT count(*) AS Total FROM jobs WHERE title LIKE '%".$job."%' AND location_id = '$location' AND salary >= '$minsal'")->fetchColumn();

			$req3 = $db->query("SELECT SUM(salary) AS TotalSalary FROM jobs WHERE title LIKE '%".$job."%' AND location_id = '$location' AND salary >= '$minsal'")->fetch();

			$Avg = $req3['TotalSalary'] / $req2;

			$Formatted_Avg = number_format($Avg);

			$FinalFormat = "$" . $Formatted_Avg;

			if($req2 >= 2) {
				$JobsInfo = " Jobs";
			} else {
				$JobsInfo = " Job";
			}

			$JobObj = array("topinfo" => $req2 . " " . $job . $JobsInfo . " in Australia with a minimum salary of $",
							"count" => $req2,
							"avgSalary" => $FinalFormat,
							"jobs" => $res);

			header("content-type: application/json");
			echo json_encode($JobObj);

		}
	}

}

?>