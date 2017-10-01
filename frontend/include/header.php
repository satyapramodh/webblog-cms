<?php require_once("include/connection.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Frontend Web Blog</title>
<link type="text/css" rel="stylesheet" href="css/style.css" />
</head>

<body>

<div id="header">
  <div class="container">
    <div id="header_content">
	  <div id="logo"><a href="#">Webblog Logo</a></div>
        <div id="channel_menu">
			<?php 
               $channel_data = mysql_query("SELECT * FROM channels");
               echo "<ul>";
               while($channel_list = mysql_fetch_array($channel_data))
                  echo "<li><a href='#'>{$channel_list['name']}</a></li>";
               echo "</ul>";
            ?>
        </div>
     </div>
  </div>
</div>
<div style="clear:both"></div>