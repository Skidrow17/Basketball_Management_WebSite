<?php
require_once '../connect_db.php';
require_once '../useful_functions.php';
session_start();
if (isset($_POST['game_id']) && isset($_POST['id']) && isset($_SESSION['safe_key']) && isset($_SESSION['user_id'])) {
	if($_SESSION['language'] == 'en')include ('../labels_en.php');
	else include ('../labels_gr.php');

    if (security_check($_SESSION['safe_key'], $_SESSION['user_id']) == true) {
        $id = $_POST['game_id'];
        $cat_id = $_POST['id'];
        $sql = "Select date_time from game where id=:gid";
        $run = $dbh->prepare($sql);
        $run->bindParam(':gid', $id, PDO::PARAM_INT);
        $run->execute();
        $date = 0;
        $game_start_time = 0;
        while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
            $splitTimeStamp = explode(" ", $row['date_time']);
            $date = $splitTimeStamp[0];
            $game_start_time = $splitTimeStamp[1];
        }
        $timestamp = strtotime($game_start_time) + 60 * 60 * 2;
        $game_end_time = date('H:m:s', $timestamp);
        $sql = "SELECT distinct U.id from user U,restriction R 
				WHERE U.id=R.user_id AND R.time_to>:game_start_time 
				AND R.time_from < :game_end_time AND R.date=:date";
        $run = $dbh->prepare($sql);
        $run->bindParam(':game_start_time', $game_start_time, PDO::PARAM_STR);
        $run->bindParam(':game_end_time', $game_end_time, PDO::PARAM_STR);
        $run->bindParam(':date', $date, PDO::PARAM_STR);
        $run->execute();
        $not_in = '';
        echo $not_in;
        while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
            $not_in = $row['id'] . "," . $not_in;
        }
        /////////////////////////////////////
        $sql = "SELECT distinct U.id from user U,game G,human_power HP 
				WHERE G.id = HP.game_id AND U.id = HP.user_id AND DATE(G.date_time)=:date 
				AND TIME( DATE_ADD(G.date_time, INTERVAL 2 HOUR))>=:game_start_time AND TIME(G.date_time)<=:game_end_time";
        $run = $dbh->prepare($sql);
        $run->bindParam(':game_start_time', $game_start_time, PDO::PARAM_STR);
        $run->bindParam(':game_end_time', $game_end_time, PDO::PARAM_STR);
        $run->bindParam(':date', $date, PDO::PARAM_STR);
        $run->execute();
        while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
            $not_in = $row['id'] . "," . $not_in;
            echo "<br>";
            echo $row['id'];
            echo "<br>";
        }
        ////////////////////////////////////
        $rest = substr($not_in, 0, -1);
        if (strlen($rest) != 0) $sql = "SELECT U.id , U.name,U.surname from user U,playable_categories PC 
										WHERE U.id=PC.user_id AND U.profession=2 AND PC.team_categories_id=:td 
										AND U.id not in( " . $rest . " ) ORDER BY U.rate DESC";
        else $sql = "SELECT U.id , U.name,U.surname 
					 FROM user U,playable_categories PC where U.id=PC.user_id AND U.profession=2 
					 AND PC.team_categories_id=:td AND U.id order by U.rate desc";
        $run = $dbh->prepare($sql);
        $run->bindParam(':td', $cat_id, PDO::PARAM_INT);
        $run->execute();
        echo "<option selected>";echo $selectRefere; echo"</option>";
        while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . ' ' . $row['surname'] . '</option>';
        }
    } else {
        session_destroy();
        echo 401;
    }
}
?>

