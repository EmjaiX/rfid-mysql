<?php
$UIDresult = $_POST["UIDresult"];
$Write = "<?php $" . "UIDresult='" . $UIDresult . "'; " . "echo $" . "UIDresult;" . " ?>";
file_put_contents('UIDContainer.php', $Write);

include "database.php";

$isMarchant = true;
$tableName = "merhcants";
$checkTypeName = "flag";

$checkTypeSql = "SELECT scanned FROM `" . $checkTypeName . "` WHERE `id` = 1;";
$merchantScanned = Database::Query($checkTypeSql);

//Check whether Merchant or Customer has scanned card
if (!$merchantScanned) {
	if (verifyMerchant($_POST["UIDresult"])) {
		$sql = "UPDATE `" . $tableName . "` SET `name` = '" . $_POST["UIDresult"] . "' , `scanned` = 1 WHERE `id` = 1;";
	} else {
		$sql = "UPDATE `" . $tableName . "` SET `rfid` = '0000' WHERE `id` = 1;";
	}
} else {
	$sql = "SELECT * FROM `" . $tableName . "` WHERE `id` = '" . $_POST["UIDresult"] . ";";
}


function verifyMerchant($id)
{
	return Database::ValueExist("merchants", $id);
}

function verifyClient()
{
}
