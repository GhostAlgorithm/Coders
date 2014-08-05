<?php
	session_save_path("sessions/");
	session_start();
	date_default_timezone_set("America/El_Salvador");
	$cdate=date("Y-m-d");
	$chour=date("H:i:s");

	$content=$_POST['contents'];
	$postIdf=$_POST['postidf'];	

	include("../BDD.php"); 

	$query="INSERT INTO postcomments values('','".$_SESSION['UserID']."','".$content."','1','".$cdate."','".$chour."','".$postIdf."')";
	$sql=mysql_query($query,$dbconn);
?>