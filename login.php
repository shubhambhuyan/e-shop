<?php
	session_start();
		ini_set('display_errors', true);
	error_reporting(E_ALL ^ E_NOTICE);
		if(isset($_SESSION['logged']) && $_SESSION['logged'] == 1) 
	{
		header("Location: home.php");
		die();
	}
	if(isset($_POST['login']) && $_POST['login'] == 'Login') 
	{
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
		
		$username = (isset($_POST['user']))?trim($_POST['user']):"";
		$passwd = (isset($_POST['pass']))?$_POST['pass']:"";
		
		$query = 'SELECT * FROM user WHERE username="'.mysqli_real_escape_string($db, $username).'" and password=PASSWORD("'.mysqli_real_escape_string($db, $passwd).'");';
		$result = mysqli_query($db, $query);
		if(mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_assoc($result);
			$_SESSION['id'] = $row['id'];
			$_SESSION['username'] = $username;
			$_SESSION['logged'] = 1;
			if($username == "admin")
			{
				header("Location: admin.php");
			}
			else
			{
				header("Location: home.php");
			}
			
		}
		else 
		{
			header("Location: login.php?no_match=1");
		}
		mysqli_free_result($result);
		mysqli_close($db);
		if($_SESSION['logged'] == 1) 
		{
			die();
		}
	}
	
	$required = array('ruser', 'rpass', 'dob', 'email');
	if(isset($_POST['register']) && $_POST['register'] == 'Register') 
	{
		$missing = array();
		
		$ruser = (isset($_POST['ruser']))?trim($_POST['ruser']):"";
		$rpass = (isset($_POST['rpass']))?$_POST['rpass']:"";
		$dob = (isset($_POST['dob']))?trim($_POST['dob']):"";
		$email = (isset($_POST['email']))?trim($_POST['email']):"";
		
		
		if(empty($ruser)) array_push($missing, "ruser");
		if(empty($rpass)) array_push($missing, "rpass");
		if(empty($dob)) array_push($missing, "dob");
		if(empty($email)) array_push($missing, "email");

		
		
		if(!empty($missing)) 
		{
			$missing_values = implode($missing, "=1&");
			header("Location: login.php?$missing_values=1");
			die();
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
		
		$query = 'SELECT * FROM user WHERE email = "'.mysqli_real_escape_string($db, $email).'";';
		$result = mysqli_query($db, $query);
		if(mysqli_num_rows($result) > 0) 
		{
			header("Location: login.php?existing_user=1");
			die();
		}
		mysqli_free_result($result);
		$datetocheck = explode("-", $dob);
		if(!checkdate($datetocheck[1], $datetocheck[2], $datetocheck[0])) 
		{
			header("Location: login.php?invalid_date=1");
			die();
		}
		
			$query = 'INSERT INTO user(username, password, dob, email) VALUES("'.mysqli_real_escape_string($db, $ruser).'", ';
			$query = $query.'PASSWORD("'.mysqli_real_escape_string($db, $rpass).'"), ';
			$query = $query.'"'.mysqli_real_escape_string($db, $dob).'", ';
			$query = $query.'"'.mysqli_real_escape_string($db, $email).'");';
				
			mysqli_query($db, $query);
			if(mysqli_error($db)) {
				echo "Some error";
			}
			mysqli_close($db);
			header("Location: login.php?reg_success=1");
	}

?>




<!DOCTYPE html>
<html>

<head>

  <title>uvce bazar</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
<p align="center"><img src="images/logo.gif" style="width:150px"></p>
	<div class="login-card" align="">
	<h1>Log-in</h1><br>
	  <form method="POST" action="login.php">
	  <?php
		if(isset($_GET['no_match']) && $_GET['no_match'] == 1) {
			echo '<br><span class="warning">';
						echo "*username or password mismatch";	
						echo '</span>';	
		}
		?>
		<input type="text" name="user" placeholder="Username">
		<input type="password" name="pass" placeholder="Password">
		<input type="submit" name="login" class="login login-submit" value="Login">
	  </form>
	</div>
	
	<div class="reg-card">
	<h1>Register</h1><br>
	  <form method="POST" action="login.php">
		Username:<input type="text" name="ruser">
		<?php
					if(isset($_GET['ruser']) && $_GET['ruser'] == 1) 
					{
						echo '<br><span class="warning">';
						echo "*username missing";	
						echo '</span>';				
					}
					
					if(isset($_GET['existing_user']) && $_GET['existing_user'] == 1)
					{
						echo '<span class="warning">';
						echo "*User already exists";	
						echo '</span>';				
					}
		?>
		<br>
		Password: <input type="password" name="rpass">
		<?php
			if(isset($_GET['rpass']) && $_GET['rpass'] == 1) 
			{
						echo '<span class="warning">';
						echo "*Enter password";	
						echo '</span>';				
			}		
		?>
		<br>
		Date of Birth:<input type="date" name="dob">
		<?php
					if(isset($_GET['dob']) && $_GET['dob'] == 1) {
					echo '<span class="warning">';
					echo "*Enter your birthdate";	
					echo '</span>';				
					}
					
					if(isset($_GET['invalid_date']) && $_GET['invalid_date'] == 1) {
					echo '<span class="warning">';
					echo "*Enter a valid date";	
					echo '</span>';				
					}
		?>
		<br>
		Email: <input type="email" name="email" />
		<?php
					if(isset($_GET['email']) && $_GET['email'] == 1) 
					{
						echo '<span class="warning">';
						echo "*Email missing";	
						echo '</span>';				
					}
					
					if(isset($_GET['existing_user']) && $_GET['existing_user'] == 1)
					{
						echo '<span class="warning">';
						echo "*Mail id already exists";	
						echo '</span>';				
					}
		?>
		<input type="submit" name="register" class="register register-submit" value="Register">
	  </form>
	</div>
</body>
</html>