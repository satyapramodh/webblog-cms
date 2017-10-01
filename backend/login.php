<?php 
session_start(); 
	require_once("include/connection.php");

	//if redirected from login.php
	if(isset($_POST['username'])){
		$user = mysql_real_escape_string($_POST['username']);
		$pass = $_POST['password'];
		//check
		$login = mysql_query("SELECT * FROM authors
							  WHERE username = '{$user}' AND password = '{$pass}'");
		if(mysql_num_rows($login)>=1){
			$author_array = mysql_fetch_array($login);
			$_SESSION['username'] = $user;
			$_SESSION['author_name'] = $author_array['author_name'];
			$_SESSION['numOfPosts'] = $author_array['numOfPosts'];
			$_SESSION['author_id'] = $author_array['author_id'];
			$_SESSION['admin'] = $author_array['admin'];
		}
		if(isset($_SESSION['username']))
		header("Location: bindex.php");
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
        echo "<a href='logout.php'>Logout</a>";
		else
		 echo "<a href='login.php'>Log In</a>";
		?>
    </div>
</div>

<div id="body">
	<?php include_once("include/left_content.php"); $success=0; ?>
    <div id="right_content">
        <div id="content">
        <?php if(isset($_SESSION['username'])){
				echo "You are logged in."; }
			  else{
				echo"<form method='post' action='login.php'>
					  Username: &nbsp;<input type='text' name='username' /><br /><br />
					  Password: &nbsp;<input type='password' name='password' /><br /><br />
					  <input type='submit' value='submit' />
					</form>";
			  	}
			  ?>
         </div>
     </div>
</div>
<!-- body ends -->
<?php 
	require_once("include/footer.php");
?>