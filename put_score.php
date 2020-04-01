<?php
include "incl/connection.php";
include "incl/mainLib.php";

MainLib::updateLeaderboardsFromPostData($db);

echo 1;