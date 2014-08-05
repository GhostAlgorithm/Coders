<?php
	session_start();
	$action=$_POST['action'];
	date_default_timezone_set("America/El_Salvador");
	include("../BDD.php");

	switch ($action) {
		case "create":
			$gdate=date("Y-m-d");
			$gName=$_POST['name'];
			$gContent=$_POST['content'];
			$gTheme=$_POST['theme'];
			
			$name=substr($_SESSION['UserID'], 15);
			$random=rand(0,9999999999);
			$randomcom=str_pad($random, 10, "0" ,STR_PAD_LEFT);
			$replace=substr_replace($randomcom,$name, 0);
			
			$gId=$name.$randomcom;

			include("../BDD.php");
			
			$query="INSERT INTO groups VALUES ('".$gId."','".$gName."','".$gContent."','".$_SESSION['UserID']."','".$gdate."','".$gTheme."')";
			$sql=mysql_query($query,$dbconn);

			$query="INSERT INTO user_group values ('','".$_SESSION['UserID']."','".$gId."')";
			$sql=mysql_query($query,$dbconn);

			mkdir("../editor/codefiles/groups/".$gId, 0777);
		case "join":
			$user=$_POST['user'];
			$group=$_POST['group'];

			$query="INSERT INTO user_group values ('','".$user."','".$group."')";
			$sql=mysql_query($query,$dbconn);
			break;

		case "leave":
			$user=$_POST['user'];
			$group=$_POST['group'];

			$query="DELETE FROM user_group WHERE UserID='".$user."' AND GroupID='".$group."'";
			$sql=mysql_query($query,$dbconn);
			break;

		case "postComment":
			$cdate=date("Y-m-d");
			$chour=date("H:i:s");

			$content=$_POST['contents'];
			$postIdf=$_POST['postidf'];

			$query="INSERT INTO postcomments_group values('','".$_SESSION['UserID']."','".$postIdf."','".$content."','".$cdate."','".$chour."','1')";
			$sql=mysql_query($query,$dbconn);
			break;

		case "delComment":
			$idf=$_POST['idf'];

			$query="UPDATE postcomments_group SET View='0' WHERE CommentID='".$idf."' LIMIT 1";
			$sql=mysql_query($query,$dbconn);
			break;

		case "delPost":
			$idf=$_POST['idf'];

			$query="UPDATE post_group SET View='0' WHERE PostID='".$idf."' LIMIT 1";
			$sql=mysql_query($query,$dbconn);
			break;
		
	}

?>