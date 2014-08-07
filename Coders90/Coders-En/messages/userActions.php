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
	session_save_path("../sessions/");
	session_start();
	$action=$_POST['action'];
	date_default_timezone_set("America/El_Salvador");
	include("../BDD.php");

	switch ($action) {
		
		case "sendMessage":
			$mdate=date("Y-m-d");
			$mhour=date("H:i:s");

			$userTo=$_POST['userTo'];
			$content=$_POST['contents'];
			
			$query="INSERT INTO messages values('','".$userTo."','".$_SESSION['UserID']."','".$content."','','".$mdate."','".$mhour."','0')";
			$sql=mysql_query($query,$dbconn);
			break;

		case "updateMessage":
			$userTo=$_POST['userTo'];
			
			$query="SELECT messages.*, users.Name, users.LastName FROM messages INNER JOIN users on users.UserID=messages.UserFrom WHERE messages.UserID = '".$_SESSION['UserID']."' AND messages.UserFrom ='".$userTo."' OR messages.UserID ='".$userTo."' AND messages.UserFrom ='".$_SESSION['UserID']."' ORDER BY Date ASC, Time ASC";
			$result=mysql_query($query,$dbconn);

			echo "<ul class='media-list chat-list'>";
			while ($row=mysql_fetch_array($result)) {
				if ($row[2]==$_SESSION['UserID']) {
					echo "<li class='media'>
							<a class='pull-right' href='../profile/?user=".$row[2]."'>
								<img style='border: solid 2px #3498DB;' class='media-object'  alt='User image' width='50px' height='50px'  src='../img/avatars/".$row[2].".jpg'>
							</a>
							<div class='pull-right media-body chat-pop mod'>
								<h4 class='media-heading'>Tú <span class='pull-left'><abbr class='timeago' title='".date("d/m/Y", strtotime($row[5])) ." at ".date("g:i a", strtotime($row[6]))."' >".strftime("%B %d",strtotime($row[5])) .", ".date("g:i a", strtotime($row[6]))."</abbr> <i class='fa fa-clock-o'></i></span></h4></h4>
								".$row[3]."
							</div>
						</li>";
					} else {
						echo "<li class='media'>
							<a class='pull-left' href='../profile/?user=".$row[2]."'>
								<img style='border: solid 2px #3498DB;' class='media-object' alt='User image'  width='50px' height='50px' src='../img/avatars/".$row[2].".jpg'>
							</a>
							<div class='media-body chat-pop'>
								<h4 class='media-heading'>".$row[8]." "."$row[9]"." "."<span class='pull-right'><i class='fa fa-clock-o'></i> <abbr class='timeago' title='".date("d/m/Y", strtotime($row[5])) ." at ".date("g:i a", strtotime($row[6]))."' >".strftime("%B %d",strtotime($row[5])) .", ".date("g:i a", strtotime($row[6]))."</abbr> </span></h4>
								<p>".$row[3]."</p>
							</div>
						</li>";
					}
				}

				echo "</ul>
						</div>";
			
			break;

		case "readState":
			
			$userTo=$_POST['userTo'];
			
			$query="UPDATE messages SET View='1' WHERE UserFrom='".$userTo."'";
			$sql=mysql_query($query,$dbconn);
			break;

		case "myFriends":
						
			$query="SELECT * FROM ((SELECT following.*, users.Name, users.LastName, following.FollowerID as identifier FROM following INNER JOIN users ON users.UserID=following.FollowerID WHERE following.UserID='".$_SESSION['UserID']."') UNION (SELECT following.*, users.Name, users.LastName, following.UserID as identifier  FROM following INNER JOIN users ON users.UserID=following.UserID WHERE following.FollowerID='".$_SESSION['UserID']."'))subTbl GROUP BY subTbl.identifier ";
			$sql=mysql_query($query,$dbconn);

			echo "<div class='divide-10'></div>";
			while ($row=mysql_fetch_array($sql)) {
				echo "
					<a href='../messages/?f=".$row[1]."' >
						<div class='ref-result'>
							<span><img src='../img/avatars/".$row[1].".jpg' class='img-result' height='30' width='30' onerror=\"this.src='../img/avatars/default.jpg'\"></span>
							<span>".$row[5]."  ".$row[6]."</span>
						</div>
					</a>";
				
				echo "<div class='divide-10'></div>";
			}

			break;

		case "search":

			$tag=$_POST['tag'];

			$query="SELECT * FROM (SELECT * FROM ((SELECT following.*, users.Name, users.LastName, users.Email, following.FollowerID as identifier FROM following INNER JOIN users ON users.UserID=following.FollowerID WHERE following.UserID='".$_SESSION['UserID']."' ) UNION (SELECT following.*, users.Name, users.LastName, users.Email, following.UserID as identifier  FROM following INNER JOIN users ON users.UserID=following.UserID WHERE following.FollowerID='".$_SESSION['UserID']."'))subTbl GROUP BY subTbl.identifier)follow WHERE follow.Name LIKE '%".$tag."%' OR follow.LastName LIKE '%".$tag."%' OR follow.Email LIKE '%".$tag."%'";
			$sql=mysql_query($query,$dbconn);
			$results=mysql_num_rows($sql);

			echo "<div class='divide-10'></div>";
			if ($results>0) {
				while ($row=mysql_fetch_array($sql)) {
					echo "
						<a href='../messages/?f=".$row[8]."' >
							<div class='ref-result'>
								<span><img src='../img/avatars/".$row[8].".jpg' class='img-result' height='30' width='30' onerror=\"this.src='../img/avatars/default.jpg'\"></span>
								<span>".$row[5]."  ".$row[6]."</span>
							</div>
						</a>";
					
					echo "<div class='divide-10'></div>";
				}
			} else {
				echo "<center><h5><i class='fa fa-frown-o'></i> There are no results </h5></center><div class='divide-10'></div>";
			}
			

			break;
			
	}

?>