<!--                Copyright (c) 2014 
José Fernando Flores Santamaría <fer.santamaria@programmer.net>
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>.
-->
<?php 
session_save_path("sessions/");
session_start();

setlocale(LC_ALL,"US");
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
								<span class='message'>".$row[8]." ".$row[9]." commented your post </span>
							</span>
						</a>
					</li>";
				break;
			
			case '2':
				echo "<li>
						<a href='#'>
							<span class='label label-info'><i class='fa fa-edit'></i></span>
							<span class='body'>
								<span class='message'>".$row[8]." ".$row[9]." posted in ".groupName($row[7])."</span>
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
								<span class='message'>".$row[8]." ".$row[9]." commented your post in ".groupName($gID)."</span>
							</span>
						</a>
					</li>";
				break;

			case '4':
				echo "<li>
						<a href='#'>
							<span class='label label-danger'><i class='fa fa-file-o'></i></span>
							<span class='body'>
								<span class='message'>".$row[8]." ".$row[9]." uploaded a file in ".groupName($row[7])."</span>
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
								<span class='message'>".$row[8]." ".$row[9]." add ".$total[1]." member in ".groupName($total[0])."</span>
							</span>
						</a>
					</li>";
				} else {
					echo "<li>
						<a href='#'>
							<span class='label label-info'><i class='fa fa-users'></i></span>
							<span class='body'>
								<span class='message'>".$row[8]." ".$row[9]." add ".$total[1]." members in ".groupName($total[0])."</span>
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
								<span class='message'>".$row[8]." ".$row[9]." is following you!</span>
							</span>
						</a>
					</li>";
				break;		
		}
	}
}
?>