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

}

?>