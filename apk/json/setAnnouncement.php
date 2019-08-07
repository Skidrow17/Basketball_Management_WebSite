<?php

require_once 'connect_db.php';
require 'useful_functions.php';
$fetch = array();

if (security_check($_GET['safe_key'], $_GET['user_id']) == true) {
	$user_id = filter_var($_GET["user_id"], FILTER_SANITIZE_NUMBER_INT);
	$title = filter_var($_GET["title"], FILTER_SANITIZE_STRING);
	$text = filter_var($_GET["text"], FILTER_SANITIZE_STRING);

	$sql = "INSERT INTO `announcement`(`user_id`, `title`, `text`) VALUES (:user_id,:title,:text)";
	$run = $dbh->prepare($sql);
	$run->bindParam(':user_id', $user_id, PDO::PARAM_INT);
	$run->bindParam(':title', $title, PDO::PARAM_STR);
	$run->bindParam(':text', $text, PDO::PARAM_STR);
	$run->execute();

	if ($run->rowCount() > 0) {
		$fetch['ERROR']['error_code'] = "200";
	} else {
		$fetch['ERROR']['error_code'] = "201";
	}
	echo json_encode($fetch);
} else {
	$fetch['ERROR']['error_code'] = "403";
	echo json_encode($fetch);
}
