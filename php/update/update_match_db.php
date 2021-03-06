<?php

//Access: Admin
//Purpose: updates already imported match

session_start();
require_once '../connect_db.php';
require_once '../useful_functions.php';
require_once '../language.php';

if (isset($_POST['submit'])) {
    if (security_check($_SESSION['safe_key'], $_SESSION['user_id']) == true && $_SESSION['profession'] === 'Admin') {
        $match_id = filter_var($_POST['matches'], FILTER_SANITIZE_NUMBER_INT);
        $date = filter_var($_POST['date'], FILTER_SANITIZE_STRING);
        $time = filter_var($_POST['time'], FILTER_SANITIZE_STRING);
        $team_id_1 = filter_var($_POST['team1'], FILTER_SANITIZE_NUMBER_INT);
        $team_id_2 = filter_var($_POST['team2'], FILTER_SANITIZE_NUMBER_INT);
        $court_id = filter_var($_POST['court'], FILTER_SANITIZE_NUMBER_INT);
        $referee_num = filter_var($_POST['referee_num'], FILTER_SANITIZE_NUMBER_INT);
        $judge_num = filter_var($_POST['judge_num'], FILTER_SANITIZE_NUMBER_INT);
        $rate = filter_var($_POST['rate'], FILTER_SANITIZE_NUMBER_INT);
        $combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
        $sql = "UPDATE game SET team_id_1=:team_id_1,team_id_2=:team_id_2,court_id=:court_id,date_time=:combinedDT,rate=:rate,required_referees=:referee_num,required_judges=:judge_num where id = :match_id";
        $run = $dbh->prepare($sql);
        $run->bindParam(':team_id_1', $team_id_1, PDO::PARAM_INT);
        $run->bindParam(':team_id_2', $team_id_2, PDO::PARAM_INT);
        $run->bindParam(':court_id', $court_id, PDO::PARAM_INT);
        $run->bindParam(':combinedDT', $combinedDT, PDO::PARAM_STR);
        $run->bindParam(':rate', $rate, PDO::PARAM_INT);
        $run->bindParam(':referee_num', $referee_num, PDO::PARAM_INT);
        $run->bindParam(':judge_num', $judge_num, PDO::PARAM_INT);
        $run->bindParam(':match_id', $match_id, PDO::PARAM_INT);
        $run->execute();
        if ($run->rowCount() > 0) {
            $_SESSION['server_response'] = $success;
            header('Location: ../../match_update.php');
            die();
        } else {
            $_SESSION['server_response'] = $fail;
            header('Location: ../../match_update.php');
            die();
        }
    } else {
        $_SESSION['server_response'] = $loggedInFromAnotherDevice;
        header('Location: ../../index.php');
        die();
    }
}