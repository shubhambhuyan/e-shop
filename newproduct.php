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

	$username = $_SESSION['username'];
	if($username!="admin")
	{
		header("Location: home.php");
	}
	
	$required = array('name', 'price', 'qty', 'img', 'catid');
	if(isset($_POST['submit']) && $_POST['submit'] == 'Submit') 
	{
		$missing = array();
		
		$name = (isset($_POST['name']))?trim($_POST['name']):"";
		$price = (isset($_POST['price']))?trim($_POST['price']):"";
		$qty = (isset($_POST['qty']))?trim($_POST['qty']):"";
		$catid = (isset($_POST['catid']))?trim($_POST['catid']):"";

		
		if(empty($name)) array_push($missing, "name");
		if(empty($price)) array_push($missing, "price");
		if(empty($qty)) array_push($missing, "qty");
		if(empty($catid)) array_push($missing, "catid");
		
		if(!empty($missing)) 
		{
			$missing_values = implode($missing, "=1&");
			header("Location: newproduct.php?$missing_values=1");
			die();
		}
		
		
		$folder = 'products/';
		$imagename = "";
		//print_r($_FILES);
		//die();
		if(isset($_FILES['img']))
		{
			if($_FILES['img']['error'] != UPLOAD_ERR_OK) 
			{
				switch($_FILES['img']['error']) 
				{
					case UPLOAD_ERR_INI_SIZE: 
					case UPLOAD_ERR_FORM_SIZE: 
					case UPLOAD_ERR_PARTIAL: 
					case UPLOAD_ERR_NO_TMP_DIR:
					case UPLOAD_ERR_CANT_WRITE:
					case UPLOAD_ERR_NO_FILE:
					case UPLOAD_ERR_EXTENSION: die("SOME ERROR occurred while uploading the images"); break;
				}
			}
			
			list($width, $height, $type, $a) = getimagesize($_FILES['img']['tmp_name']);
			//check the type of image if jpeg or png
			switch($type) {
				case IMAGETYPE_PNG: $image = imagecreatefrompng($_FILES['img']['tmp_name']); 
									if(!$image) {
										die("1. Image type error!");
									}
									$ext = '.png'; 
									break;
				case IMAGETYPE_JPEG:	$image = imagecreatefromjpeg($_FILES['img']['tmp_name']);
										if(!$image) {
											die("2. Image type error!");
										}
										$ext = '.jpg'; 
										break;
				default: 	die("3. Image type error!"); break;
			}
			$query = 'INSERT INTO items (name, price, qty, picurl, catid) VALUES (" '.mysqli_real_escape_string($db, $name).'", ';
			$query = $query.'"'.mysqli_real_escape_string($db, $price).'", ';
			$query = $query.'"'.mysqli_real_escape_string($db, $qty).'", ';
			$query = $query.'"'.mysqli_real_escape_string($db, $picurl).'", ';
			$query = $query.'"'.mysqli_real_escape_string($db, $catid).'");';
		mysqli_query($db, $query);
	
			$last_id = mysqli_insert_id($db);
			$imagename = $last_id.$ext;	
			
			//give extension based upon type and store image in pictures
			$imagename = $last_id.$ext;
			switch($type) {
				case IMAGETYPE_JPEG: 	imagejpeg($image, $folder.$imagename, 100); 
										break;
				case IMAGETYPE_PNG: 	imagepng($image, $folder.$imagename); 
										break;
			}
			$imagename = $folder.$imagename;
		}
		
		$query = 'UPDATE items SET picurl="'.mysqli_real_escape_string($db, $imagename).'" 
			WHERE itemid='.mysqli_real_escape_string($db, $last_id).';';
			$result = mysqli_query($db, $query);
	
		//print_r($query);
		//die();
		if(!empty($imagename)) {
			imagedestroy($image);
		}
		
		header("Location: newproduct.php");
	}

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
      <li><a href="home.php" title="home">home</a></li>
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

	
	
	<form action = "newproduct.php"   method = "POST" enctype="multipart/form-data">
				<div class="alignrt">
				</br>
				<input type="text" name="name" value=""  placeholder="enter item name" >
				<?php
					if(isset($_GET['name']) && $_GET['name'] == 1) 
					{
						echo '<br><span class="warning">';
						echo "*name missing";	
						echo '</span>';				
					}
				?>
				</div>
				
				<div class="alignrt">
				</br>
				<input type="text" name="price" value=""  placeholder="enter item price" >
				<?php
					if(isset($_GET['price']) && $_GET['price'] == 1) 
					{
						echo '<br><span class="warning">';
						echo "*price missing";	
						echo '</span>';				
					}
				?>
				</div>
				
				<div class="alignrt">
				</br>
				<input type="text" name="qty" value=""  placeholder="enter the available quantity" >
				<?php
					if(isset($_GET['qty']) && $_GET['qty'] == 1) 
					{
						echo '<br><span class="warning">';
						echo "*quantity missing";	
						echo '</span>';				
					}
				?>
				</div>
				
				<div class="alignrt">
				</br>
				<input type="file" name="img">
				</div>
				
				<div class="alignrt">
				</br>
				<input type="number" name="catid" value=""  placeholder="enter category id"  />
				<?php
					if(isset($_GET['catid']) && $_GET['catid'] == 1) 
					{
						echo '<br><span class="warning">';
						echo "*category id missing";	
						echo '</span>';				
					}
				?>
				</div>
				
				<br>
				
		<input type="submit" id="" name="submit" value="Submit">
		</br></br>
	</form>
	
	
	
	
    </p>
	
  <div id="bttmbar"> <span id="copyright"></span>

  </div>
</div>
</div>
</body>
</html>
