<?php

$res = array(
	"1" => "Err:1 - No Action Specified",
	"2" => "Err:2 - Action Not Available"
	);

header("content-type: application/json");

echo $_GET['err'];

echo json_encode($res);

?>