<?php
include "incl/connection.php";
include "incl/mainLib.php";

$users = $db->query("SELECT name,score,context,udid FROM user WHERE is_banned = '0' ORDER BY score DESC LIMIT 100")->fetchAll(PDO::FETCH_ASSOC);

MainLib::printLeaderboardsFromUserArray($users);