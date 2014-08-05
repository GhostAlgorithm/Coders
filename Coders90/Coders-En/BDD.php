<?php 
	$dbconn=mysql_connect("localhost", "root", "codersv");
	mysql_select_db("coders",$dbconn) OR DIE ("There is an error connecting with the databse try again :(	");
?>