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
		if(isset($_GET['auth_id']) || isset($_GET['success'])){
			$channels = mysql_query("SELECT * FROM channels");
			$posts = mysql_query("SELECT * FROM posts
								 WHERE post_id = '{$_GET['post_id']}'");
			$post_data = mysql_fetch_array($posts);
			$file_name = str_replace(' ','_',$post_data['title']);
			$file_add = FILE_ADD."{$_SESSION['author_id']}\\{$file_name}.txt";
			$file = fopen($file_add,"r");
			$file_content = fread($file,filesize($file_add));
			fclose($file);
		}
		if(isset($_GET['success'])==1 && strlen(isset($_POST['content']))){
			$time = date("Y-m-d")." ".date("H:i:s");
			$_POST['content']=htmlspecialchars($_POST['content']);
			$_POST['content'] = addslashes($_POST['content']);
			$result = mysql_query("UPDATE posts
							   SET author_id = '{$_POST['author']}', channel_id = '{$_POST['channel']}', title = '{$_POST['title']}', content = '{$_POST['content']}', visible = '{$_POST['visible']}', labels = '{$_POST['labels']}', datetime = '{$time}'	
							   WHERE post_id = '{$_POST['post_id']}'");
		if($result){
			$file = fopen($file_add,"w+");
			fwrite($file,$_POST['content']);
			fclose($file);
			$file = fopen($file_add,"r");
			$file_content = fread($file,filesize($file_add));
			fclose($file);
			$file_content = stripslashes($file_content);
			echo "Preview:<br />".htmlspecialchars_decode($file_content)."<br />";
			echo "<br />Update Success";
			$post_title = str_replace(" ","_",$_POST['title']);
			$file_rename = FILE_ADD."{$_SESSION['author_id']}\\{$post_title}.txt";
			if(!rename($file_add,$file_rename))
			echo "<br />Unable to change file name";
		}
		else
		die("Update not successful".mysql_error());
	}
	else{
			echo "<br />Edit post:<br />";
		//insert data	
			echo "<form action='edit_post.php?post_id={$post_data['post_id']}&success=1' method='post'>
				  Title: &nbsp;<input type='text' name='title' value='{$post_data['title']}' size='24' /><br />
				  <input type='hidden' name='author' value='{$post_data['author_id']}' />
				  <input type='hidden' name='post_id' value='{$post_data['post_id']}' />
				  Channel: &nbsp;<select name='channel'>";
				 //generate channel list:
				 while($channel_set = mysql_fetch_array($channels))
				 		if($post_data['channel_id'] == $channel_set['channel_id'])
						echo "<option value='{$channel_set['channel_id']}' selected='selected' >{$channel_set['name']}</option>";
						else echo "<option value='{$channel_set['channel_id']}' >{$channel_set['name']}</option>";
						echo "</select><br />";
			echo "Content: &nbsp; <textarea name='content' rows='20' cols='80'>{$file_content}</textarea>
				  Status: &nbsp; <select name='visible'>
				  				 <option value='1'>Publish</option>
								 <option value='0'>Do Not Publish</option></select>&nbsp;";
			echo "Labels: &nbsp; <input type='text' value='{$post_data['labels']}' name='labels'/><br />
				  <input type='hidden' name='datetime' value='".time()."' />
				  <input type='submit' value='update' />";				
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