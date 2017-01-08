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
	if($username!="admin")
	{
		header("Location: home.php");
	}
	if(isset($_GET['id'])) 
	{
		$id = $_GET['id'];
		$query = "delete from items where itemid = ".mysqli_real_escape_string($db, $id).';';
		mysqli_query($db, $query);
	}
	
	header("Location: adproduct.php")


?>
