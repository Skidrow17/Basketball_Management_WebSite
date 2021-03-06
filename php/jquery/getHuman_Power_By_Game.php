<?php

//Access: Admin
//Purpose: Displays all people involved in a match with the ability to remove them 

session_start();
require_once '../connect_db.php';
require_once '../useful_functions.php';
require_once '../language.php';

if (isset($_POST['game_id']) && isset($_SESSION['safe_key']) && isset($_SESSION['user_id'])) {
    if (security_check($_SESSION['safe_key'], $_SESSION['user_id']) == true) {
        $gid = $_POST['game_id'];
        echo '<tr>
			  <th>';echo $name; echo'</th>
			  <th>';echo $surname; echo'</th>
			  <th>';echo $profession; echo'</th>
			  <th></th>';
        $page = $_POST['current_page'] * 3;
        $sql = "SELECT U.id ,U.name ,U.surname,uc.name as prof from user U,human_power hp,user_categories uc 
				WHERE U.id=hp.user_id  AND hp.game_id=:gid AND uc.id=U.profession 
				ORDER BY U.profession ASC LIMIT :page,3";
        $run = $dbh->prepare($sql);
        $run->bindParam(':gid', $gid, PDO::PARAM_INT);
        $run->bindParam(':page', $page, PDO::PARAM_INT);
        $run->execute();
        while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>
					<td>' . $row['name'] . '</td>
					<td>' . $row['surname'] . '</td>
					<td>' . $row['prof'] . '</td>
					<td><button value=' . $row['id'] . ' id="delete_btn" type="button" name="delete_btn" class="btn"><i class="fa fa-trash"></i></button></td>
				 </tr>';
        }
    } else {
        session_destroy();
		header('HTTP/1.0 401 Unauthorized');
        echo 'HTTP/1.0 401 Unauthorized';
		die();
    }
}
?>

