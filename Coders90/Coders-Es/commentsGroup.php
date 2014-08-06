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
	$idf=$_GET['vineta'];
	$parts=explode("-", $idf);
	include("BDD.php");
	$query="SELECT postcomments_group.*, users.Name, users.LastName, post_group.UserID, post_group.GroupID FROM postcomments_group INNER JOIN users ON users.UserID = postcomments_group.UserID INNER JOIN post_group ON postcomments_group.PostID = post_group.PostID WHERE postcomments_group.PostID='".$parts[0]."' AND  postcomments_group.View='1' ORDER BY Date ASC , Time ASC";
	$sql=mysql_query($query,$dbconn);

	echo "<div class='divide-20'></div>";
	while($row = mysql_fetch_array($sql)){
		$userIdf="".$_SESSION['UserID'];	
		
		if ($userIdf==$row[1]) {
			echo "<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
						<span>
							<div class='adjust-img'>
								<img class='img-perfil' src='../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
							</div>
							<div class='col-xs-12 col-md-12'>
								<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
									<pre><a style='text-decoration: none;' href='../profile/index.php?user=".$row[1]."'><h5 class='comment-name' >"."  ".$row[7]." ".$row[8]."</a></h5><span class='pull-right comment-time'><i class='fa fa-clock-o'></i> ".strftime("%d de %B",strtotime($row[4])) .", ".date("g:i a", strtotime($row[5]))." "."<i class='fa fa-times-circle delete-comment' title='Eliminar comentario' idf='".$row[0]."' post-idf='".$row[2]."' onClick='delComment(this)'></i></span>".htmlentities($row[3],ENT_NOQUOTES,"UTF-8")."</pre>
								</div>
							</div>
						</span>
					</div>
					<div class='divide-15'></div>";
		} else {
			if ($_SESSION['UserID']==$row[9]) {
				echo "<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
						<span>
							<div class='adjust-img'>
								<img class='img-perfil' src='../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
							</div>
							<div class='col-xs-12 col-md-12'>
								<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
									<pre><a style='text-decoration: none;' href='../profile/index.php?user=".$row[1]."'><h5 class='comment-name' >"."  ".$row[7]." ".$row[8]."</a></h5><span class='pull-right comment-time'><i class='fa fa-clock-o'></i> ".strftime("%d de %B",strtotime($row[4])) .", ".date("g:i a", strtotime($row[5]))." "."<i class='fa fa-times-circle delete-comment' title='Eliminar comentario' idf='".$row[0]."' post-idf='".$row[2]."' onClick='delComment(this)'></i></span>".htmlentities($row[3],ENT_NOQUOTES,"UTF-8")."</pre>
								</div>
							</div>
						</span>
					</div>
					<div class='divide-15'></div>";
			} else {
				echo "<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
						<span>
							<div class='adjust-img'>
								<img class='img-perfil' src='../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
							</div>
							<div class='col-xs-12 col-md-12'>
								<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
									<pre><a style='text-decoration: none;' href='../profile/index.php?user=".$row[1]."'><h5 class='comment-name' >"."  ".$row[7]." ".$row[8]."</a></h5><span class='pull-right comment-time'><i class='fa fa-clock-o'></i> ".strftime("%d de %B",strtotime($row[4])) .", ".date("g:i a", strtotime($row[5]))."</span>".htmlentities($row[3],ENT_NOQUOTES,"UTF-8")."</pre>
								</div>
							</div>
						</span>
					</div>";
			}
		}
	}

	require("SQLFunc.php");

	if (partOfComments($parts[1])) {
		echo "<div class='divide-15'></div>
			<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
			<span>
				<div class='adjust-img'>
					<img class='img-perfil' src='../img/avatars/".$_SESSION['UserID'].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
				</div>
				<div class='col-xs-10 col-md-11'>
					<div class='col-xs-12 col-md-12'>
						<textarea style='padding: 1em;' class='comment-area ".$parts[0]."' placeholder='Escribe un comentario...'></textarea>
						<div class='divide-10'></div>
					</div>
				</div>
				<div class='col-xs-1 col-md-1'>
					<div class='col-xs-12 col-md-12'>
						<button class='btn btn-primary comment-btn' idf='".$parts[0]."' idf-group='".$parts[0]."-".$parts[1]."' style='margin-left:-4.2em; margin-top:0em; height:3.7em;' onClick='postComment(this)' onKeyDown='enterPress(this)'>Post</button>
					</div>
				</div>
			</span>
		</div>";
	}

?>

