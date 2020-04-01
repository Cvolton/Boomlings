<?php
include "incl/connection.php";
include "incl/mainLib.php";

MainLib::updateLeaderboardsFromPostData($db);

$users = $db->prepare("SELECT	A.* FROM	(
			(
				SELECT	*	FROM user
				WHERE score <= ?
				AND is_banned = 0
				ORDER BY score DESC
				LIMIT 50
			)
			UNION
			(
				SELECT * FROM user
				WHERE score >= ?
				AND is_banned = 0
				ORDER BY score ASC
				LIMIT 50
			)
		) as A
		ORDER BY A.score DESC");
$users->execute([$_POST['score'],$_POST['score']]);
$users = $users->fetchAll();

$rank = $db->prepare("SELECT count(*) FROM user WHERE score > :score");
$rank->execute(['score' => $users[0]['score']]);
echo "{$rank->fetchColumn()}__ ";

MainLib::printLeaderboardsFromUserArray($users, $_POST['udid']);