<?php
	session_start();
	$action=$_POST['action'];
	date_default_timezone_set("America/El_Salvador");
	include("../BDD.php");

	switch ($action) {
		
		case "postComment":
			$cdate=date("Y-m-d");
			$chour=date("H:i:s");

			$content=$_POST['contents'];
			$postIdf=$_POST['postidf'];


			$query="INSERT INTO postcomments values('','".$_SESSION['UserID']."','".$content."','1','".$cdate."','".$chour."','".$postIdf."')";
			$sql=mysql_query($query,$dbconn);
			break;

		case "delComment":
			$idf=$_POST['idf'];

			$query="UPDATE postcomments SET View='0' WHERE CommentID='".$idf."' LIMIT 1";
			$sql=mysql_query($query,$dbconn);
			break;

		case "delPost":
			$idf=$_POST['idf'];
			
			$query="UPDATE post SET View='0' WHERE PostID='".$idf."' LIMIT 1";
			$sql=mysql_query($query,$dbconn);
			break;
		
		case "follow":
			$idf=$_POST['idf'];
			
			$query="INSERT INTO following VALUES ('','".$idf."','".$_SESSION['UserID']."','1','1')";
			$sql=mysql_query($query,$dbconn);
			break;

		case "unfollow":
			$idf=$_POST['idf'];
			
			$query="DELETE FROM following WHERE UserID='".$idf."' AND FollowerID='".$_SESSION['UserID']."'";
			$sql=mysql_query($query,$dbconn);
			break;
	}

?>