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

	
	
	$required = array('fname', 'lname', 'telephone', 'house', 'area', 'address', 'city', 'state', 'zip', 'country','card_number','cvv');
	if(isset($_POST['submit']) && $_POST['submit'] == 'Submit') 
	{
		$missing = array();
		
		$fname = (isset($_POST['fname']))?trim($_POST['fname']):"";
		$lname = (isset($_POST['lname']))?trim($_POST['lname']):"";
		$telephone = (isset($_POST['telephone']))?trim($_POST['telephone']):"";
		$house = (isset($_POST['house']))?$_POST['house']:"";
		$area = (isset($_POST['area']))?$_POST['area']:"";
		$address = (isset($_POST['address']))?$_POST['address']:"";
		$city = (isset($_POST['city']))?$_POST['city']:"";
		$state = (isset($_POST['state']))?$_POST['state']:"";
		$zip = (isset($_POST['zip']))?$_POST['zip']:"";
		$country = (isset($_POST['country']))?$_POST['country']:"";
		$card_number = (isset($_POST['card_number']))?trim($_POST['card_number']):"";
		$cvv = (isset($_POST['cvv']))?$_POST['cvv']:"";
		
		
		if(empty($fname)) array_push($missing, "fname");
		if(empty($lname)) array_push($missing, "lname");
		if(empty($telephone)) array_push($missing, "telephone");
		if(empty($house)) array_push($missing, "house");
		if(empty($area)) array_push($missing, "area");
		if(empty($address)) array_push($missing, "address");
		if(empty($city)) array_push($missing, "city");
		if(empty($state)) array_push($missing, "state");
		if(empty($zip)) array_push($missing, "zip");
		if(empty($country)) array_push($missing, "country");
		if(empty($card_number)) array_push($missing, "card_number");
		if(empty($cvv)) array_push($missing, "cvv");
	
		
		if(!empty($missing)) 
		{
			$missing_values = implode($missing, "=1&");
			header("Location: checkOut.php?$missing_values=1");
			die();
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
		
		$query = "Select * from cart,items where  uid=".mysqli_real_escape_string($db,$_SESSION['id'] ).' and cart.itemid = items.itemid order by name asc;';
		$result = mysqli_query($db, $query);

		$i=0;
		while($row = mysqli_fetch_assoc($result))
		{
			$query = "Select * from items where  itemid=".mysqli_real_escape_string($db,$row['itemid'] ).';';
			$res = mysqli_query($db, $query);
		
			while($r = mysqli_fetch_assoc($res))
			{
				$count = $_POST['item_count'][$i];
				$query = "update cart set qty = ".mysqli_real_escape_string($db, $count)." where  itemid= ".mysqli_real_escape_string($db,$r['itemid'] ).' and uid = '.mysqli_real_escape_string($db,$_SESSION['id'] ).';';
				mysqli_query($db, $query);
				$price = $r['price'] * $count;
				$query = "update cart set totprice = ".mysqli_real_escape_string($db, $price)." where  itemid= ".mysqli_real_escape_string($db,$r['itemid'] ).' and uid = '.mysqli_real_escape_string($db,$_SESSION['id'] ).';';
				mysqli_query($db, $query);
				$i=$i+1;
				
			}
		}
	}
?>

<!DOCTYPE html>
<html lang='en'>
<head>
  <title>check out</title>
    <link rel="stylesheet" type="text/css" href="css/checkOut.css" />
</head>
<body>
<div id="wrap">
	<div id="accordian">
	
	
	
	<div class="right" id="reviewed">
				<div class="shipping">
					<span class="title">Shipping:</span>
					<div class="address_reviewed">
						<span class="name"><?php echo $_POST['first_name']." ". $_POST['last_name']?></span>
						<span class="address"><?php echo $_POST['house'].", ". $_POST['area'].", ";?></span>
						<span class="address"><?php echo $_POST['address'].", ";?></span>
						<span class="location"><?php echo $_POST['city'].", ";?></span>
						<span class="location"><?php echo $_POST['state']." ". $_POST['zip'];?></span>
						<span class="phone"><?php echo $_POST['telephone'];?></span>
					</div>
				</div>
				<div class="payment">
					<span class="title">Payment:</span>
					<div class="payment_reviewed">
						<span class="method">Card</span>
						<span class="number_hidden"><?php echo $_POST['card_number'];?></span>
					</div>
				</div>
				<div class="payment">
					<span class="title">Product detail:</span>
					<span class="method">
					
					<table>
					<th>Item name</th>
					<th>unit price</th>
					<th>quantity</th>
					<th>total price</th>
					
					<?php
					$query = "Select *, cart.qty as c from cart,items where  uid=".mysqli_real_escape_string($db,$_SESSION['id'] ).' and cart.itemid = items.itemid;';
					$result = mysqli_query($db, $query);
					$total = 0;
					while($res = mysqli_fetch_assoc($result))
					{
					?>
							<tr>
							<td><?php echo $res['name']; ?></td>
							  <td><?php echo $res['price']; ?></td>
							  <td><?php echo $res['c'];?></td>
							  <td><?php echo $res['totprice'];?></td>
							  </tr>
					<?php
					$total = $total + $res['totprice'];
					}
					?>
					
					</table>
				</span>
				<div class="sfinal">
					<span class="stitle">Total : Rs <span class="tval"><?php echo $total;?></span></span>
				</div>
				
				</div>
				<div id="complete">
				<a href ="confirmorder.php" class="big_button" id="complete" href="">Complete Order</a>
				<span class="sub">By selecting this button you agree to the purchase and subsequent payment for this order.</span> 
				</div>
				</div>
			</div>
		</div>
		</body>
</html>