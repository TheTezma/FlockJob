<?php

class Salary {

	public function Average() {
		$db = Db::getInstance();
		$req = $db->query("SELECT SUM(salary) AS TotalSalary FROM jobs;")->fetch();

		$req2 = $db->query("SELECT count(*) AS TotalJobs FROM jobs")->fetchColumn();

		$Avg = $req['TotalSalary'] / $req2;

		$Formatted_Avg = number_format($Avg);

		$FinalFormat = "$" . $Formatted_Avg;

		header("content-type: application/json");
		echo json_encode($FinalFormat);

	}

}

?>