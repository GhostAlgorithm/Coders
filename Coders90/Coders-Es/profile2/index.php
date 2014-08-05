<?php
	session_start();
	//error_reporting(0);
	if(!isset($_SESSION['UserID'])){
		header('Location: ../');
	}
	
	if (isset($_GET['user'])) {
		$user=$_GET['user'];
	} else {
		$user=$_SESSION['UserID'];
	}

	include("../BDD.php");
	$query="SELECT * FROM following where UserID='".$user."'";
	$preFollowers=mysql_query($query,$dbconn);
	$Followers=mysql_num_rows($preFollowers);

	$query="SELECT * FROM following where FollowerID='".$user."'";
	$preFollowings=mysql_query($query,$dbconn);
	$Following=mysql_num_rows($preFollowings);

	$query="SELECT * FROM post where UserID='".$user."' AND View='1'";
	$prePost=mysql_query($query,$dbconn);
	$PostCount=mysql_num_rows($prePost);

	$query="SELECT * FROM users where UserID='".$user."'";
	$userData=mysql_query($query,$dbconn);
	while ($row=mysql_fetch_array($userData)) {
		$userName=$row[1];
		$userLast=$row[2];
	}

	if(isset($_GET['user'])){
		include("../BDD.php");
		$query="SELECT * FROM users where UserID='".$_GET['user']."'";
		$preValid=mysql_query($query,$dbconn);
		$valid=mysql_num_rows($preValid);

		if ($valid==0) {
			header('Location: ../error/404.html');
		}
	}
?>	
﻿<!DOCTYPE html>
<html lang="es">
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
	<link rel="stylesheet" type="text/css" href="main.css" >
	<link rel="stylesheet" href="../editor/jquery-ui/css/coders/jquery-ui-1.10.4.custom.css">

	<script src="../editor/jquery-ui/js/jquery-1.10.2.js"></script>
	<script src="../editor/jquery-ui/js/jquery-ui-1.10.4.js"></script>

	<link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- FONTS -->
	<link href='../css/fonts.css' rel='stylesheet' type='text/css'>
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
						<li><a href="#"><i class="fa fa-user"></i> Mi Perfil</a></li>
						<?php 
							if ($_SESSION['Admin']=="1") {
								echo"<li><a href='../admin/dashboard/'><i class='fa fa-wrench'></i> Administration Panel</a></li>";
							}
						?>
						<li><a href="../user/"><i class="fa fa-cog"></i> Configuración</a></li>
						<li><a href="../logout/index.php"><i class="fa fa-power-off"></i> Cerrar Sesión</a></li>
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
						<input type="text" id="searchbar" class="search" placeholder="Name - Last Name -Email" autocomplete="off"><i class="fa fa-search search-icon"></i>
					</div>
					<div id="targetDiv" class="search-div search-box">
					</div>
					<!-- Opciones de menu -->
					<ul>
						<li>
							<a href="../dashboard/">
								<i class="fa fa-tachometer fa-fw"></i> <span class="menu-text">Dashboard</span>
							</a>					
						</li>
						<li>
							<a href="../workspace/">
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
							<a href="../groups/">
								<i class="fa fa-group fa-fw"></i><span class="menu-text">Grupos
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
					<!-- Contenido general -->
					<div class="row">
						<!--Header-->
						<div class="foto-header"></div>
						<!--Foto de perfil-->
						<div>
							<img class="foto-perfil" src="../img/avatars/<?php echo $user;?>.jpg" alt="Fernando Santamaría" height="150" width="150"> 
						</div>
						<!--Nombre de usuario-->
						<section class="informacion-usuario">
						<div class ="nombre-usuario">
							<h2><?php echo $userName." ".$userLast;?></h2><br>
							<h4><strong>Miembro desde:</strong> April 2014</h4><br>
						</div>
						</section>
						<!--Datos del usuario-->
						<center><section class="datos-usuario">
							<div class="publicaciones">
								<h2><?php echo $PostCount?></h2>
								<h3>Post</h3>
								<i class="fa fa-code fa-4x"></i>
							</div>
							<div class="seguidores">
								<h2><?php echo $Followers?></h2>
								<h3>Seguidores</h3>
								<i class="fa fa-users fa-4x"></i>
							</div>
							<div class="siguiendo"> 	
								<h2><?php echo $Following?></h2>
								<h3>Siguiendo</h3>
								<i class="fa fa-users fa-4x"></i>
							</div><br>
						</section></center>
					</div>
					<div id="myFeed" class="col-md-12 col-xs-12 cleafix">
					<?php 
						require("../SQLFunc.php");
						//myFeed($_SESSION['UserID']);
					?>
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