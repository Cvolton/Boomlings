<?php
include "incl/connection.php";

$refID = $db->prepare("SELECT referral_code FROM user WHERE udid = :udid");
$refID->execute(['udid' => $_POST['udid']]);

$refID = $refID->fetch();
if(empty($refID))
	exit(-1);

if(!$refID[0]){
	do{
		//generating random 6 chars long ref id
		$data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
		$refID = substr(str_shuffle($data), 0, 6);

		$refIDDuplicates = $db->prepare("SELECT count(*) FROM user WHERE referral_code = :refID");
		$refIDDuplicates->execute([':refID' => $refID]);
	}while($refIDDuplicates->fetchColumn() > 0);
	
	$updateQuery = $db->prepare("UPDATE user SET referral_code = :refID WHERE udid = :udid");
	$updateQuery->execute(['udid' => $_POST['udid'], 'refID' => $refID]);
}else
	$refID = $refID[0];

echo $refID;