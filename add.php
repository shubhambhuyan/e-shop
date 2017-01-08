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
	if(mysqli_connect_errno()) 
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		die("Failed");
	}
	
	if(isset($_GET['id'])) 
	{
		$id = $_GET['id'];
		$query = "Select * from items where itemid=".mysqli_real_escape_string($db, $id).';';
		$result = mysqli_query($db, $query);
		if(!$result) 
		{
			echo "unsuccessful";
			die();
		}
		if(mysqli_num_rows($result) == 0) 
		{
			echo "Such an item is not in our database";
			die();
		}
		$row = mysqli_fetch_assoc($result);
		$itemid=$row['itemid'];
		$qty=1;
		$price= $qty * $row['price'];
		
		$query = "Select * from cart where itemid=".mysqli_real_escape_string($db, $itemid).' and uid='.mysqli_real_escape_string($db,$_SESSION['id'] ).';';
		$result = mysqli_query($db, $query);
		if(mysqli_num_rows($result)>0) 
		{
			$query = "Select catid from items where itemid=".mysqli_real_escape_string($db, $itemid).';';
			$result = mysqli_query($db, $query);
			$row = mysqli_fetch_assoc($result);
			$category=$row['catid'];
			if($category==1)
			header("Location: home.php");
		else if($category==2)
			header("Location: cs.php");
		else if($category==3)
			header("Location: me.php");
		else if($category==4)
			header("Location: ec.php");
		else if($category==5)
			header("Location: ac.php");
		}
		$username = $_SESSION['username'];
		$query = 'SELECT * FROM user WHERE username = "'.mysqli_real_escape_string($db, $username).'";';
		$result = mysqli_query($db, $query);
		if(mysqli_num_rows($result) == 0) 
		{
			session_destroy();
			header("Location: login.php");
		}
		$row = mysqli_fetch_assoc($result);
		$uid= $row['id'];
		
		
		$query = 'INSERT INTO cart(itemid, uid, qty, totprice) VALUES("'.mysqli_real_escape_string($db, $itemid).'", ';
		$query = $query.''.mysqli_real_escape_string($db, $uid).', ';
		$query = $query.'"'.mysqli_real_escape_string($db, $qty).'", ';
		$query = $query.'"'.mysqli_real_escape_string($db, $price).'");';
		mysqli_query($db, $query);
		
		
		echo header("Location: it_added.php");

	}
	else 
	{
		echo "Item doesn't exist";
	}
?>