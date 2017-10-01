<?php 
	require_once("include/functions.php");
	require_once("include/header.php");
?>
<div id="body">
	<?php include_once("include/left_content.php") ?>
    <div id="right_content">
    	<div id="content">
        My Posts: <br /><br />
        <a href="create_post.php">Create Post</a><br /><br />
        <?php
			//perform query
			//del post
			if(isset($_GET['pub'])){
				$stat_update = mysql_query("UPDATE posts set visible = '1' where post_id = '{$_GET['pub']}'");
				if($stat_update) echo "Post Published"; else "Post Publishing Error";
			}
			if(isset($_GET['unpub'])){
				$stat_update = mysql_query("UPDATE posts set visible = '0' where post_id = '{$_GET['unpub']}'");
				if($stat_update) echo "Post Unpublished"; else "Post Unpublishing Error";
			}
			if(isset($_GET['del_post_id'])){
				$file_data = mysql_query("SELECT * FROM posts WHERE post_id = {$_GET['del_post_id']}");
				$file_data = mysql_fetch_array($file_data);
				$file_name = str_replace(" ", "_", $file_data['title']); 
				$file_name = FILE_ADD."{$_SESSION['author_id']}\\{$file_name}.txt";
				$del_post = mysql_query("DELETE FROM posts where post_id = {$_GET['del_post_id']}");
				$update_channel_data = mysql_query("UPDATE channels SET numOfPosts = numOfPosts - 1 WHERE channel_id = '{$_GET['channel_id']}'");
				if($del_post AND unlink($file_name)) echo "Delete Successful";
				else echo "Deleting post failed. Please <a href='my_posts.php'>retry</a><br />.";
			}
			else{
				//fetch posts
				$my_posts = mysql_query("SELECT * FROM posts
										WHERE author_id = '{$_SESSION['author_id']}'
										ORDER BY datetime ASC;
										");	
				$n = mysql_num_rows($my_posts);
				if($n==0) echo "No posts yet.";
				else{		
					echo "<table border='1'><tr><th>S.No</th><th>Title</th><th>Author</th><th>Channel</th><th>Ratings</th><th>Published</th><th>Edit</th><th>Delete</th></tr>";												
					while($my_posts_set = mysql_fetch_array($my_posts)){
						echo "<tr><td>{$my_posts_set['post_id']}</td>
								 <td>{$my_posts_set['title']}</td>";
						 //get author and channel data for each table row
						$channel = mysql_query("SELECT * FROM channels
											WHERE channel_id = '{$my_posts_set['channel_id']}'");
						$author = mysql_query("SELECT * FROM authors
											WHERE author_id = '{$my_posts_set['author_id']}'");
						$channel_set = mysql_fetch_array($channel);
						$author_set = mysql_fetch_array($author);
						
						echo "<td>{$author_set['author_name']}</td>
								 <td>{$channel_set['name']}</td>
								 <td>{$my_posts_set['rating']} Stars</td>
								 <td>";
						if($my_posts_set['visible']) echo "<a href='my_posts.php?unpub={$my_posts_set['post_id']}'>Unpublish</a>";
						else echo "<a href='my_posts.php?pub={$my_posts_set['post_id']}'>Publish</a>";
								 echo"</td><td><a href='edit_post.php?auth_id={$my_posts_set['author_id']}&chan_id={$my_posts_set['channel_id']}&post_id={$my_posts_set['post_id']}' >Edit</a></td>
				<td><a href='my_posts.php?del_post_id={$my_posts_set['post_id']}&channel_id={$my_posts_set['channel_id']}'>Delete</a></td></tr>";
					}
				}
			echo "</table>";
		}
		?>
        </div>
    </div>
</div>
<!-- body ends -->
<?php 
	require_once("include/footer.php");
?>