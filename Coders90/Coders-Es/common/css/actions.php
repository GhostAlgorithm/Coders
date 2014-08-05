<?php
	session_start();

	if(!isset($_SESSION['UserID']) && $_SESSION['Admin']!="1"){
		header('Location: ../../');
	} elseif ($_SESSION['Admin']!="1") {
		header('Location: ../../dashboard/');
	}

	if(isset($_POST['delPost'])){
		include("../../BDD.php");
		$query="DELETE FROM post WHERE PostID='".$_POST['delPostID']."'";
		echo $query;
		$result=mysql_query($query,$dbconn);

		if ($result) {
			header("Location: ../post/actions.php?user=".$_GET['user']."&chg=1");
		} else {
			header("Location: ../post/actions.php?user=".$_GET['user']."&chg=0");
		}
	}

	include("../../BDD.php");
		$query="SELECT Name, LastName FROM users WHERE UserID='".$_GET['user']."'";
		$result=mysql_query($query,$dbconn);

		while ($row=mysql_fetch_array($result)) {
			$fn=$row[0];
			$ln=$row[1];
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


	<link href="../../font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- FONTS -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="../../img/logo/Fav2.png" />

	<script TYPE="text/javascript">
		var idpost="";
	</script>
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
				<input type="text" id="searchbar" class="search" onkeyup="getData('../cons.php', 'targetDiv',tag())" onkeydown="borrar('targetDiv')" autocomplete="off" placeholder="Nombre - Apellido - Email"><i class="fa fa-search search-icon"></i>
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
					<a href="#">
						<i class="fa fa-users fa-fw"></i><span class="menu-text">Grupos</span>
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
										<a href="../post/">Posts</a>
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
										 - Panel de Administración - Posts
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
									echo"<div class='alert alert-success col-xs-12 col-md-12'>Post Eliminado Satisfactoriamente</div>";
								} else {
									echo"<div class='alert alert-danger col-xs-12 col-md-12'>Ha ocurrido un error, inténtelo de nuevo:( </div>";
								}
							}
							?>
							<div class="box">
						    	<div class="box-title small">
									<h4>
									<img class="img-perfil" src="../../img/avatars/<?php echo $_GET['user'];?>.jpg" id="imgUser" onerror="this.src='../../img/avatars/default.jpg'" width="50" height="50">
									Posts por <?php echo $fn." ".$ln;?></h4>
								</div>
							</div>
							<div class="col-xs-12 col-md-12" id="wrapper">
								<div class="box border orange">
									<div class="box-title">
										<h4><i class="fa fa-user"></i>Posts</h4>
									</div>
									<div class="box-body">
										<table class="table" class="users">
											<thead>
												<tr>
													<th>Contenido</th>
													<th>Fecha</th>
													<th>Hora</th>
													<th class="actions">Acción</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													include("../../BDD.php");
													$query="SELECT content, Date, Time, PostID FROM post WHERE UserID='".$_GET['user']."' LIMIT 30";
													$result=mysql_query($query,$dbconn);

													while($row=mysql_fetch_array($result)){
														echo "
															<tr>
																<td class='table-rows'>".htmlentities($row[0])."</td>
																<td class='table-rows'>".$row[1]."</td>
																<td class='table-rows'>".$row[2]."</td>
																<form method='POST' action='actions.php?user=".$_GET['user']."'>
																	<td class='actions'><input type='submit' class='btn btn-danger btn-xs' name='delPost' value='Eliminar'></td>
																	<input type='hidden' name='delPostID' value=".$row[3].">
																</form>
															</tr>";
													}
												?>
											</tbody>
										  </table>
									</div>
								</div>
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