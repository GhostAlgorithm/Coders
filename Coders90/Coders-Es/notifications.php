<?php 
session_save_path("sessions/");
session_start();

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set("America/El_Salvador");

function groupName($idf){
	include("BDD.php");
	$singleQuery="SELECT Name FROM groups WHERE GroupID='".$idf."' LIMIT 1";
	$singleResult=mysql_query($singleQuery,$dbconn);

	while ($singleRow=mysql_fetch_array($singleResult)) {
		$name=$singleRow[0];
	}

	return $name;
}

function notifList(){
	include("BDD.php");

	$query="SELECT notifications.*, users.Name, users.LastName FROM notifications INNER JOIN users ON users.UserID=notifications.User WHERE notifications.UserID='".$_SESSION['UserID']."' AND View='0' ORDER BY Date DESC, TIME DESC";
	$result=mysql_query($query,$dbconn);

	while ($row=mysql_fetch_array($result)) {
		$type=$row[6];
		switch ($type) {
			case '1':
				echo "<li>
						<a href='#'>
							<span class='label label-success'><i class='fa fa-comment'></i></span>
							<span class='body'>
								<span class='message'>".$row[8]." ".$row[9]." ha comentado tu publicacion </span>
							</span>
						</a>
					</li>";
				break;
			
			case '2':
				echo "<li>
						<a href='#'>
							<span class='label label-info'><i class='fa fa-edit'></i></span>
							<span class='body'>
								<span class='message'>".$row[8]." ".$row[9]." ha publicado en ".groupName($row[7])."</span>
							</span>
						</a>
					</li>";
				break;

			case '3':
				$sql="SELECT GroupID FROM post_group WHERE PostID='".$row[7]."' LIMIT 1";
				$resSql=mysql_query($sql,$dbconn);
				while ($rowSQL=mysql_fetch_array($resSql)) {
					$gID=$rowSQL[0];
				}
				echo "<li>
						<a href='#'>
							<span class='label label-warning'><i class='fa fa-comments'></i></span>
							<span class='body'>
								<span class='message'>".$row[8]." ".$row[9]." ha comentado tu post en ".groupName($gID)."</span>
							</span>
						</a>
					</li>";
				break;

			case '4':
				echo "<li>
						<a href='#'>
							<span class='label label-danger'><i class='fa fa-file-o'></i></span>
							<span class='body'>
								<span class='message'>".$row[8]." ".$row[9]." ha subido un archivo en ".groupName($row[7])."</span>
							</span>
						</a>
					</li>";
				break;
			
			case '5':
				$total=explode("-", $row[7]);

				if ($total[1]=='1') {
					echo "<li>
						<a href='#'>
							<span class='label label-info'><i class='fa fa-users'></i></span>
							<span class='body'>
								<span class='message'>".$row[8]." ".$row[9]." agrego ".$total[1]." miembro en ".groupName($total[0])."</span>
							</span>
						</a>
					</li>";
				} else {
					echo "<li>
						<a href='#'>
							<span class='label label-info'><i class='fa fa-users'></i></span>
							<span class='body'>
								<span class='message'>".$row[8]." ".$row[9]." agrego ".$total[1]." miembros en ".groupName($total[0])."</span>
							</span>
						</a>
					</li>";
				}
				
				break;
				
			case '6':
				echo "<li>
						<a href='#'>
							<span class='label label-success'><i class='fa fa-user'></i></span>
							<span class='body'>
								<span class='message'>".$row[8]." ".$row[9]." ahora te sigue</span>
							</span>
						</a>
					</li>";
				break;		
		}
	}
}
?>