<?php 
	$dbconn=mysql_connect("localhost", "root", "");
	mysql_select_db("coders",$dbconn) OR DIE ("Error: No es posible establecer la conexión con la base de datos");
?>