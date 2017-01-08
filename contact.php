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
	mysqli_close($db);




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>uvce bazar</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper_outer">
	<div id="wrapper_inner">
	<div class="top_right">
				<div class="languages">
					<?php
					if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) 
					{
							echo "<font size ='3'>Welcome, </font>" . "<font size ='3'>".$_SESSION['username']. "!"."</font>" ."</br>";
							echo "<a href='logout.php'><img src='images/lo.gif' height='30' width='35'></a>";
					} else 
					{
							echo "Please log in first to see this page.";
					}
				?>
					<a href="checkOut.php" class="lang" ><img src="images/acart.gif" height= "30" width="30" alt="" border="0" /></a>
				</div>
			</div>
		<div id="header">
            <div id="site_title"> 
                <a href="home.php" target="">UVCE Bazar<span>online store for all your engineering needs</span></a>            
            </div>  
        </div> 
        
        <div id="menu">
    
            <ul>
                <li><a href="home.php" class="current">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>  
        
        </div> 
        
        <div id="content_wrapper">
        
            <div id="sidebar">
            
                <div class="sidebar_box">
                    
                    <h2>Branch</h2>
                    <ul class="side_menu">
						<li><a href="cs.php">Computer Science</a></li>
                        <li><a href="me.php">Mechanical</a></li>
                        <li><a href="ec.php">Electrical & EC</a></li>
                        <li><a href="ac.php">Architecture and civil</a></li>                   
                    </ul>
                
                </div>
                
                <div class="sidebar_box">
           
                </div>
            
            </div> 
            
            <div id="content">
            
            	<div class="post_section"><span class="top"></span><span class="bottom"></span>
        
                     <div class="post_content">
					 <h2>Contact Us</h2>
					 <br>
					 UVCE Bazar welcomes and appreciates your feedback.
					 Email your questions, suggestion or comments to us any time.<br> <img width="35" height="35" src="images/email.gif">
					 <br><font size="3" color='red' >bhuyanshubham@gmail.com</font>
					 <br><br>
					 For even faster assistance, you can call us at:<br>
					 <img width="35" height="35" src="images/phone.png"><br>
					 <font size="3" color='red' >+91-8951355286</font><br>
					 <br>we are always available at :<br>
					 <img width="35" height="35" src="images/ads.png"><br>
					 <font size="3" color='red' >University of Visvesvaraya College of Engineering,<br>
					 K R Circle, Dr Ambedkar Veedhi,<br>Bengaluru, Karnataka 560001</font>
                    </div>
                </div>
            
            </div> 
        
        	<div class="cleaner"></div>
        </div>
    
    </div> 
    
</div>

<div id="footer_outer">
<div id="footer_inner">
    <div id="footer">
    
    	
        
       
       
        
        <div class="margin_bottom_20"></div>
    	<div class="margin_bottom_20"></div>
		Copyright © 2048 <a href="#">uvce bazar inc</a> | 
				<a href="" target=""></a> by <a href="" target="">shubham</a>
        
    </div> 
</div> 
</div>
</body>
</html>