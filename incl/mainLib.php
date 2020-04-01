<?php
class MainLib {
	public static function getUserIDOrDie($db, $udid){
		$userID = $db->prepare("SELECT id FROM user WHERE udid = :udid");
		$userID->execute(['udid' => $udid]);
		$userID = $userID->fetchColumn();
		if(!$userID)
			exit(-1);

		return $userID;
	}

	public static function printLeaderboardsFromUserArray($userArray, $activeUdid = 0){
		foreach($userArray as $user){
			$printableUdid = ($activeUdid == $user['udid']) ? $activeUdid : '0';
			echo "{$user['name']};{$printableUdid};{$user['score']};{$user['context']} ";
		}
	}

	public static function updateLeaderboardsFromPostData($db){
		if(!isset($_POST['score']) || !isset($_POST['context']) || !isset($_POST['name']) || !isset($_POST['udid']))
			exit(-1);

		$updateQuery = $db->prepare("INSERT INTO user (score, context, udid, name) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE score = IF(VALUES(score) > score, VALUES(score), score), context = VALUES(context), name = VALUES(name)");
		$updateQuery->execute([$_POST['score'], $_POST['context'], $_POST['udid'], $_POST['name']]);
	}
}