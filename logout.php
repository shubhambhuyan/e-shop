<?php
	session_start();
	if($_SESSION['logged'] == 1) 
	{
		session_destroy();
		header("Location: login.php");
	}
	else 
	{
		header("Location: login.php");
	}
?>
