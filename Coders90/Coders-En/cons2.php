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
	$comp=$_GET['vineta'];
	include("BDD.php");  		

	$query="SELECT * FROM users WHERE Name LIKE '".$comp."%' OR LastName LIKE '".trim($comp)."%' OR Email LIKE '".trim($comp)."%' LIMIT 10";
	$sql=mysql_query($query,$dbconn);

	echo "<div class='divide-10'></div>";
	while($row = mysql_fetch_array($sql)){
			echo "
			<a href='actions.php?user=".$row['UserID']."' >
				<div class='ref-result'>
					<span><img src='../../img/avatars/".$row['UserID'].".jpg' class='img-result' height='30' width='30' onerror=\"this.src='../../img/avatars/default.jpg'\"></span>
					<span>".$row['Name']."  ".$row['LastName']."</span>
				</div>
			</a>";
		
		echo "<div class='divide-10'></div>";
	}
?>	
	