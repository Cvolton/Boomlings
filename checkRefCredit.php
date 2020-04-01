<?php
include "incl/connection.php";
include "incl/mainLib.php";

if(!isset($_POST['udid']))
	exit(-1);

$userID = MainLib::getUserIDOrDie($db, $_POST['udid']);

$newRefCount = $db->prepare("UPDATE referral SET is_claimed = 1 WHERE referrer_id = :userID AND is_claimed = 0");
$newRefCount->execute(['userID' => $userID]);
$newRefCount = $newRefCount->rowCount();
if(!$newRefCount)
	exit(-1);

$allRefCount = $db->prepare("SELECT count(*) FROM referral WHERE referrer_id = :userID");
$allRefCount->execute(['userID' => $userID]);
$allRefCount = $allRefCount->fetchColumn();

echo "{$newRefCount};{$allRefCount}";