<?php

require_once '../connect_db.php';
require '../useful_functions.php';
session_start();

if(isset($_POST['current_page']))
{
if(security_check($_SESSION['safe_key'],$_SESSION['user_id'])==true)
{
	
	
	$page=$_POST['current_page']*9;
	
	 echo "<tr>";
    echo "<th>Όνομα</th>";
    echo "<th>Επίθετο</th>";
    echo "<th>Απο</th>";
    echo "<th>Μέχρι</th>";
    echo "<th>Ημερομινία</th>";
    echo "<th>Ημερομινία Καταχώρισης</th>";
	echo "<th>Ώρα Καταχώρισης</th>";
    echo "</tr>";
	  
	  
	$sql="SELECT U.name,U.surname,R.time_from,R.time_to,R.date,R.register_timestamp from user U,restriction R where U.id=R.user_id ORDER BY R.register_timestamp desc limit :page,9" ;
	$run = $dbh->prepare($sql);
	$run->bindParam(':page',$page, PDO::PARAM_INT);
	$run ->execute();
	
	$run ->execute();
	while($row=$run->fetch(PDO::FETCH_ASSOC)){

   echo "<tr>";
    echo "<td>".$row['name']."</td>";
	echo "<td>".$row['surname']."</td>";
    echo "<td>".$row['time_from']."</td>";
    echo "<td>".$row['time_to']."</td>";
    echo "<td>".$row['date']."</td>";
	$splitTimeStamp = explode(" ",$row['register_timestamp']);
	$date = $splitTimeStamp[0];
	$time = $splitTimeStamp[1];
    echo "<td>".$date."</td>";
	echo "<td>".$time."</td>";
    echo "</tr>";
			
	}

	
}
else
{
	session_destroy();
}
}
else
{
	header('Location: ../../home_admin.php');
	die();
}





?>

