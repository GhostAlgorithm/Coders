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
	session_save_path("../../sessions/");
	session_start();
	if(!isset($_SESSION['UserID']) && $_SESSION['Admin']!="1"){
		header('Location: ../../');
	} elseif ($_SESSION['Admin']!="1") {
		header('Location: ../../dashboard/');
	}

	include("../../BDD.php");
		$query="SELECT * FROM users WHERE UserID='".$_GET['user']."'";
		$result=mysql_query($query,$dbconn);

		while ($row=mysql_fetch_array($result)) {
			$fn=$row[1];
			$ln=$row[2];	
			$mail=$row[3];
			$pass=$row[4];
			$bdate=$row[5];
			$admin=$row[7];
			$block=$row[8];
		}

	if(isset($_POST["EditData"])){
		include("../../BDD.php");
		$fn=trim($_POST["FirstName"]);
		$ln=trim($_POST["LastName"]);
		$mail=trim($_POST["Mail"]);
		$bdate=$_POST["BDate"];
		$pass=hash('sha256',trim($_POST["Pass"]));

		if(isset($_POST['Pass'])){
			$editdata="Update users SET Name='".$fn."', LastName='".$ln."', Pass='".$pass."', BirthDate='".$bdate."' WHERE UserID='".$_GET['user']."'";
		} else {
			$editdata="Update users SET Name='".$fn."', LastName='".$ln."', BirthDate='".$bdate."' WHERE UserID='".$_GET['user']."'";
		}
			
		$result=mysql_query($editdata,$dbconn);

		if ($result) {
			header("Location: ../users/actions.php?user=".$_GET['user']."&chg=1");
		} else {
			header("Location: ../users/actions.php?user=".$_GET['user']."&chg=0");
		}

	}

	if(isset($_POST["editRole"])){
		include("../../BDD.php");

		if (isset($_POST["blockUser"])) {
			$block ="1";
		} else {
			$block ="0";
		}

		if (isset($_POST["newAdmin"])) {
			$admin ="1";
		} else {
			$admin ="0";
		}
		
		$editdata="Update users SET  Admin='".$admin."', Block='".$block."' WHERE UserID='".$_GET['user']."'";
	
		$result=mysql_query($editdata,$dbconn);

		if ($result) {
			header("Location: ../users/actions.php?user=".$_GET['user']."&chg=1");
		} else {
			header("Location: ../users/actions.php?user=".$_GET['user']."&chg=0");
		}
		
	}

?>	
﻿<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>Coders {}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="La primera comunidad de programadores de El">
	<meta name="author" content="Fernando Santamaría - Christian Zayas">
	<!-- STYLESHEETS --><!--[if lt IE 9]><script src="../js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
	
	<link rel="stylesheet" type="text/css" href="../../css/style.css" >
	<link rel="stylesheet" type="text/css"  href="../../css/themes/default.css">
	<link rel="stylesheet" type="text/css"  href="../../css/responsive.css" >

	<script src="../../editor/jquery-ui/js/jquery-1.10.2.js"></script>
	<script src="../../editor/jquery-ui/js/jquery-ui-1.10.4.js"></script>

	<link href="../../font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- FONTS -->
	<link href='../../css/fonts.css' rel='stylesheet' type='text/css'>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="../../img/logo/Fav2.png" />

</head>
<body >
<!-- Header de Pagina -->
<header class="navbar clearfix navbar-fixed-top" id="header">
	<div class="container">
			<div class="navbar-brand">
				<!-- Logo Proyecto -->
				<a href="../dashboard/">
					<img src="../../img/logo/logo.png" alt="Coders Logo" class="img-responsive" height="30" width="120">
				</a>
				<!-- /Logo Proyecto -->
			</div>
			<!-- Menu -->					
			<ul class="nav navbar-nav pull-right">
				<!-- User Menu -->
				<li class="dropdown user" id="header-user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img alt="" src="../../img/avatars/<?php echo $_SESSION['UserID'];?>.jpg" onerror="this.src='../../img/avatars/default.jpg'"/>
						<span class="username"><?php echo $_SESSION['UserName']." ".$_SESSION['UserLast'];?></span>
						<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#"><i class="fa fa-user"></i> My Profile</a></li>
						<li><a href="../../dashboard/"><i class="fa fa-tachometer"></i> Go to Dashboard</a></li>
						<li><a href="../../logout/index.php"><i class="fa fa-power-off"></i> Log out</a></li>
					</ul>
				</li>
				<!-- /User Menu -->
			</ul>
			<!-- /General Menu -->
	</div>
</header>
<!--/HEADER -->
<!-- Contenido General -->
<section id="page">
	<!-- Menu de navegacion -->
	<div id="sidebar" class="sidebar sidebar-fixed">
		<div class="sidebar-menu nav-collapse">
			<div class="divide-20"></div>
			<div id="search-bar">
				<input type="text" id="searchbar" class="search" autocomplete="off" placeholder="Name - Last Name - Email"><i class="fa fa-search search-icon"></i>
			</div>
			<div id="targetDiv" class="search-div search-box">
			</div>
			<!-- Opciones de menu -->
			<ul>
				<li>
					<a href="../users/">
						<i class="fa fa-user fa-fw"></i> <span class="menu-text">Users</span>
					</a>					
				</li>
				<li>
					<a href="../post/">
						<i class="fa fa-pencil fa-fw"></i> <span class="menu-text">Posts</span>
					</a>
				</li>
				<li>
					<a href="../groups/">
						<i class="fa fa-users fa-fw"></i><span class="menu-text">Groups</span>
					</a>
				</li>
				<li>
					<a href="#">
						<i class="fa fa-briefcase fa-fw"></i><span class="menu-text">More...
						</span>
					</a>
				</li>
			</ul>
			<!-- /Opciones de menu -->
		</div>
	</div>
	<div id="main-content">
		<div class="row">
			<div id="content" class="col-md-12">
				<!-- Header de contenido-->
				<div class="row">
					<div class="col-sm-12">
						<div class="page-header">
							<!-- BREADCRUMBS -->
							<ul class="breadcrumb">
								<li>
									<i class="fa fa-home"></i>
									<a href="../dashboard/">Administration Panel</a>
								</li>
								<li>
									<a href="../users/">Users</a>
								</li>
								<li>
									<a href="#"><?php echo $fn." ".$ln;?></a>
								</li>
							</ul>
							<!-- /BREADCRUMBS -->
							<div class="clearfix">
								<h3 class="content-title pull-left">
									<span><</span>
									<span>CODERS</span>
									<span>/</span>
									<span>></span>
									 - Administration Panel - Users
								</h3>
							</div>
							<div class="divide-20"></div>
						</div>
					</div>
				</div>
				<!-- /Header de contenido -->
				<!-- Contenido general -->
				<div class="row">
					<div class="col-xs-12 col-md-12" id="wrapper">
						<?php 
						if(isset($_GET['chg'])){
							if ($_GET['chg']==1) {
								echo"<div class='alert alert-success col-xs-12 col-md-12'>Data has been successfully updated</div>";
							} else {
								echo"<div class='alert alert-danger col-xs-12 col-md-12'>There was an error updating the data, try again :( </div>";
							}
						}
						?>
						<h1 class="center"><?php echo $fn." ".$ln;?></h1>
						<div class="divide-20"></div>
						<div class="box">
					    	<div class="box-title small">
								<h4><i class="fa fa-picture-o"></i>Profile Picture</h4>
							</div>
							<div class="box-body">
								<form name="UpPic" id="UpPic" method="post" action="UR.php?user=<?php echo $_GET['user'];?>" enctype="multipart/form-data">
									<div class="col-xs-12 col-md-3 center">
										<img class="img-perfil" src="../../img/avatars/<?php echo $_GET['user'];?>.jpg" id="imgUser" onerror="this.src='../../img/avatars/default.jpg'" width="125" height="125">
									</div>
									<div class="col-xs-12 col-md-9">
										<div class="col-xs-12 col-md-12">
											<h4>Upload a new photo:</h4>
										</div>
										<div class="col-xs-12 col-md-12" style:"border: solid 1px black">
											<input type="file" name="fileUpload" id="fileUpload" class="form-control" accept="image/*" onChange="fileName()" style="opacity: 0; z-index:100; position:absolute" required/>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-picture-o"> Select a file:</i></span>
												<input type="text" class="form-control" placeholder="No file selected" id="selector"/>
											</div>
											
											</br></br>
										</div>	
										<div class="col-xs-12 col-md-12 ">
											<center><input name="btnUpload" id="btnUpload" type="submit" class="btn btn-primary col-xs-12 col-md-3" value="Upload Photo"/></center></br>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="divide-75"></div>
						<div class="box">
					    	<div class="box-title small">
								<h4><i class="fa fa-edit"></i>General Settings</h4>
							</div>
							<div class="box-body" style="word-wrap: break-word;">
								<form method="post" action="../users/actions.php?user=<?php echo $_GET['user']; ?>" name="EditData">
									<div>
									<div class="col-xs-12 col-md-6 form-group">
										<label for="FirstName">First Name:</label>
										<input type="text" class="form-control" name="FirstName" autocomplete="off" onkeypress="valText()" placeholder="First Name" value="<?php echo $fn;?>" required/>
									</div>
									<div class="col-xs-12 col-md-6 form-group">
										<label for="LastName">Last Name:</label>
										<input type="text" class="form-control" name="LastName" autocomplete="off" onkeypress="valText()" placeholder="Last Name" value="<?php echo $ln;?>"required/>
									</div>
									<div class="col-xs-12 col-md-12 form-group">
										<label for="Pass">New Password:</label>
										<input type="password" class="form-control" name="Pass" autocomplete="off" id="Pass" placeholder="*****" />
									</div>
									<div class="col-xs-12 col-md-12 form-group">
										<label for="Mail">Email:</label>
										<input type="email" class="form-control" name="Mail" id="Mail" value="<?php echo $mail;?>" readonly required/>
									</div>
									<div class="col-xs-12 col-md-12 form-group">
										<label for="BDate">Birth Date:</label>
										<input type="date" class="form-control" name="BDate" autocomplete="off" id="BDate" placeholder="01/04/1995" value="<?php echo $bdate;?>" onBlur="Act()" required/>
									</div>
									<div class="col-xs-12 col-md-12 form-group">
										<input type="submit" class="btn btn-primary pull-right" name="EditData" value="Save">
									</div>
								</div>
								</form>
							</div>
						</div>
						<div class="divide-50"></div>
						<div class="box">
					    	<div class="box-title small">
								<h4><i class="fa fa-wrench"></i>Roles</h4>
							</div>
							<div class="box-body">
								<form method="post" action="../users/actions.php?user=<?php echo $_GET['user']; ?>" name="EditRole">
									<div class="col-xs-12 col-md-12">
										<div class="col-xs-6 col-md-4">
											<h4><label for="newAdmin" >Administrator? </label>
											<input type="checkbox" class="chkAdmin" name="newAdmin" id="newAdmin" <?php if($admin==1){echo "checked";}?> /></h4>
										</div>
										<div class="col-xs-6 col-md-4">
											<h4><label for="blockUser" >Blocked?</label>
											<input type="checkbox" class="chkAdmin" name="blockUser" id="blockUser" <?php if($block==1){echo "checked";}?>/></h4>
										</div>
										<div class="col-xs-12 col-md-4">
											<input type="submit" class="btn btn-primary pull-right" name="editRole" id="editRole" value="Save"/></h4>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /Contenido general --> 
<!-- Core Bootstrap-->
<!--/PAGE -->
<!-- JAVASCRIPTS -->
<script type="text/javascript">
	$( "#searchbar" ).keyup(function(){
		var text = $( "#searchbar" ).val();
		var text2=$.trim(text);

		if (text2!="" && text.length>2) {
			getData('../consAdmin.php', 'targetDiv',tag());
		} else {
			$("#targetDiv").html("");
		};
	});
</script>
<!-- AJAX -->
<script src="../../Func.js"></script>
<!-- BOOTSTRAP -->
<script src="../../bootstrap-dist/js/bootstrap.min.js"></script>
<!-- SLIMSCROLL -->
<script type="text/javascript" src="../../js/jQuery-slimScroll-1.3.0/jquery.slimscroll.min.js"></script><script type="text/javascript" src="../../js/jQuery-slimScroll-1.3.0/slimScrollHorizontal.min.js"></script>
<!-- COOKIE -->
<script type="text/javascript" src="../../js/jQuery-Cookie/jquery.cookie.min.js"></script>
<!-- CUSTOM SCRIPT -->
<script src="../../js/script.js"></script>
<!-- CUSTOM SCRIPT -->
<script src="../../js/script.js"></script>
<!-- CUSTOM SCRIPT -->
<script src="../../js/script.js"></script>
<script>
	jQuery(document).ready(function() {		
		App.init(); //Initialise plugins and elements
	});
</script>
<!-- /JAVASCRIPTS -->
</body>
</html>