<?php
	session_start();
	$comp=trim($_GET['vineta']);
	include("BDD.php");  		

	$query="SELECT * FROM groups WHERE Name LIKE '".$comp."%' OR Name LIKE '%".trim($comp)."' OR Name LIKE '%".trim($comp)."%' OR Content LIKE '".$comp."%' OR Content LIKE '%".trim($comp)."' OR Content LIKE '%".trim($comp)."%' LIMIT 10";
	$sql=mysql_query($query,$dbconn);

	echo "<div class='divide-10'></div>";
	while($row = mysql_fetch_array($sql)){
			echo "
			<div class='container-search''>
				<a href='dashboard.php?group=".$row['GroupID']."'>
					<div class='ref-result search-result'>
						<span>".$row['Name']."</span>
						<div class='pull-right search-group' style='background-color: #".$row['Color']."; border-color: #".$row['Color'].";'>".$row['Content']."</div>
					</div>
				</a>
			</div>";
		
		echo "<div class='divide-10'></div>";
	}
?>	
	