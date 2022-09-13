<?php
include "./database.php";
$sql = "SELECT * FROM flag where scanned = 1 and store_id = " . $_GET["store"];
$data = Database::Query($sql);
$res = (object) array('id1' => $data[0]["rfid"], 'id2' => $data[1]["rfid"]);

echo (json_encode($res));
