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


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Admin</title>
<link rel="stylesheet" type="text/css" href="admin.css" />
</head>
<body>
<div id="container">
  <div id="navarea">
    <ul id="nav">
      <li><a href="home.php" title="home">Home</a></li>
      <li><a href="logout.php" title="links">logout</a></li>
    </ul>
  </div>
  <div id="hdr"> <span id="sitetitle">UVCE Bazar</span> <br />
    <span id="subtitle">online store for all your engineering needs</span>
</div>
  <div id="lftcol">
    <div class="leftcolbox">
      <div class="leftcolboxtop"></div>
      <h2>Useful links:</h2>
      <p> <a href="admin.php">Admin Timeline</a><br />
        <a href="adproduct.php"> Product</a><br />
		<a href="newproduct.php"><img height='40' width='100' src = "images/add.gif"></a><br />
      <br />
    </div>
  </div>
  <div id="maincol">
    <div class="rule">
      <h1>Welcome Admin</h1>
    </div>
	<p>
	<table>
	<th>Item name</th>
	<th>unit price</th>
	<th>quantity</th>
	<th></th>
	<th></th>

	<?php
	$query = "Select * from items ;";
	$result = mysqli_query($db, $query);
	while($res = mysqli_fetch_assoc($result))
	{
	
	?>
	
   <ul>
      <tr><td><?php echo $res['name']."    "; ?></td>
      <td><?php echo $res['price']."    "; ?></td>
      <td><?php echo $res['qty']; echo "<br>"; ?></td>
	  <td><?php echo '<a href="edit.php?id='.$res['itemid'].'">edit</a>'?></td>
	  <td><?php echo '<a href="deleteitem.php?id='.$res['itemid'].'"><img height = "20" width = "50" src = images/remove.gif></a>'?></td>
	  </tr>
    </ul>
	<?php 
	}
	?>
	</table>
    </p>
	
  <div id="bttmbar"> <span id="copyright"></span>

  </div>
</div>
</div>
</body>
</html>