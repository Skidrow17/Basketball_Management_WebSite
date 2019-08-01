<?php
session_start();
require_once 'php/connect_db.php';
require_once 'php/useful_functions.php';
require_once 'php/select_boxes.php';
require_once('./php/language_select.php');

if (isset($_POST['game_id']) && isset($_SESSION['safe_key']) && isset($_SESSION['user_id'])) {
    if (security_check($_SESSION['safe_key'], $_SESSION['user_id']) == true) {
        $sql = "SELECT * 
				FROM game 
				WHERE id = :tid";
        $run = $dbh->prepare($sql);
        $run->bindParam(':tid', $_POST['game_id'], PDO::PARAM_INT);
        $run->execute();
        while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
            $splitTimeStamp = explode(" ", $row['date_time']);
            $date = $splitTimeStamp[0];
            $time = $splitTimeStamp[1];
            echo '
            <div class="form-row">
                <div class="col"><small class="form-text text-muted">';echo $team; echo' 1</small><select id="team1" name="team1" class="form-control" required>';
            echo getTeamById($row['team_id_1'], $_POST['category_id']);
            echo '</select></div>
                <div class="col"><small class="form-text text-muted">';echo $team; echo' 2</small><select id="team2" name="team2" class="form-control" required>';
            echo getTeamById($row['team_id_2'], $_POST['category_id']);
            echo '</select></div>
           </div>
			<div class="form-row">
				<div class="col"><small class="form-text text-muted">';echo $date; echo'</small><input name="date" value=' . $date . ' class="form-control" type="date" required></div>
				<div class="col"><small class="form-text text-muted">';echo $time; echo'</small><input name="time" class="form-control" value=' . $time . ' type="time" required></div>
			</div>
			<div class="form-row">
				<div class="col"><small class="form-text text-muted">';echo $numberOfReferees; echo'</small><input name="referee_num" class="form-control" value=' . $row['required_referees'] . ' min="0" max="2" type="number" required></div>
				<div class="col"><small class="form-text text-muted">';echo $numberOfJudges; echo'<br></small><input name="judge_num" class="form-control" value=' . $row['required_judges'] . '  min="0" max="2" type="number" required></div>
			</div>
			<div class="form-row">
			<div class="col"><small class="form-text text-muted">';echo $court; echo'</small>';
            echo getCourt($row['court_id']);
            echo '</div>
			<div
            class="col"><small class="form-text text-muted">';echo $rating; echo'</small>';
            echo getRate($row['rate']);
            echo '</div>
			</div><button class="btn btn-primary btn-block" name="submit" type="submit" style="background-color:rgb(220,64,29);">';echo $update; echo'</button></form> ';
        }
    } else {
        session_destroy();
		echo 401;
    }
}
?>

