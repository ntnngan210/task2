<?php
	$email = $_POST['inputEmail'];
	$pswd = $_POST['inputPasswd'];
    require "./controllers/database_functions.php";
    $conn = db_connect();


	$query = "SELECT username, password FROM admin";
$cmd = $conn->prepare($query);
$cmd->execute();
$result = $cmd->fetch();
	if(!$result){
		echo "Empty!";
		exit;
	}

	while ($row = $result){
		if($email == $row['username'] && $pswd == $row['password']){
			echo "Welcome admin! Long time no see";
			break;
		}
	}
?>