<?php

//Access: Authorized User & Admin
//Purpose: retrieves the number of total announcemets 

session_start();
require_once '../connect_db.php';
require_once '../useful_functions.php';

if (isset($_SESSION['safe_key']) && isset($_SESSION['user_id'])) {
    if (security_check($_SESSION['safe_key'], $_SESSION['user_id']) == true) {
        $sql = "Select count(*) as n_o_a from announcement";
        $run = $dbh->prepare($sql);
        $run->execute();
        while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
            echo $row['n_o_a'];
        }
    } else {
        session_destroy();
		header('HTTP/1.0 401 Unauthorized');
        echo 'HTTP/1.0 401 Unauthorized';
		die();
    }
}
?>

