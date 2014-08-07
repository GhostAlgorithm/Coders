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
	error_reporting(0);
	if(!isset($_SESSION['UserID']) && $_SESSION['Admin']!="1"){
		header('Location: ../../');
	} elseif ($_SESSION['Admin']!="1") {
		header('Location: ../../dashboard/');
	}

	include("../../BDD.php");
	
	if (isset($_POST['showPost'])) {
		$showIdf=$_POST['postIdf'];
		$total=count($showIdf);

		for ($i=0; $i < $total; $i++) { 
			$query="UPDATE post SET View='1' WHERE PostID='".$showIdf[$i]."'";
			$result=mysql_query($query,$dbconn);
		}

		if ($result) {
			header("Location: actions.php?user=".$_GET['user']."&chg=1");
		} else {
			header("Location: actions.php?user=".$_GET['user']."&chg=0");
		}
	}

	if(isset($_POST['delPost'])){
		$showIdf=$_POST['postIdf'];
		$total=count($showIdf);

		for ($i=0; $i < $total; $i++) { 
			$query="UPDATE post SET View='0' WHERE PostID='".$showIdf[$i]."'";
			$result=mysql_query($query,$dbconn);
		}

		if ($result) {
			header("Location: actions.php?user=".$_GET['user']."&chg=1");
		} else {
			header("Location: actions.php?user=".$_GET['user']."&chg=0");
		}	
	}

	$query="SELECT Name, LastName FROM users WHERE UserID='".$_GET['user']."'";
	$result=mysql_query($query,$dbconn);

	while ($row=mysql_fetch_array($result)) {
		$fn=$row[0];
		$ln=$row[1];
	}

	$length = 3;

	$page = $_GET["page"]; 
	
	if (!$page) { 
		 $start = 0; 
		 $page=1;
	} 
	else { 
		$start = ($page - 1) * $length;
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
						<li><a href="#"><i class="fa fa-user"></i> Mi Perfil</a></li>
						<li><a href="../../dashboard/"><i class="fa fa-tachometer"></i> Ir al Dashboard</a></li>
						<li><a href="../../logout/index.php"><i class="fa fa-power-off"></i> Cerrar Sesión</a></li>
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
				<input type="text" id="searchbar" class="search" autocomplete="off" placeholder="Nombre - Apellido - Email"><i class="fa fa-search search-icon"></i>
			</div>
			<div id="targetDiv" class="search-div search-box">
			</div>
			<!-- Opciones de menu -->
			<ul>
				<li>
					<a href="../users/">
						<i class="fa fa-user fa-fw"></i> <span class="menu-text">Usuarios</span>
					</a>					
				</li>
				<li>
					<a href="../post/">
						<i class="fa fa-pencil fa-fw"></i> <span class="menu-text">Posts</span>
					</a>
				</li>
				<li>
					<a href="../groups/">
						<i class="fa fa-users fa-fw"></i><span class="menu-text">Grupos</span>
					</a>
				</li>
				<li>
					<a href="#">
						<i class="fa fa-briefcase fa-fw"></i><span class="menu-text">Ayuda
						</span>
					</a>
				</li>
			</ul>
			<!-- /Opciones de menu -->
		</div>
	</div>
	<!-- Contenido General -->
	<div id="main-content">
		<div class="row">
			<div class="container pull-left">
				<div id="content" class="col-lg-12">
					<!-- Header de contenido-->
					<div class="row">
						<div class="col-sm-12">
							<div class="page-header">
								<!-- BREADCRUMBS -->
								<ul class="breadcrumb">
									<li>
										<i class="fa fa-home"></i>
										<a href="../dashboard/">Panel de Administración</a>
									</li>
									<li>
										<a href="../groups/">Grupos</a>
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
										 - Panel de Administración - Grupos
									</h3>
								</div>
								<div class="divide-20"></div>
							</div>
						</div>
					</div>
					<!-- /Header de contenido -->
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<?php 
							if(isset($_GET['chg'])){
								if ($_GET['chg']==1) {
									echo"<div class='alert alert-success col-xs-12 col-md-12'>Cambios guardados atisfactoriamente</div>";
								} else {
									echo"<div class='alert alert-danger col-xs-12 col-md-12'>Ha ocurrido un error, inténtelo de nuevo :( </div>";
								}
							}
							?>
							<div class="box">
						    	<div class="box-title small">
									<h4>
									<img class="img-perfil" src="../../img/avatars/<?php echo $_GET['user'];?>.jpg" id="imgUser" onerror="this.src='../../img/avatars/default.jpg'" width="50" height="50">
									Grupos creados por <?php echo $fn." ".$ln;?></h4>
								</div>
							</div>
							<div class="col-xs-12 col-md-12" id="wrapper">
								<form method="POST" action="actions.php?user=<?php echo $_GET['user'];?>">
									<div class="divide-15"></div>
									<div class="box border orange">
										<div class="box-title">
											<h4><i class="fa fa-user"></i>Grupos</h4>
										</div>
										<div class="box-body">
											<table class="table" class="users">
												<thead>
													<tr>
														<th>ID</th>
														<th>Nombre</th>
														<th>Tipo</th>
														<th class="actions">Acciones</th>
													</tr>
												</thead>
												<tbody>
													<?php 
														include("../../SQLFunc.php");
														groupList($_GET['user'],$start,$length)
													?>
												</tbody>
											  </table>
										</div>
									</div>
									<?php 
										paginationGroups($_GET['user'],$page,"SELECT * FROM groups WHERE UserID='".$_GET['user']."'");
									?>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$("#selPost").click(function(){
		if($(this).is(':checked')) {
			$("input:checkbox").prop('checked', true);
		} else {
			$("input:checkbox").prop('checked', false);
		}
	});

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
<!-- /Contenido general --> 
<!-- Core Bootstrap-->
<!--/PAGE -->
<!-- JAVASCRIPTS -->
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
