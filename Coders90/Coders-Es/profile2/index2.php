<?php
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['UserID'])){
		header('Location: ../');
	}

	include("../BDD.php");
	$query="SELECT * FROM users";
	$result=mysql_query($query,$dbconn);

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
	
	<link rel="stylesheet" type="text/css" href="../css/style.css" >
	<link rel="stylesheet" type="text/css"  href="../css/themes/default.css">
	<link rel="stylesheet" type="text/css"  href="../css/responsive.css" >


	<link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- FONTS -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="../img/logo/Fav2.png" />

</head>
<body >
<!-- Header de Pagina -->
<header class="navbar clearfix navbar-fixed-top" id="header">
	<div class="container">
			<div class="navbar-brand">
				<!-- Logo Proyecto -->
				<a href="../dashboard/">
					<img src="../img/logo/logo.png" alt="Coders Logo" class="img-responsive" height="30" width="120">
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
			<ul class="nav navbar-nav pull-right">
				<!-- User Menu -->
				<li class="dropdown user" id="header-user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img alt="" src="../img/avatars/<?php echo $_SESSION['UserID'];?>.jpg" onerror="this.src='../img/avatars/default.jpg'"/>
						<span class="username"><?php echo $_SESSION['UserName']." ".$_SESSION['UserLast'];?></span>
						<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#"><i class="fa fa-user"></i> My Profile</a></li>
						<li><a href="../user/"><i class="fa fa-cog"></i> Settings</a></li>
						<li><a href="../logout/index.php"><i class="fa fa-power-off"></i> Log Out</a></li>
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
						<input type="text" id="searchbar" class="search" onkeyup="getData('cons.php', 'targetDiv',tag())" onkeydown="borrar('targetDiv')" autocomplete="off"><i class="fa fa-search search-icon"></i>
					</div>
					<div id="targetDiv" class="search-div search-box">
					</div>
					<!-- Opciones de menu -->
					<ul>
						<li>
							<a href="#">
								<i class="fa fa-tachometer fa-fw"></i> <span class="menu-text">Dashboard</span>
							</a>					
						</li>
						<li>
							<a href="#">
								<i class="fa fa-desktop fa-fw"></i> <span class="menu-text">Worskpace</span>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="fa fa-calendar fa-fw"></i><span class="menu-text">Organizador
								</span>
							</a>
						</li>
						<li>
							<a href="../editor/">
								<i class="fa fa-file-text fa-fw"></i><span class="menu-text">Editor de Código
								</span>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="fa fa-briefcase fa-fw"></i><span class="menu-text">Otros...
								</span>
							</a>
						</li>
					</ul>
					<!-- /Opciones de menu -->
				</div>
			</div>
			<!-- /Menu de navegación -->
	<div id="main-content">
		<div class="container pull-left">
			<div class="row">
				<div id="content" class="col-lg-12">
					<div class="divide-40"></div>
					<!-- Contenido general -->
					<div class="row">
						<div class="col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
				    	 <div>
				            <div class="col-sm-12">
				                <div class="col-xs-12 col-sm-8">
				                    <h2><?php echo $_SESSION['UserName']." ".$_SESSION['UserLast'];?></h2>
				                    <p><strong>Bio: </strong>....</p>
				                    <p><strong>Skills: </strong>....</p>
				                    <p><strong>Birth Date: </strong>....</p>
				                    <p><strong>Member since: </strong>....</p>
				                </div>             
				                <div class="col-xs-12 col-sm-4 text-center">
				                    <figure>
				                        <img class="img-perfil" src="../img/avatars/<?php echo $_GET['user'];?>.jpg" onerror="this.src='../img/avatars/default.jpg'" width="125" height="125">
				                    </figure>
				                </div>
				            </div>            
				            <div class="col-xs-12 text-center">
				                <div class="col-xs-12 col-sm-4 hover">
				                    <button class="btn btn-success btn-block"><span class="fa fa-plus-circle"></span> Follow </button>
				                </div>
				                <div class="col-xs-12 col-sm-4 hover pull-right">
				                    <a href="../user/"><button class="btn btn-success btn-block">Settings</button></a>
				                </div>
				                
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
	<!-- Core Bootstrap-->
	<!--/PAGE -->
	<!-- JAVASCRIPTS -->
	<!-- JQUERY -->
	<script src="../js/jquery/jquery-2.0.3.min.js"></script>
	<!-- JQUERY UI-->
	<script src="../js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
	<!-- AJAX -->
	<script src="../Func.js"></script>
	<!-- BOOTSTRAP -->
	<script src="../bootstrap-dist/js/bootstrap.min.js"></script>
	<!-- SLIMSCROLL -->
	<script type="text/javascript" src="../js/jQuery-slimScroll-1.3.0/jquery.slimscroll.min.js"></script><script type="text/javascript" src="../js/jQuery-slimScroll-1.3.0/slimScrollHorizontal.min.js"></script>
	<!-- COOKIE -->
	<script type="text/javascript" src="../js/jQuery-Cookie/jquery.cookie.min.js"></script>
	<!-- CUSTOM SCRIPT -->
	<script src="../js/script.js"></script>
	<!-- CUSTOM SCRIPT -->
	<script src="../js/script.js"></script>
	<!-- CUSTOM SCRIPT -->
	<script src="../js/script.js"></script>
	<script>
		jQuery(document).ready(function() {		
			App.init(); //Initialise plugins and elements
		});
	</script>
	<!-- /JAVASCRIPTS -->
</body>
</html>