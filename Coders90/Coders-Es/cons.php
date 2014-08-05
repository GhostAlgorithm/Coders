<?php
	session_save_path("sessions/");
	session_start();
	$comp=$_GET['vineta'];
	include("BDD.php");  		

	$query="SELECT * FROM users WHERE Name LIKE '".$comp."%' OR LastName LIKE '".$comp."%' OR Email LIKE '".$comp."%' LIMIT 10";
	$sql=mysql_query($query,$dbconn);

	echo "<div class='divide-10'></div>";
	while($row = mysql_fetch_array($sql)){
		echo "
			<a href='../profile/?user=".$row['UserID']."' class='styleLess'>
				<div class='ref-result'>
					<span><img src='../img/avatars/".$row['UserID'].".jpg' class='img-result' height='30' width='30' onerror=\"this.src='../img/avatars/default.jpg'\"></span>
					<span>".$row['Name']."  ".$row['LastName']."</span>
				</div>
			</a>";
		
		echo "<div class='divide-10'></div>";
	}

	echo "<center><h6 id='AllResults' style='cursor:pointer;'>Todos los resultados <i class='fa fa-arrow-circle-right'></i></h6></center>";
?>	
	