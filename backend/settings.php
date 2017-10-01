<?php 
	require_once("include/functions.php");
	require_once("include/header.php");
?>
<div id="body">
	<?php include_once("include/left_content.php") ?>
    <div id="right_content">
    	<div id="content">
        Settings:<br />
        Members:<br />
        <?php
			//perform query
			$author = mysql_query("SELECT * FROM authors
								WHERE author_id ='{$_SESSION['author_id']}'");
			$result = mysql_fetch_array($author);
			if(isset($_GET['change_pass'])==1){
				if(isset($_GET['up_pass'])==1){
					//chk passwords
					if($result['password']==$_POST['old_pass'] && $_POST['new_pass'] == $_POST['new_pass_confirm']){
						$success = mysql_query("UPDATE authors
									SET password = '{$_POST['new_pass']}'
									WHERE author_id = '{$_SESSION['author_id']}' ");
									
						if($success){ echo "Password changed successfully.<br />"; }
					}
						else echo "Password changing failed. Please <a href='settings.php?change_pass=1'>retry</a>";
				}
				else{	
				echo "Change your password.";
				echo "<form method='post' action='settings.php?change_pass=1&up_pass=1'>
					  Old Password: <input type='password' name='old_pass' /><br /><br />
					  New password: <input type='password' name='new_pass' /><br /><br />
					  Re-type passwrod: <input type='password' name='new_pass_confirm' /><br />
					  <input type='submit' value='update' /></form>";
				}
			}
			elseif(isset($_GET['del_acc'])==1){
				if(isset($_GET['del_confirm'])==1){
					echo $_SESSION['author_id']." <br />";
					  $success= mysql_query("DELETE FROM authors
											 WHERE author_id='{$_SESSION['author_id']}'");
					if($success) {
						echo "Deletion Successful";
						session_destroy();
						header("Location: login.php");
					}
					else echo "Deletion Unsuccessful";
				}
				else{
				echo "Are you sure you want to delete your account?
					  <a href='settings.php?del_acc=1&del_confirm=1'><button>Yes</button></a>&nbsp;
					  <a href='settings.php'><button>No</button></a>";
				}
			}
			elseif(isset($_GET['del_other_acc'])==1 && $_SESSION["admin"]==1){
				if(isset($_GET['del_confirm'])==1){
					  $success= mysql_query("DELETE FROM authors
											 WHERE author_id='{$_GET['id']}'");
					if($success) {
						echo "Deletion Successful of Author ID {$_GET['id']}";
					}
					else echo "Deletion Unsuccessful";
				}
				else{
				echo" Delete one of the following accounts";
				echo "<table border='1'><tr><th>Author ID</th><th>Username</th><th>Name</th><th>Delete</th></tr>";
				$author_data = mysql_query("SELECT * FROM authors");
				while($author_list = mysql_fetch_array($author_data)){
					echo "<tr><td>{$author_list['author_id']}<td>{$author_list['username']}</td><td>{$author_list['author_name']}</td>";
					echo "<td><a href='settings.php?del_other_acc=1&del_confirm=1&id={$author_list['author_id']}'>Delete</a></td></tr>";
				}
				echo "</table>";
			}
			}
			else{
				//settings menu
				
				if($result["admin"]==0){
					echo $result["author_name"] . " is not an admin<br />";
					echo "<a href='settings.php?change_pass=1' >Change Password</a><br /><a href='settings.php?del_acc=1' >Delete account</a><br />";
				}
				else{
					echo $result["author_name"]." is an admin<br />";
					echo "<a href='settings.php?change_pass=1' >Change Password</a><br /><a href='settings.php?del_acc=1' >Delete account</a><br />";
					echo "<a href='settings.php?del_other_acc=1' >Delete other accounts</a><br />";
				}
			}
		?>
        </div>
    </div>
</div>
<!-- body ends -->
<?php 
	require_once("include/footer.php");
?>