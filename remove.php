<?php
	session_start();
		
	ini_set('display_errors', true);
	error_reporting(E_ALL ^ E_NOTICE);
	
	if(!isset($_SESSION['logged']) || $_SESSION['logged'] != 1) 
	{
		header("Location: login.php?not_logged=1");
	}
	$host='localhost';
	$user='root';
	$pass='';
	$dbname='eshop';
	$db = mysqli_connect($host, $user, $pass, $dbname);
	if(mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		die("Failed");
	}

	$username = $_SESSION['username'];
	$query = 'SELECT * FROM user WHERE username = "'.mysqli_real_escape_string($db, $username).'";';
	$result = mysqli_query($db, $query);
	if(mysqli_num_rows($result) == 0) 
	{
		session_destroy();
		header("Location: login.php");
	}
	$row = mysqli_fetch_array($result);
	extract($row);
	mysqli_free_result($result);
	
	if(isset($_GET['id'])) 
	{
	$id = $_GET['id'];
	$query = "delete from cart where  uid=".mysqli_real_escape_string($db,$_SESSION['id'] ).' and cart.itemid = '.mysqli_real_escape_string($db, $id).';';
	mysqli_query($db, $query);
	}
	
	header("Location: checkOut.php");


?>
