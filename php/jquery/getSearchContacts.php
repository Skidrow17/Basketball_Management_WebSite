<?php

//Access: Authorized User & Admin
//Purpose: ability to search contacts 

session_start();
require_once '../connect_db.php';
require_once '../useful_functions.php';

if (isset($_SESSION['safe_key']) && isset($_SESSION['user_id'])) {
    if (security_check($_SESSION['safe_key'], $_SESSION['user_id']) == true) {
		$stmt = $dbh->prepare("SELECT * FROM `user` WHERE CONCAT(name,' ',surname) like :searchVal AND active = 0 AND id!=:user_id");
		$val = $_POST['search'];
		$stmt->bindParam(':searchVal', $val, PDO::PARAM_STR);
		$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
		$stmt->execute();
		$Count = $stmt->rowCount(); 
		$result = "";
		if ($Count > 0) {
			while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$result = $result . '<button class="search-result" id="srch_button" width="100%" value="' . $data['id'] . '" type="button" class="search-result">' . $data['name'] . ' ' . $data['surname'] . '</button>';
			}
		} else {
			$result = $result . '<div value="-1" type="button" class="search-result">Προσπάθησε Ξανά</div>';
		}
		echo $result;
	} else {
		session_destroy();
	}
}