<?php
	session_save_path("../sessions/");
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

		case "delUser":
			$idf=$_POST['idf'];
			$group=$_POST['group'];

			$query="DELETE FROM user_group WHERE UserID='".$idf."' AND GroupID='".$group."' LIMIT 10";
			$sql=mysql_query($query,$dbconn);
			break;

		case "searchUser":
			$tag=$_POST['tag'];
			
			$query="SELECT * FROM (SELECT * FROM ((SELECT following.*, users.Name, users.LastName, users.Email, following.FollowerID as identifier FROM following INNER JOIN users ON users.UserID=following.FollowerID WHERE following.UserID='".$_SESSION['UserID']."' ) UNION (SELECT following.*, users.Name, users.LastName, users.Email, following.UserID as identifier  FROM following INNER JOIN users ON users.UserID=following.UserID WHERE following.FollowerID='".$_SESSION['UserID']."'))subTbl GROUP BY subTbl.identifier)follow WHERE follow.Name LIKE '%".$tag."%' OR follow.LastName LIKE '%".$tag."%' OR follow.Email LIKE '%".$tag."%'";
			$sql=mysql_query($query,$dbconn);
			$results=mysql_num_rows($sql);
			$index=0;
			echo "<div class='divide-10'></div>";
			if ($results>0) {
				while ($row=mysql_fetch_array($sql)) {
					echo "<a class='styleLess' idf='".$row[8]."' n='".$row[5]."  ".$row[6]."'><div class='ref-result members' style='cursor: pointer;'>
							<span><img src='../img/avatars/".$row[8].".jpg' class='img-result' height='30' width='30' onerror=\"this.src='../img/avatars/default.jpg'\"></span>
							<span>".$row[5]."  ".$row[6]."</span>
						</div></a>";
				
					echo "<div class='divide-10'></div>";
					$index++;
				}
			} else {
				echo "<center><h5><i class='fa fa-frown-o'></i> No hay resultados</h5></center><div class='divide-10'></div>";
			}

			break;

		case "newMembers":
			$arrayMembers=$_POST['idf'];
			$group=$_POST['group'];

			foreach ($arrayMembers as $user ) {
				$sql="SELECT User_groupID FROM user_group WHERE UserID='".$user."'";
				$result=mysql_query($sql);
				$total=mysql_num_rows($result);

				if ($total==0) {
					$insertMember="INSERT INTO User_group VALUES ('','".$user."','".$group."')";
					$resultInsert=mysql_query($insertMember);
				} 				
			}			
			
			break;	
	}

?>