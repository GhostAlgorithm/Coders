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
	session_start();
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
	include("../BDD.php");
	$query="SELECT sub.UserFrom, users.Name, users.LastName FROM (SELECT messages.*, users.Name, users.LastName FROM messages INNER JOIN users ON users.UserID=messages.UserFrom Where messages.UserID='".$_SESSION['UserID']."' ORDER BY messages.Date DESC, messages.Time DESC Limit 5 )sub INNER JOIN users ON users.UserID=sub.UserFrom GROUP BY sub.UserFrom";
	$result=mysql_query($query,$dbconn);
	
	while($row=mysql_fetch_array($result)){

		$lastMessage="(SELECT messages.* FROM messages WHERE UserID='".$_SESSION['UserID']."' AND UserFrom='".$row[0]."') UNION (SELECT messages.* FROM messages WHERE UserID='".$row[0]."' AND UserFrom='".$_SESSION['UserID']."') ORDER BY Date DESC, Time DESC LIMIT 1";
		$resultLast=mysql_query($lastMessage,$dbconn);

		while($rowLast=mysql_fetch_array($resultLast)){

			if (strlen($rowLast[3])>40) {
				$content=substr($rowLast[3], 0,40)." ...";
			} else {
				$content=$rowLast[3];
			}

			echo "<li>
				<a href='../messages/?f=".$row[0]."'>
					<img src='../img/avatars/".$row[0].".jpg' alt='' onerror='this.src='../img/avatars/default.jpg''/>
					<span class='body'>
						<span class='from'>".$row[1]." ".$row[2]."</span>
						<span class='message' style='word-break:break-all;'>
						".$content."
						</span> 
						<span class='time'>
							<i class='fa fa-clock-o'></i>
							<span>".strftime("%d de %B",strtotime($rowLast[5])).", ".date("g:i a", strtotime($rowLast[6]))."</span>
						</span>
					</span>
					 
				</a>
			</li>";
		}

	}

	echo "	<li class='footer'>
				<a href='#'>Todos los mensajes<i class='fa fa-arrow-circle-right'></i></a>
			</li>
			</ul>
		</li>";


	mysql_close();
?>