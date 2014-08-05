<?php
	$action=$_POST['action'];
	date_default_timezone_set("America/El_Salvador");
	include("../BDD.php");

	switch ($action) {
		
		case "mail":
			$email=$_POST['mail'];
			$query="SELECT EMail from Users WHERE Email='".$email."'";
			$sql=mysql_query($query,$dbconn);
			$val=mysql_num_rows($sql);

			if ($val>0) {
				echo "true";
			} else {
				echo "false";
			}
		break;		
	}

?>