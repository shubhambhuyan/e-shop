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
		$query = "Select * from items where itemid=".mysqli_real_escape_string($db, $id).';';
		$result = mysqli_query($db, $query);
		$row = mysqli_fetch_assoc($result);
		
		$itemid=$row['itemid'];
		$i_name = $row['name'];
		$quantity = $row['qty'];
		$i_price = $row['price'];		
	}
	//print_r($_POST);
	if(isset($_POST['update']) && $_POST['update'] == 'Update') 
	{
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
					//case UPLOAD_ERR_NO_FILE:
					case UPLOAD_ERR_EXTENSION: die("SOME ERROR occurred while uploading the images"); break;
				}
			}
			if($_FILES['img']['error'] != UPLOAD_ERR_NO_FILE) {
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
			
			$last_id = $_GET['id'];
			
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
		}
	
		$name = (isset($_POST['name']))?trim($_POST['name']):"";
		$price = (isset($_POST['price']))?trim($_POST['price']):"";
		$qty = (isset($_POST['qty']))?trim($_POST['qty']):"";

		$name = (empty($name))?$row['name']:$name;
		$price = (empty($price))?$row['price']:$price;
		$qty = (empty($qty))?$row['qty']:$qty;
		if(empty($imagename)) {
			$imagename = $row['picurl'];
		}
		$query = 'UPDATE items SET name="'.mysqli_real_escape_string($db, $name).'", price ='.mysqli_real_escape_string($db, $price).', 
		qty ='.mysqli_real_escape_string($db, $qty). ', picurl = "'.mysqli_real_escape_string($db, $imagename).'" WHERE itemid = '.$itemid.';';
		mysqli_query($db, $query);
		
		if(!empty($imagename)) {
			imagedestroy($image);
		}
		
		header("Location: edit.php?id=".$itemid);
	}
	

?>


<!DOCTYPE html>
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
	<?php
		echo "Item Name : ".$i_name."</br>";
		echo "Unit Price : ".$i_price."</br>";
		echo "Quantity Left : ".$quantity."</br></br></br>" ;
	
	?>

    </p>
		
	<form action = <?php echo '"edit.php?id='.$_GET['id'].'"';	?>   method = "POST" enctype="multipart/form-data">
				<div class="alignrt">
				<input type="text" name="name" value=""  placeholder="Change item name"  data-trigger="change" data-validation-minlength="1" data-type="name" data-required="true" data-error-message="Enter Your First Name">
				</div>
				
				<div class="alignrt">
				<input type="text" name="price" value=""  placeholder="Change item price"  data-trigger="change" data-validation-minlength="1" data-type="name" data-required="true" data-error-message="Enter Your First Name">
				</div>
				
				<div class="alignrt">
				<input type="text" name="qty" value=""  placeholder="Change available quantity"  data-trigger="change" data-validation-minlength="1" data-type="name" data-required="true" data-error-message="Enter Your First Name">
				</div>
				
				<div class="alignrt">
				<input type="file" name="img">
				</div>
				
			<!--	<div class="alignrt">
				<input type="text" name="catid" value=""  placeholder="Change category id"  data-trigger="change" data-validation-minlength="1" data-type="name" data-required="true" data-error-message="Enter Your First Name"/>
				</div> -->
				
				<br>
				
		<input type="submit" id="" name="update" value="Update">
		</br></br>
	</form>
  <div id="bttmbar"> <span id="copyright"></span>

  </div>
</div>
</div>
</body>
</html>