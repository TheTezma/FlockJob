<?php
class Job
{
    public function All()
    {
        $db  = Db::getInstance();
        $req = $db->prepare("SELECT * FROM jobs ORDER BY rand() LIMIT 15");
        $req->execute();
        $req2          = $db->query("SELECT count(*) AS Total FROM jobs")->fetchColumn();
        $req3          = $db->query("SELECT SUM(salary) AS TotalSalary FROM jobs;")->fetch();
        $res           = $req->fetchAll(PDO::FETCH_ASSOC);
        $Avg           = $req3['TotalSalary'] / $req2;
        $Formatted_Avg = number_format($Avg);
        $FinalFormat   = "$" . $Formatted_Avg;
        $JobObj        = array(
            "count" => $req2,
            "avgSalary" => $FinalFormat,
            "jobs" => $res
        );
        header("content-type: application/json");
        echo json_encode($JobObj);
    }

    public function Search($job, $location, $minsal)
    {
        $db = Db::getInstance();
        if (empty($job)) {
            if (empty($location)) {
                $query   = "SELECT id, title, description, company, location, location_id, salary, timestamp FROM jobs WHERE salary >= :minsal LIMIT 15";
                $execArr = array(
                    ":minsal" => $minsal
                );
                $query2  = "SELECT count(*) AS Total FROM jobs WHERE salary >= '$minsal'";
                $query3  = "SELECT SUM(salary) AS TotalSalary FROM jobs WHERE salary >= '$minsal'";
            } else {
                $query   = "SELECT id, title, description, company, location, location_id, salary, timestamp FROM jobs WHERE location_id = :location AND salary >= :minsal LIMIT 15";
                $execArr = array(
                    ":location" => $location,
                    ":minsal" => $minsal
                );
                $query2  = "SELECT count(*) AS Total FROM jobs WHERE location_id = '$location' AND salary >= '$minsal'";
                $query3  = "SELECT SUM(salary) AS TotalSalary FROM jobs WHERE location_id = '$location' AND salary >= '$minsal'";
            }

            $req = $db->prepare($query);
            $req->execute($execArr);
            $res           = $req->fetchAll(PDO::FETCH_ASSOC);
            $req2          = $db->query($query2)->fetchColumn();
            $req3          = $db->query($query3)->fetch();
            $Avg           = $req3['TotalSalary'] / $req2;
            $Formatted_Avg = number_format($Avg);
            $FinalFormat   = "$" . $Formatted_Avg;

            if ($req2 >= 2) {
                $JobsInfo = " Jobs";
            } else {
                $JobsInfo = " Job";
            }

            if ($req2 == 0) {
                $JobObj = array(
                    "topinfo" => $req2 . $JobsInfo . " In Australia with a minimum salary of $",
                    "count" => $req2,
                    "avgSalary" => "0",
                    "error" => $req2 . $JobsInfo . " matching your search criteria!"
                );
            } else {
                $JobObj = array(
                    "topinfo" => $req2 . $JobsInfo . " in Australia with a minimum salary of $",
                    "count" => $req2,
                    "avgSalary" => $FinalFormat,
                    "jobs" => $res
                );
            }

            header("content-type: application/json");
            echo json_encode($JobObj);
        } else {

            if (empty($location)) {
                $query   = "SELECT id, title, description, company, location, location_id, salary, timestamp FROM jobs WHERE title LIKE :title AND salary >= :minsal LIMIT 15";
                $execArr = array(
                    ":title" => "%" . $job . "%",
                    ":minsal" => $minsal
                );
                $query2  = "SELECT count(*) AS Total FROM jobs WHERE title LIKE '%" . $job . "%' AND salary >= '$minsal'";
                $query3  = "SELECT SUM(salary) AS TotalSalary FROM jobs WHERE title LIKE '%" . $job . "%' AND salary >= '$minsal'";
            } else {
                $query   = "SELECT id, title, description, company, location, location_id, salary, timestamp FROM jobs WHERE title LIKE :title AND location_id = :location AND salary >= :minsal LIMIT 15";
                $execArr = array(
                    ":title" => "%" . $job . "%",
                    ":location" => $location,
                    ":minsal" => $minsal
                );
                $query2  = "SELECT count(*) AS Total FROM jobs WHERE title LIKE '%" . $job . "%' AND location_id = '$location' AND salary >= '$minsal'";
                $query3  = "SELECT SUM(salary) AS TotalSalary FROM jobs WHERE '%" . $job . "%' AND location_id = '$location' AND salary >= '$minsal'";
            }

            $req = $db->prepare($query);
            $req->execute($execArr);
            $res           = $req->fetchAll(PDO::FETCH_ASSOC);
            $req2          = $db->query($query2)->fetchColumn();
            $req3          = $db->query($query3)->fetch();
            $Avg           = $req3['TotalSalary'] / $req2;
            $Formatted_Avg = number_format($Avg);
            $FinalFormat   = "$" . $Formatted_Avg;

            if ($req2 >= 2) {
                $JobsInfo = " Jobs";
            } else {
                $JobsInfo = " Job";
            }

            if ($req2 == 0) {
                $JobObj = array(
                    "topinfo" => $req2 . $JobsInfo . " In Australia with a minimum salary of $",
                    "count" => $req2,
                    "avgSalary" => "0",
                    "error" => $req2 . $JobsInfo . " matching your search criteria!"
                );
            } else {
                $JobObj = array(
                    "topinfo" => $req2 . $JobsInfo . " in Australia with a minimum salary of $",
                    "count" => $req2,
                    "avgSalary" => $FinalFormat,
                    "jobs" => $res
                );
            }

            header("content-type: application/json");
            echo json_encode($JobObj);
        }
    }
}
?>