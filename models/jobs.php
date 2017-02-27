<?php

class Job {
	
	public $id;
	public $title;
	public $description;
	public $company;
	public $location;
	public $timestamp;
	public $salary;

	public function __construct($id, $title, $description, $company, $location, $timestamp, $salary) {
		$this->id = $id;
		$this->title = $title;
		$this->description = $description;
		$this->company = $company;
		$this->location = $location;
		$this->timestamp = $timestamp;
		$this->salary = $salary;
	}

	public static function all() {
		$list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM jobs ORDER BY rand() LIMIT 15');

        foreach ($req->fetchAll() as $job) {
            $list[] = new Job($job['id'], $job['title'], $job['description'], $job['company'], $job['location'], $job['timestamp'], $job['location']);
        }
        return $list;
	}

	public static function find($id) {
        $db = Db::getInstance();
        // we make sure $id is an integer
        $id = intval($id);
        $req = $db->prepare('SELECT * FROM jobs WHERE id = :id');
        // the query was prepared, now we replace :id with our actual $id value
        $req->execute(array('id' => $id));
        $job = $req->fetch();
        return new Job($job['id'], $job['title'], $job['description'], $job['company'], $job['location'], $job['timestamp'], $job['salary']);
    }

	public static function count() {
		$db = Db::getInstance();
		$req = $db->query("SELECT count(*) FROM jobs")->fetchColumn();
		echo $req;
	}

	public static function avg_salary() {
		$db = Db::getInstance();
		$req = $db->query("SELECT SUM(salary) AS TotalSalary FROM jobs;")->fetch();

		$req2 = $db->query("SELECT count(*) AS TotalJobs FROM jobs")->fetchColumn();

		$Avg = $req['TotalSalary'] / $req2;

		$Formatted_Avg = number_format($Avg);

		echo "$" . $Formatted_Avg;

	}

	public static function similar($title) {
		$db = Db::getInstance();
		$req = $db->prepare("SELECT * FROM jobs WHERE title LIKE :title");

		$req->execute(array('title' => $title));

		$Similars = $req->fetchAll();

		header("content-type: application/json");
		echo json_encode($Similars);
	}

}

?>