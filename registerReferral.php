<?php
include "incl/connection.php";
include "incl/mainLib.php";

if(!isset($_POST['udid']) || !isset($_POST['refID']))
	exit(-1);

$referrerID = $db->prepare("SELECT id FROM user WHERE referral_code = :refID AND udid != :udid");
$referrerID->execute([':refID' => $_POST['refID'], ':udid' => $_POST['udid']]);
$referrerID = $referrerID->fetchColumn();

$refereeID = MainLib::getUserIDOrDie($db, $_POST['udid']);

if(empty($referrerID) || empty($refereeID))
	exit(-1);

$refID = $db->prepare("INSERT INTO referral (referrer_id, referee_id) VALUES (:referrerID, :refereeID) ON DUPLICATE KEY UPDATE id = id");
$refID->execute(['referrerID' => $referrerID, 'refereeID' => $refereeID]);

echo 1;
//TODO: duplicate referees