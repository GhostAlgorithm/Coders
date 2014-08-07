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
	error_reporting(0);
	if(isset($_SESSION['UserID'])){
		header('Location: dashboard/');
	}
	
	if(isset($_POST['LogIn'])){
		include("BDD.php");
		$usermail=trim($_POST['User']);
		$userpass=hash('sha256',trim($_POST['Pass']));
		
		$logquery="Select * FROM users WHERE email='".$usermail."'";
		
		$result=mysql_query($logquery,$dbconn);

		while ($row1=mysql_fetch_array($result)) {
			$block=$row1[8];
		}

		$num=mysql_num_rows($result);
		
		if ($num>0) {
			if($block=="0"){
				mysql_free_result($result);
				$result=mysql_query($logquery,$dbconn);
				while ($row=mysql_fetch_array($result)) {
					session_start();
					$_SESSION['UserID']=$row[0];
					$_SESSION['UserName']=$row[1];
					$_SESSION['UserLast']=$row[2];
					$_SESSION['UserEmail']=$row[3];
					$_SESSION['Admin']=$row[7];
					$ipass=$row[4];
				}	
				 
				if ($userpass==$ipass){
					if ($_SESSION['Admin']=="1") {
						header('Location: admin/dashboard/');
					} else {
						header('Location: dashboard/');
					}
				
				} else {
					session_destroy();
					echo"<div class='alert alert-warning'>Invalid Password</div>";
				}

			} else {
				session_destroy();
				echo"<div class='alert alert-warning'>Your account has been blocked</div>";
			}	
		} else {
			session_destroy();
			echo"<div class='alert alert-warning'>This Email is not registered</div>";
		}
	}
	
?>

<!DOCTYPE HTML>
<html lang="en">
		<head>
			<title>Welcome to Coders!</title>
			<!--Bootstrap / css / fonts-->
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">		
			<link rel="stylesheet" type="text/css" href="css/style.css" >
			<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.css"/>
			<link rel="stylesheet" type="text/css" href="common/css/main.css"/>
			<!--SEO / Responsive-->
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="shortcut icon" href="common/img/favicon.png" />
		</head>
	<body>
	<div class="row">
		<div class="col-sm-4">
	</div>
		<div class="col-sm-4">
		<form Method="POST" action="index.php">
			<h1 align="center">Sign In!</h1>
			<div class="panel panel-default">
			   <div class="panel-heading">
		      	  <div class="panel-body">
		      	  	<h4>Email:</h4>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
						<input type="email" class="form-control" placeholder="mail@domain.com" name="User" required/>
					</div>
					<h4>Password:</h4>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-key"></i></span>
						<input type="password" class="form-control" placeholder="**********" name="Pass" required/>
					</div>
					<br>
					<button class="btn btn-lg btn-success btn-block" type="submit" name="LogIn">Log In</button>
					<br>
					<center><button class="btn btn-lg btn-danger" type="submit">Go back</button> 
					<a href="registro/"><button class="btn btn-lg btn-warning" type="button">Sign Up</button></a></center>
			       </div>
		      </div>
		</div>
	</form>
  	</div>


	<!--JQuery & JS bootstrap -->
	 <script src="common/js/jquery.min.js"></script>
	<script src="common/js/jquery-1.10.2.min.js"></script>
	<script src="common/js/bootstrap.min.js"></script>
	<script src="common/js/scroll.js"></script>
</body>
<!--Todos los derechos reservados 2014 El Salvador - Fernando Santamaría y Christian Zayas-->
</html>
