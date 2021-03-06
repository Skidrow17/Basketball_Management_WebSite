<?php

//Access: Admin
//Purpose: rejects the restrictions addded from user

session_start();
require_once '../connect_db.php';
require_once '../useful_functions.php';
require_once '../language.php';

if (isset($_POST['id']) && isset($_SESSION['safe_key']) && isset($_SESSION['user_id'])){
    if (security_check($_SESSION['safe_key'], $_SESSION['user_id']) == true && $_SESSION['profession'] === 'Admin') {
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $user_id = - 1;
        $time_from = "";
        $time_to = "";
        $date = "";
        $sql = 'select * from restriction where id = :id';
        $run = $dbh->prepare($sql);
        $run->bindValue(':id', $id);
        $run->execute();
        while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
            $user_id = $row['user_id'];
            $time_from = $row['time_from'];
            $time_to = $row['time_to'];
            $date = $row['date'];
        }
        $sql = 'DELETE FROM restriction WHERE id = :id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo $deleteSuccessful;
        } else {
            echo $deleteUnsuccessful;
        }
		
        $message_sent =  $restrictionDeleted." : ". $date . '  ' . $time_from . ' - ' . $time_to;
        $sender_id = $_SESSION['user_id'];
        $receiver_id = $user_id;

        $sql = "INSERT INTO `message`(`sender_id`, `receiver_id`, `text_message`) VALUES (:sender_id, :receiver_id, :text_message)";
        $run = $dbh->prepare($sql);

        $run->bindParam(':sender_id',$sender_id,PDO::PARAM_INT);
        $run->bindParam(':receiver_id',$receiver_id,PDO::PARAM_INT);
        $run->bindParam(':text_message',$message_sent,PDO::PARAM_STR);
        $run->execute();

        $sql = "SELECT id,name,surname,mobile_token FROM user WHERE id IN (:receiver_id, :sender_id)";
        $result = $dbh->prepare($sql);
        $result->bindParam(':receiver_id', $user_id, PDO::PARAM_INT);
        $result->bindParam(':sender_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $result->execute();
        $sender_name = "";
        $receiver_token = "";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            if($row["id"] == $_SESSION['user_id']){
                $sender_name = $row["name"]." ".$row["surname"]."/".$row["id"];
            }else{
                $receiver_token = $row["mobile_token"];
            }
        }

        sentPushNotification($sender_name,$receiver_token,$message_sent);


    } else {
        session_destroy();
        header('HTTP/1.0 401 Unauthorized');
        echo 'HTTP/1.0 401 Unauthorized';
		die();
    }
}