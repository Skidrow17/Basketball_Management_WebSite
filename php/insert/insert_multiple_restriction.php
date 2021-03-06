<?php

//Access: Authorized User
//Purpose: import multiple restrictions on the system

session_start();
require_once '../connect_db.php';
require_once '../useful_functions.php';
require_once '../language.php';


if (isset($_POST['submit'])) {
	
	$time_from = "00:00:00";
	$time_to = "23:59:59";
	$number_of_restrictions_inserted = 0;
	$parts = explode(", ", $_POST["dates"]);
	$timezone = date_default_timezone_get();
	$now = date('m/d/Y h:i:s a', time());
	
	$match_week = date("W", strtotime(date("Y/m/d")));
	$match_year = date("Y", strtotime(date("Y/m/d")));
	$comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);

	$sql = "SELECT COUNT(*) as nor FROM human_power HP,game G WHERE G.Id = HP.game_id AND Week(G.date_time,1) = :match_week AND Year(G.date_time) = :match_year";
	$run = $dbh->prepare($sql);
	$run->bindParam(':match_week', $match_week, PDO::PARAM_STR);
	$run->bindParam(':match_year', $match_year, PDO::PARAM_STR);
	$run->execute();
	$restrictions_closed = false;
	
	while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
	  if($row['nor'] != 0){
		  $restrictions_closed = true;
	  }
	}
	
	if($restrictions_closed){
		echo $date;
		echo $restrictions_closed;
		$_SESSION['server_response'] = $multiple_restriction_lock;
		header('Location: ../../add_restriction.php');
		die();
	}else if (security_check($_SESSION['safe_key'], $_SESSION['user_id']) == true) {
        for ($i = 0;$i < sizeof($parts);$i++) {
            $newDate = str_replace("/", "-", $parts[$i]);
            $sql = "INSERT INTO `restriction`(`user_id`, `date`, `time_from` , `time_to`,`comment` ) VALUES (:user_id,:date,:time_from,:time_to,:comment)";
            $run = $dbh->prepare($sql);
            $run->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);
            $run->bindParam(':date', $newDate, PDO::PARAM_STR);
            $run->bindParam(':time_from', $time_from, PDO::PARAM_STR);
			$run->bindParam(':time_to', $time_to, PDO::PARAM_STR);
			$run->bindParam(':comment', $comment, PDO::PARAM_STR);
            $run->execute();
            if ($run->rowCount() > 0) {
                $number_of_restrictions_inserted = $number_of_restrictions_inserted + 1;
            }
        }
        $number_of_total_restrictions = sizeof($parts) - 1;
	
        $_SESSION['server_response'] = $success;
        header('Location: ../../add_restriction.php');
		die();
    } else {
        session_destroy();
        $_SESSION['server_response'] = $loggedInFromAnotherDevice;
        header('Location: ../../index.php');
		die();
    }
}