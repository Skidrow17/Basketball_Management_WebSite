<?php

require_once 'connect_db.php';
require_once 'useful_functions.php';
$fetch = array();

if (security_check($_GET['safe_key'], $_GET['id']) == true) {
	$sql = "SELECT A.id,A.title,A.text,A.date_time,U.name,U.surname from announcement A,user U where U.id=A.user_id order by A.date_time desc";
	$run = $dbh->prepare($sql);
	$run->execute();

	if ($run->rowCount() > 0) {
		while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
			$fetch['announcements'][] = $row;
			$fetch['ERROR']['error_code'] = "200";
		}
	} else {
		$fetch['ERROR']['error_code'] = "204";
	}

	echo json_encode($fetch);
} else {
	$fetch['ERROR']['error_code'] = "403";
	echo json_encode($fetch);
}