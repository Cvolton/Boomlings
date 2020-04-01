<?php
include "incl/connection.php";
include "incl/mainLib.php";

$canClaim = 1;
$today = date("yy-m-d");

$userID = MainLib::getUserIDOrDie($db, $_POST['udid']);

$query = $db->prepare("SELECT date FROM reward WHERE user_id = :userid ORDER BY date DESC");
$query->execute(["userid" => $userID]);
$dateArray = $query->fetchAll();


if(!empty($dateArray) && $dateArray[0][0] == $today)
	$canClaim = 0;
else
	array_unshift($dateArray, [$today]);

$consecutiveDays = 0;
do
{
	$lastDate = $dateArray[0][0];
	array_shift($dateArray);
	$consecutiveDays++;
}while(!empty($dateArray) && $dateArray[0][0] == date("yy-m-d", strtotime($lastDate) - 86400));

$query = $db->prepare("INSERT INTO reward (user_id) VALUES (:userid)");
$query->execute(["userid" => $userID]);

echo "{$canClaim}_{$consecutiveDays}";