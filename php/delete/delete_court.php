<?php
session_start();
require_once '../connect_db.php';
require_once '../useful_functions.php';
require_once '../language.php';

if (isset($_POST['court_id']) && isset($_SESSION['safe_key']) && isset($_SESSION['user_id'])) {
    if (security_check($_SESSION['safe_key'], $_SESSION['user_id']) == true && $_SESSION['profession'] === 'Admin') {
        $id = filter_var($_POST['court_id'], FILTER_SANITIZE_NUMBER_INT);
        $sql = "UPDATE court SET active=1 where id = ?";
        $run = $dbh->prepare($sql);
        $run->execute([$id]);
        if ($run->rowCount() > 0) {
            if ($id !== "") echo $deleteSuccessful;
            else echo $chooseCourt;
        } else {
            echo $deleteUnsuccessful;
        }
    } else {
        session_destroy();
        echo 401;
    }
}