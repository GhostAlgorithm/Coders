<?php 
	session_save_path("sessions/");
	session_start();
	date_default_timezone_set("America/El_Salvador");
	include("BDD.php");

	$action=$_POST['action'];

	switch ($action) {
		case "View":
			$idf = $_POST['idf'];
			$query="UPDATE notifications SET View='1' WHERE NotifID='".$idf."' LIMIT 1";
			$result=mysql_query($query,$dbconn);
			break;
	}
?>