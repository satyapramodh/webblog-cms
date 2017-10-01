<?php 
	require_once("include/header.php");
?>
<div id="body">
	<?php include_once("include/left_content.php"); ?>
    <div id="right_content">
        <div id="content">
        <?php 
			echo "Welcome {$_SESSION['author_name']}<br />";
        ?>
         </div>
    </div>
</div>
<!-- body ends -->
<?php 
	require_once("include/footer.php");
?>