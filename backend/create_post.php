<?php require_once("include/functions.php");?>
<?php
session_start(); 
	require_once("include/connection.php");
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
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tinymce.js"></script>
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

<div id="body">
	<?php include_once("include/left_content.php"); ?>
    <div id="right_content">
        <div id="content">
        <?php 
		//get data
			$channels = mysql_query("SELECT * FROM channels");
	if(isset($_GET['success'])==1){
		$file_name = str_replace(" ", "_", $_POST['title']);
		$file_add = FILE_ADD."{$_SESSION['author_id']}";
		if(@opendir($file_add)){
			$result = article_write($file_name,$_POST);
		}
		else{
			mkdir(FILE_ADD."{$_SESSION['author_id']}");
			$result = article_write($file_name,$_POST);
		}
	//add post 
		if($result){
			$update_channel_data = mysql_query("UPDATE channels SET numOfPosts = numOfPosts + 1 WHERE channel_id = '{$_POST['channel']}'");
			$update_user_data = mysql_query("UPDATE authors SET numOfPosts = numOfPosts + 1 WHERE author_id = '{$_POST['author']}'");
			echo "Post created successfully"; }
		else{
		die("Post creation not successful".mysql_error());
		}
	}
	else{
			echo "Add post:<br />";
		//insert data	
			echo "<form action='create_post.php?success=1' method='post'>
				  Title: &nbsp;<input type='text' name='title' value='' size='24' /><br />
				  <input type='hidden' name='author' value='{$_SESSION['author_id']}' />
				  Channel: &nbsp;<select name='channel'>";
				 //generate channel list:
				 while($channel_set = mysql_fetch_array($channels))
				  		echo "<option value='{$channel_set['channel_id']}' >{$channel_set['name']}</option>";
						echo "</select><br />";
			echo "Content: &nbsp; <textarea name='content' rows='20' cols='80'></textarea>
				  Status: &nbsp; <select name='visible'>
				  				 <option value='1'>Publish</option>
								 <option value='0'>Do Not Publish</option></select>&nbsp;";
			$time = date("Y-m-d")." ".date("H:i:s");
			echo "Labels: &nbsp; <input type='text' value='' name='labels'/><br />
				  <input type='hidden' name='datetime' value='{$time}' />
				  <input type='submit' value='Create' />";				
			echo "</form>";	 
	}
        ?>
         </div>
    </div>
</div>
<!-- body ends -->
<?php 
	require_once("include/footer.php");
?>