<?php
include "./database.php";
	$sql = "SELECT * FROM table_the_iot_projects ";
    $data = Database::Query($sql);
    var_dump($data);
	