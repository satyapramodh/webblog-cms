<?php
session_start(); 
	require_once("connection.php");
	//check login
		//if from another page, check for session existence
	if(!isset($_SESSION['username'])) {
		header("Location: login.php");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Backend Web Blog</title>
<link type="text/css" rel="stylesheet" href="css/style.css" />
</head>

<body>

<div id="header">
	<div id="header_content">
		Backend Web Blog<br />
        <?php if(isset($_SESSION['username']))
        echo "<a href='logout.php'>Logout</a><br />";
		else
		 echo "<a href='login.php'>Log In</a><br />";
		?>
    </div>
    <small><?php echo $time = date("Y-m-d")." ".date("H:i:s"); ?></small>
</div>
