<?php
	session_start();
	if(!isset($_POST['submit'])){
		echo "Something wrong! Check again!";
		exit;
	}
	require_once "./controllers/database_functions.php";
	$conn = db_connect();

	$name = trim($_POST['name']);
	$pass = trim($_POST['pass']);

	if($name == "" || $pass == ""){
		echo "Name or Pass is empty!";
		exit;
	}

	$name = $name;
	$pass = $pass;
	$pass = sha1($pass);

	// get from db
	$query = "SELECT name, pass from admin";
    $cmd = $conn->prepare($query);
    $cmd->execute();
    $result = $cmd->fetch();
	if(!$result){
		echo "Empty data ";
		exit;
	}

	if($name != $result['name'] && $pass != $result['pass']){
		echo "Name or pass is wrong. Check again!";
		$_SESSION['admin'] = false;
		exit;
	}
	$_SESSION['admin'] = true;
	header("Location: admin_book.php");
?>