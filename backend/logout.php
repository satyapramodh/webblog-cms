<?php
session_start();
 if(isset($_SESSION['username'])){
        session_destroy(); 
		}
require_once("include/connection.php");
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
        echo "<a href='logout.php'>Logout</a>";
		else
		 echo "<a href='login.php'>Log In</a>";
		?>
    </div>
</div>

<div id="body">
	<?php include_once("include/left_content.php") ?>
    <div id="right_content">
    	<div id="content">
        <?php if(isset($_SESSION['username'])){
        		echo "Logout Successful. Click <a href='login.php'>here</a> to Login again"; }
			  else echo "No session detected. Please login <a href='login.php'>here</a>";
		?>
        </div>
    </div>
</div>
<!-- body ends -->
<?php
	require_once("include/footer.php");
?>