<?php
	session_save_path("../sessions/");
	session_start();
	$action=$_POST['action'];
	date_default_timezone_set("America/El_Salvador");
	include("../BDD.php");

	switch ($action) {
		
		case "delFile":
			$idf=$_POST['idf'];
			
			$path="../editor/codefiles/".$_SESSION['UserID']."/".$idf."";

			unlink($path);		
	}

?>