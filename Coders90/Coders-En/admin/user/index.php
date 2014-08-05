<?php
	error_reporting(0);

	session_start();
	if(!isset($_SESSION['UserID'])){
		header('Location: ../');
	} else {
		$edit=0;
		include("../../BDD.php");
		$userdata="Select * from users where UserID='".$_SESSION['UserID']."'";
		$result=mysql_query($userdata,$dbconn);
		
		while ($row=mysql_fetch_array($result)) {
			$fn=$row[1];
			$ln=$row[2];
			$mail=$row[3];
			$fnac=$row[5];
		}
		mysql_close();

		if(isset($_POST["EditData"])){
			include("../../BDD.php");
			$fn=$_POST["FirstName"];
			$ln=$_POST["LastName"];
			$mail=$_POST["Mail"];
			$bdate=$_POST["BDate"];
			$editdata="Update users SET Name='".$fn."', LastName='".$ln."', Email='".$mail."', BirthDate='".$bdate."' WHERE UserID='".$_SESSION['UserID']."'";
			
			$result=mysql_query($editdata);

			if ($result) {
				require("../../SQLFunc.php");
				UserData();
				$edit=2;
			}else{
				$edit=1;
			}

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
					<!-- Ocultar Menú -->
					<div id="sidebar-collapse" class="sidebar-collapse btn">
						<i class="fa fa-bars" 
							data-icon1="fa fa-bars" 
							data-icon2="fa fa-bars" ></i>
					</div>
					<!-- /Ocultar Menu -->
				</div>
				
				<!-- Menu -->					
				<!-- Menu -->					
				<ul class="nav navbar-nav pull-right">
					<!-- User Menu -->
					<li class="dropdown user" id="header-user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img alt="" src="../../img/avatars/<?php echo $_SESSION['UserID'];?>.jpg" onerror="this.src='../img/avatars/default.jpg'"/>
							<span class="username"><?php echo $_SESSION['UserName']." ".$_SESSION['UserLast'];?></span>
							<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="../../profile/"><i class="fa fa-user"></i> My profile</a></li>
							<li><a href="../../dashboard/"><i class="fa fa-tachometer"></i> Go to Dashboard</a></li>
							<li><a href="../user/"><i class="fa fa-cog"></i> Configuración</a></li>
							<li><a href="../../logout/index.php"><i class="fa fa-power-off"></i> Log Out</a></li>
						</ul>
					</li>
					<!-- /User Menu -->
				</ul>
				<!-- /General Menu -->
		</div>
	</header>
	<!--/HEADER -->
	
	<!-- Content -->
	<section id="page">
				<!-- Menu de navegacion -->
				<div id="sidebar" class="sidebar sidebar-fixed">
					<div class="sidebar-menu nav-collapse">
						<div class="divide-20"></div>
						<div id="search-bar">
							<input type="text" id="searchbar" class="search" placeholder="Name - Last Name - Email" autocomplete="off"><i class="fa fa-search search-icon"></i>
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
							<a href="#">
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
				<!-- /Menu de navegación -->
		<div id="main-content">
			<div class="container">
				<div class="row">
					<div id="content" class="col-lg-12">
						<!-- Header de contenido-->
						<div class="row">
							<div class="col-sm-12">
								<div class="page-header">
									<!-- BREADCRUMBS -->
									<ul class="breadcrumb">
										<li>
											<i class="fa fa-home"></i>
											<a href="../dashboard/">Home</a>
										</li>
										<li>
											<a href="#">Settings</a>
										</li>
									</ul>
									<!-- /BREADCRUMBS -->
									<div class="clearfix">
										<h3 class="content-title pull-left">
											Settings - Administrator Account
										</h3>
									</div>
								</div>
							</div>
						</div>
						<!-- /Header de contenido -->
						<!-- Contenido general -->
						<div class="row">
							<div class="col-xs-12 col-md-12">
							<?php 

							if(isset($_GET["up"])){
								if ($_GET["up"]==0) {
									echo"<div class='alert alert-danger col-xs-12 col-md-12'>There was an error, Try again :( </div>";
								} else {
									echo"<div class='alert alert-success col-xs-12 col-md-12'>Profile picture has been changed successfully</div>";
								}

							}

							if($edit==1){
								echo"<div class='alert alert-danger col-xs-12 col-md-12'>There was an error, Try again :( </div>";
							} elseif ($edit==2) {
								echo"<div class='alert alert-success col-xs-12 col-md-12'>Information has been changed successfully</div>";
							}?>
							    <div class="box">
							    	<div class="box-title small">
										<h4><i class="fa fa-picture-o"></i>Profile Photo</h4>
									</div>
									<div class="box-body">
										<form name="UpPic" id="UpPic" method="post" action="UR.php" enctype="multipart/form-data">
											<div class="col-xs-12 col-md-3 center">
												<img class="img-perfil" src="../../img/avatars/<?php echo $_SESSION['UserID'];?>.jpg" onerror="this.src='../img/avatars/default.jpg'" width="125" height="125">
											</div>
											<div class="col-xs-12 col-md-9">
												<div class="col-xs-12 col-md-12">
													<h4>Upload a new photo:</h4>
												</div>
												<div class="col-xs-12 col-md-12" style:"border: solid 1px black">
													<input type="file" name="fileUpload" id="fileUpload" class="form-control" accept="image/*" onChange="fileName()" style="opacity: 0; z-index:100; position:absolute" required/>
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-picture-o"> Choose File:</i></span>
														<input type="text" class="form-control" placeholder="No file selected" id="selector"/>
													</div>
													
													</br></br>
												</div>	
												<div class="col-xs-12 col-md-12 ">
													<center><input name="btnUpload" id="btnUpload" type="submit" class="btn btn-primary col-xs-12 col-md-3" value="Subir Foto"/></center></br>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="divide-75"></div>
								<div class="box">
							    	<div class="box-title small">
										<h4><i class="fa fa-edit"></i>General Account Settings</h4>
									</div>
									<div class="box-body" style="word-wrap: break-word;">
										<form method="post" action="../user/" name="EditData">
											<div>
											<div class="col-xs-12 col-md-6 form-group">
												<label for="FirstName">First Name:</label>
												<input type="text" class="form-control" name="FirstName" placeholder="First Name" value="<?php echo $fn;?>" required/>
											</div>
											<div class="col-xs-12 col-md-6 form-group">
												<label for="LastName">Last Name:</label>
												<input type="text" class="form-control" name="LastName" placeholder="Last Name" value="<?php echo $ln;?>"required/>
											</div>
											<div class="col-xs-12 col-md-12 form-group">
												<label for="Pass1">Password:</label>
												<input type="password" class="form-control" name="Pass1" id="Pass1" value="************" placeholder="*****" required/>
											</div>
											<div class="col-xs-12 col-md-12 form-group">
												<label for="Pass2">Re-enter Password:</label>
												<input type="password" class="form-control" name="Pass2" id="Pass2" value="************" placeholder="*****" onBlur='email()' required/>
											</div>
											<div class="col-xs-12 col-md-12 form-group">
												<label for="Mail">Email:</label>
												<input type="email" class="form-control" name="Mail" id="Mail" placeholder="mail@mail.com" value="<?php echo $mail;?>" required/>
											</div>
											<div class="col-xs-12 col-md-12 form-group">
												<label for="BDate">Bith Date:</label>
												<input type="date" class="form-control" name="BDate" id="BDate" placeholder="dd/mm/yyyy" value="<?php echo $fnac;?>" onBlur="Act()" required/>
											</div>
											<div class="col-xs-12 col-md-12 form-group">
												<input type="submit" class="btn btn-primary pull-right" name="EditData" value="Update Information">
											</div>
										</div>
										</form>
									</div>
								</div> 
							</div>
						</div>
						<!-- /Contenido general --> 
					</div>
				</div>
			</div>
		</div>
	</section>
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
	<!-- JQUERY -->
	<script src="../../js/jquery/jquery-2.0.3.min.js"></script>
	<!-- JQUERY UI-->
	<script src="../../js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
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
	<script>
		jQuery(document).ready(function() {		
			App.init(); //Initialise plugins and elements
		});
	</script>
	<!-- /JAVASCRIPTS -->
</body>
</html>