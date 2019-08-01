<?php
require_once '../connect_db.php';
require_once '../useful_functions.php';
session_start();

if (isset($_POST['id']) && isset($_SESSION['safe_key']) && isset($_SESSION['user_id'])) {
	if($_SESSION['language'] == 'en')include ('../labels_en.php');
	else include ('../labels_gr.php');
    if (security_check($_SESSION['safe_key'], $_SESSION['user_id']) == true) {
        $sql = "SELECT distinct
				home.name AS team_id_1, 
				away.name AS team_id_2,r.id
				FROM game AS r
				JOIN team AS home 
				ON r.team_id_1 = home.id
				JOIN team AS away 
				ON r.team_id_2 = away.id , team t where yearweek(r.date_time,1) = yearweek(curdate(),1) 
				AND r.team_id_1=t.id AND t.category=:td order by get_n_o_r_by_game(r.id) desc";
        $run = $dbh->prepare($sql);
        $run->bindParam(':td', $_POST['id'], PDO::PARAM_INT);
        $run->execute();
        echo "<option selected>";echo $selectMatch; echo"</option>";
        while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="' . $row['id'] . '">' . $row['team_id_1'] . ' - ' . $row['team_id_2'] . '</option>';
        }
    } else {
        session_destroy();
		echo 401;
    }
}
?>

