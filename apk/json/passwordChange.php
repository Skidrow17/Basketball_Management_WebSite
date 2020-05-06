<?php
require_once 'connect_db.php';
require_once 'useful_functions.php';

$fetch = array();

if(isset($_GET['safe_key']) && isset($_GET['id'])){
	
	$passwordReoveryCode = filter_var($_GET['recovery_code'], FILTER_SANITIZE_STRING);
	$hashedPassword =  password_hash($_GET['password'], PASSWORD_DEFAULT);
	$userId = -1;
	$nullPasswordRecoveryUrl = "";
	
	$sql = "SELECT id FROM user WHERE password_recovery_url=:pru";
	$run = $dbh->prepare($sql);
	$run->bindParam(':pru', $passwordReoveryCode, PDO::PARAM_STR);
	$run->execute();
	while ($row = $run->fetch(PDO::FETCH_ASSOC)) {
		$userId = $row["id"];
	}
	
	if($userId != -1){
		$sql = "UPDATE user SET password = ?,password_recovery_url=? where id = ?";
		$run = $dbh->prepare($sql);
		$run->execute([$hashedPassword,$nullPasswordRecoveryUrl,$userId]);
		$fetch['ERROR']['error_code'] = "200";
	}else{
		$fetch['ERROR']['error_code'] = "406";
	}

}else{
	$fetch['ERROR']['error_code'] = "403";
}

echo json_encode($fetch);