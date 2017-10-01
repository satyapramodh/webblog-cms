<?php 
	require_once("include/functions.php");
	require_once("include/header.php");
?>
<div id="body">
<?php 
	include_once("include/left_content.php");
?>
<div id="right_content">
<?php
	//channel rename
	if(isset($_GET['rename'])){
		$rename = " ";
		$name_update = mysql_query("UPDATE channels set name = '{$rename}' where channel_id = '{$_GET['rename']}'");
				if($name_update) echo "Renamed Successfully"; else echo "Renamed Unsuccessfull";
	}
	//channel visiblity
	if(isset($_GET['pub'])){
				$stat_update = mysql_query("UPDATE channels set visible = '1' where channel_id = '{$_GET['pub']}'");
				if($stat_update) echo "Channel Published"; else echo "Channel Publishing Error";
			}
			if(isset($_GET['unpub'])){
				$stat_update = mysql_query("UPDATE channels set visible = '0' where channel_id = '{$_GET['unpub']}'");
				if($stat_update) echo "Channel Unpublished"; else echo "Channel Unpublishing Error";
			}
	//delete channel
	if(isset($_GET['del_chanID'])){
		$del_success = mysql_query("DELETE FROM channels WHERE channel_id = {$_GET['del_chanID']}");
		if($del_success) echo "Channel deleted successfully<br />";
	}
	//admin privilige add channel
	if($_SESSION['admin']==1){
	//add channel
	//perform query
		//check if channel is set
		if(isset($_POST["channel"])){
			$channel = $_POST["channel"];
			//$channel = str_replace(" ","_",$channel);
			$channel = ucfirst($channel);	
		}
		
		if(isset($channel)){
				//search for 'element' in 'sqltable' under 'column id', return value zero if no and +ve num for yes
				if(Search_Table_For_Element($channel,'channels','name')){
					echo "\"{$channel}\" Channel already exists.<br />";
				}
				else{  
				//create channel in channels list
				if(mysql_query("INSERT INTO channels(name,channel_id,author_id,numOfPosts,visible)
						VALUES('$channel',NULL,{$_SESSION['author_id']},0,1)
						")){echo "Success<br />";}
						else echo "Failed trying to add channel";
		
				if(isset($_POST["channel"])){
					echo("\"{$channel}\" Channel added.");
				}
				}
		}
	}
	else{
		echo "<b>Note:</b> Only Admins can create channels<br />";
	}
?>	
    <div id="content">
    <?php
	if($_SESSION['admin']==1){
    echo "<form method='post' action='channels.php'>
        Add Channel: &nbsp;
        <input type='text' name='channel'  />
        &nbsp;&nbsp;&nbsp;
        <input type='submit' value='Add' />
    </form>";
	}
		//list channels and their posts
			$channellist = mysql_query("SELECT * FROM channels");
			if(!$channellist){
				die("Database connection error".mysql_error());
			}
			//channel details
			echo "<table border='1'><tr><th>ID</th><th>Channel Name</th><th>Posts</th><th>Visible</th><th>Rename</th>";
			if($_SESSION['admin']==1){ echo "<th>Delete</th>"; }
			echo "</tr>";
			while($channel_data = mysql_fetch_array($channellist)){
				echo "<tr><td>{$channel_data['channel_id']}</td><td>{$channel_data['name']}</td><td>{$channel_data['numOfPosts']}</td><td>";
				if($channel_data['visible']) echo "<a href='channels.php?unpub={$channel_data['channel_id']}'>Unpublish</a>";
				else echo "<a href='channels.php?pub={$channel_data['channel_id']}'>Publish</a>";
				echo "</td><td><a href='channels.php?rename={$channel_data['channel_id']}'>Rename</a></td>";
				if($_SESSION['admin']==1){ echo "<td><a href='channels.php?del_chanID={$channel_data['channel_id']}'>Delete</a></td>"; } 
				echo "</tr>";
			}
			echo "</table>";
	?>
    </div>
</div>
<!--right content ends-->
</div>
<!--body ends-->
<?php 
require_once("include/footer.php");
?>

