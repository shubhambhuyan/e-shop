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
	
	$query = "Select * from cart where  uid = ".mysqli_real_escape_string($db,$_SESSION['id'] ).' ;';
	$result = mysqli_query($db, $query);

	while($row = mysqli_fetch_assoc($result))
	{
		
		$query = 'INSERT INTO orders(itemid, uid, qty, totprice, dt) VALUES("'.mysqli_real_escape_string($db, $row['itemid']).'", ';
		$query = $query.''.mysqli_real_escape_string($db, $row['uid']).', ';
		$query = $query.'"'.mysqli_real_escape_string($db, $row['qty']).'", ';
		$query = $query.'"'.mysqli_real_escape_string($db, $row['totprice']).'" , now());';
		mysqli_query($db, $query);
		
		$query = "Select qty from items where  itemid = ".mysqli_real_escape_string($db, $row['itemid'] ).' ;';
		$res = mysqli_query($db, $query);
		$r = mysqli_fetch_assoc($res);
		$qty = $r['qty'] - $row['qty'];
		$query = "update items set qty = ".mysqli_real_escape_string($db, $qty)." where  itemid= ".mysqli_real_escape_string($db,$row['itemid'] ).';';
		mysqli_query($db, $query);
				
	}
	$query = "delete from cart where  uid=".mysqli_real_escape_string($db,$_SESSION['id'] ).';';
	mysqli_query($db, $query);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>uvce bazar</title>
<link href="admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container">
  <div id="navarea">
    <ul id="nav">
      <li><a href="home.php" title="home">home</a></li>
      <li><a href="logout.php" title="links">logout</a></li>
    </ul>
  </div>

		<br><br><br><br><br><br><br><br><br><br><br>
		
	<div id="maincol">
	<p>Thank you for shopping in UVCE Bazar!!!</p>
		<img src="images/ship.jpg"  border="0" />
		<p>Item ready to be shipped!!!</p>
	</div>
</div>
</body>
</html>