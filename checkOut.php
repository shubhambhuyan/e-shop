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


		<div class="step" id="step1">
			<div class="number">
				<span>1</span>
			</div>
			<div class="title">
				<h1>Email Address</h1>
			</div>
		</div>
		<div class="content" id="email">
				<div class="final">
					<p align="left">
					<?php echo $email?>
					</p>
				</div>
				 <div id="navarea">
				<a href="home.php" id="nav"><button>home</button></a></br></br>
				<a href="logout.php" id="nav"><button>Logout</button></a>
				</div>
		</div>
		<div class="step" id="step2">
			<div class="number">
				<span>2</span>
			</div>
			<div class="title">
				<h1>Shipping Information</h1>
			</div>
		</div>
		<div class="content" id="address">
			<form class="go-right" method ="POST" action = "order.php">
				<div>
				<input type="name" name="fname" value="" id="first_name" placeholder="Hi <?php echo $_SESSION['username'] ?>!!!" data-trigger="change" data-validation-minlength="1" data-type="name" data-required="true" data-error-message="Enter Your First Name"/><label for="fname">First Name</label>
				<?php
				if(isset($_GET['fname']) && $_GET['fname'] == 1) 
				{
							echo '<span class="warning">';
							echo "*Enter first name";	
							echo '</span>';				
				}		
				?>
				</div>
				
				
				<div>
				<input type="name" name="lname" value="" id="last_name" placeholder="please" data-trigger="change" data-validation-minlength="1" data-type="name" data-required="true" data-error-message="Enter Your Last Name"/><label for="lname">Last Name</label>
				<?php
				if(isset($_GET['lname']) && $_GET['lname'] == 1) 
				{
							echo '<span class="warning">';
							echo "*Enter last name";	
							echo '</span>';				
				}		
				?>
				</div>
				
				
				<div>
				<input type="phone" name="telephone" value="" id="telephone" placeholder="enter" data-trigger="change" data-validation-minlength="1" data-type="number" data-required="true" data-error-message="Enter Your Telephone Number"/><label for="telephone">Telephone</label>
				<?php
				if(isset($_GET['telephone']) && $_GET['telephone'] == 1) 
				{
							echo '<span class="warning">';
							echo "*Enter phone number";	
							echo '</span>';				
				}		
				?>
				</div>
				
				
				<div>
				<input type="text" name="house" value="" id="company" placeholder="your" data-trigger="change" data-validation-minlength="1" data-type="name" data-required="true"/><label for="House">House No.</label>
				<?php
				if(isset($_GET['house']) && $_GET['house'] == 1) 
				{
							echo '<span class="warning">';
							echo "*Enter house number";	
							echo '</span>';				
				}		
				?>
				</div>
				
				
				<div>
				<input type="text" name="area" value="" id="company" placeholder="shipping" data-trigger="change" data-validation-minlength="1" data-type="name" data-required="true"/><label for="House">Street</label>
				<?php
				if(isset($_GET['area']) && $_GET['area'] == 1) 
				{
							echo '<span class="warning">';
							echo "*Enter locality";	
							echo '</span>';				
				}		
				?>
				</div>
				
				
				<div>
				<input type="text" name="address" value="" id="address" placeholder="details" data-trigger="change" data-validation-minlength="1" data-type="text" data-required="true" data-error-message="Enter Your Billing Address"/><label for="Address">Area</label>
				<?php
				if(isset($_GET['address']) && $_GET['address'] == 1) 
				{
							echo '<span class="warning">';
							echo "*Enter locality";	
							echo '</span>';				
				}		
				?>
				</div>
				
				<div>
				<input type="text" name="city" value="" id="city" placeholder="" data-trigger="change" data-validation-minlength="1" data-type="text" data-required="true" data-error-message="Enter Your Billing City"/><label for="city">City</label>
				<?php
				if(isset($_GET['city']) && $_GET['city'] == 1) 
				{
							echo '<span class="warning">';
							echo "*Enter city name";	
							echo '</span>';				
				}		
				?>
				</div>
				
				<div>
				<input type="text" name="state" value="" id="state" placeholder="" data-trigger="change" data-validation-minlength="1" data-type="text" data-required="true" data-error-message="Enter Your Billing state"/><label for="state">State</label>
          		<?php
				if(isset($_GET['state']) && $_GET['state'] == 1) 
				{
							echo '<span class="warning">';
							echo "*Enter state";	
							echo '</span>';				
				}		
				?>
				</div>
				
				<div>
				<input type="text" name="zip" value="" id="zip" placeholder="" data-trigger="change" data-validation-minlength="1" data-type="text" data-required="true" data-error-message="Enter Your Billing Zip Code"/><label for="zip">Zip Code</label>
				<?php
				if(isset($_GET['zip']) && $_GET['zip'] == 1) 
				{
							echo '<span class="warning">';
							echo "*Enter zip code";	
							echo '</span>';				
				}		
				?>
				</div>
				
				<div>
				<input type="text" name="country" value="" id="country" placeholder="" data-trigger="change" data-validation-minlength="1" data-type="text" data-required="true" data-error-message="Enter Your Billing Country"/><label for="country">Country</label>
				<?php
				if(isset($_GET['country']) && $_GET['country'] == 1) 
				{
							echo '<span class="warning">';
							echo "*Enter country";
							echo '</span>';				
				}		
				?>
				</div>
			
		</div>
		<div class="step" id="step4">
			<div class="number">
				<span>3</span>
			</div>
			<div class="title">
				<h1>Payment Information</h1>
			</div>
		</div>
		<div class="content" id="payment">
			<div class="left credit_card" >
				<div>
				<input type="number" name="card_number" value="" id="card_number" placeholder="xxxx-xxxx-xxxx-xxxx" data-trigger="change" data-validation-minlength="1" data-type="name" data-required="true" data-error-message="Enter Your Credit Card Number"/>
			
				<?php
					if(isset($_GET['card_number']) && $_GET['card_number'] == 1) 
					{
								echo '<span class="warning">';
								echo "*Enter your card number";	
								echo '</span>';				
					}		
					?>
				</div>
				<div>
				  <div class="expiry">	
				      <div class="month_select">
				        <select name="exp_month" value="" id="exp_month" placeholder="" data-trigger="change" data-type="name" data-required="true" data-error-message="Enter Your Credit Card Expiration Date">
							<option value = "1">01 (Jan)</option>
                   			<option value = "2">02 (Feb)</option>
                   			<option value = "3">03 (Mar)</option>
                   			<option value = "4">04 (Apr)</option>
                   			<option value = "5">05 (May)</option>
                   			<option value = "6">06 (Jun)</option>
                   			<option value = "7">07 (Jul)</option>
                   			<option value = "8">08 (Aug)</option>
                   			<option value = "9">09 (Sep)</option>
                   			<option value = "10">10 (Oct)</option>
                   			<option value = "11">11 (Nov)</option>
                   			<option value = "12">12 (Dec)</option>
                        </select>
                      </div>
                      <span class="divider">-</span>
                      <div class="year_select">
				        <select name="exp_year" value="" id="exp_year" placeholder="" data-trigger="change" data-type="name" data-required="true" data-error-message="Enter Your Credit Card Expiration Date">
							<option value = "1">14 </option>
                   			<option value = "2">15 (Feb)</option>
                   			<option value = "3">16 (Mar)</option>
                   			<option value = "4">17 (Apr)</option>
                   			<option value = "5">18 (May)</option>
                   			<option value = "6">19 (Jun)</option>
                   			<option value = "7">20 (Jul)</option>
                   			<option value = "8">22 (Aug)</option>
                   			<option value = "9">23 (Sep)</option>
                   			<option value = "10">24 (Oct)</option>
                   			<option value = "11">25 (Nov)</option>
                   			<option value = "12">26 (Dec)</option>
                        </select>
            	      </div>
            	    </div>
                 
            	</div>
			
            	<div class="sec_num">
				        <input type="password" name="cvv" value="" id="cvv" placeholder="cvv" data-trigger="change" data-validation-minlength="3" data-type="name" data-required="true" data-error-message="Enter Your Card Security Code"/>
						
						<?php
						if(isset($_GET['cvv']) && $_GET['cvv'] == 1) 
						{
									echo '<span class="warning">';
									echo "*Enter card verfication value";	
									echo '</span>';				
						}		
						?>
					
				</div>
				</div>
				
				
		</div>
			
		<div class="step" id="step4">
			<div class="number">
				<span>4</span>
			</div>
			<div class="title">
				<h1>Purchase Information</h1>
			</div>
		</div>
		<div class="content" id="final_products">
			<div class="left" id="ordered">
				<div class="products">
		
				<?php
						$query = "Select * from cart,items where  uid=".mysqli_real_escape_string($db,$_SESSION['id'] ).' and cart.itemid = items.itemid order by name asc;';
						$result = mysqli_query($db, $query);
						
						while($row = mysqli_fetch_assoc($result))
						{
							$query = "Select * from items where  itemid=".mysqli_real_escape_string($db,$row['itemid'] ).';';
							$res = mysqli_query($db, $query);
							$r = mysqli_fetch_assoc($res);

							
							
					
					?>
					<tr>
					<!--<div class="product_image">
						<img src="images/pc-12.jpg"/>
					</div> -->
					<div class="product_details">
					
					
					
						<span class="product_name">
						<?php
						echo $r['name'];
						
						?>

						</span>
						<span class="quantity">
						<select name="item_count[]" value="" id="exp_year" placeholder="" data-trigger="change" data-type="name" data-required="true" data-error-message="Enter quantity">
							<?php
							if($row['qty']== 0)
								echo "item out of stock" ;
							else
							{
								for ($x = 1; $x <= $row['qty']; $x++) 
								{
											echo "<option value = '$x'>$x </option>";
								}
							}
							?>
                        </select>
						</span>
						<span class="price">
						<?php
						echo "Rs.".$r['price'];
						?>
						</span>
						<span class="price">
						<?php
						echo '<a href="remove.php?id='.$r['itemid'].'">remove</a>'
						
						?>
						</span>
					</div>
					<?php
						}
						?>
						
				</div>
				<!--<div class="totals">
					<span class="subtitle">Subtotal <span id="sub_price">45.00</span></span>
				</div>
				<div class="final">
					<span class="title">Total <span id="calculated_total">45.00</span></span>
				</div>-->
			</div>	
		
				<div class="content" id="email">
					<button type="submit" name="submit" value="Submit">Submit </button>
			</div>	
		</div>
		</div>
		
 		</form>
</body>
</html>
