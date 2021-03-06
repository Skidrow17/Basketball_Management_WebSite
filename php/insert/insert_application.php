<?php

//Access: Admin
//Purpose: upload apk on the server

session_start();
require_once '../connect_db.php';
require_once '../useful_functions.php';
require_once '../language.php';

if (isset($_POST['version']) && isset($_SESSION['safe_key']) && isset($_SESSION['user_id'])) {
    if (security_check($_SESSION['safe_key'], $_SESSION['user_id']) == true && $_SESSION['profession'] === 'Admin') {
        $version = filter_var($_POST['version'], FILTER_SANITIZE_STRING);
        $apk_file = $_FILES['apk_file']['name'];
        $target_dir = "../../apk/";
        $target_file = $target_dir . "Ekasdym.apk";
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($imageFileType != "apk") {
            $_SESSION['server_response'] = $please_only_apk_files ;
            header('Location: ../../add_general_info.php?id=5');
            die();
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            echo $file_not_uploaded;
        } else {
            if (move_uploaded_file($_FILES["apk_file"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["apk_file"]["name"]) . " has been uploaded.";
            } else {
                echo $file_not_uploaded;
            }
        }
        $apk_name = "Ekasdym.apk";
        $sql = "INSERT INTO `apk_version`(`apk_name`,`version_number`) VALUES (:apk_name, :version)";
        $run = $dbh->prepare($sql);
        $run->bindParam(':apk_name',$apk_name,PDO::PARAM_STR);
        $run->bindParam(':version',$version,PDO::PARAM_STR);
        $run->execute();
        if ($run->rowCount() > 0) {
            $_SESSION['server_response'] = $success;
            header('Location: ../../add_general_info.php?id=5');
            die();
        } else {
            $_SESSION['server_response'] = $fail;
            header('Location: ../../add_general_info.php?id=5');
            die();
        }
    } else {
        session_destroy();
        $_SESSION['server_response'] = $loggedInFromAnotherDevice;
        header('Location: ../../index.php');
        die();
    }
}