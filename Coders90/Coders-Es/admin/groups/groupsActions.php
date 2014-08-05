<?php
	session_save_path("../../sessions/");
	session_start();
	//error_reporting(0);
	if(!isset($_SESSION["UserID"]) && $_SESSION["Admin"]!="1"){
		header("Location: ../../");
	} elseif ($_SESSION["Admin"]!="1") {
		header("Location: ../../dashboard/");
	}

	include("../../BDD.php");

	$query="SELECT groups.*, users.Name, users.LastName FROM groups INNER JOIN users ON users.UserID = groups.UserID WHERE groups.GroupID='".$_GET['groupIdf']."' LIMIT 1";
	$result=mysql_query($query,$dbconn);

	while ($row=mysql_fetch_array($result)) {
		$gId=$row[0];
		$gName=$row[1];
		$gContent=$row[2];
		$gCreator=$row[3];
		$uName=$row[6];
		$uLast=$row[7];
	}

	if (isset($_POST['delMembers'])) {
		echo "<script>alert('Isset')</script>";
		$arrayMembers=$_POST['members'];
		//print_r($arrayMembers);
		$total=count($arrayMembers);

		for ($i=0; $i < $total; $i++) { 
			$query="DELETE FROM  user_group WHERE UserID='".$arrayMembers[$i]."' LIMIT 1";
			$result=mysql_query($query,$dbconn);
		}

		if ($result) {
			header("Location: groupsActions.php?groupIdf=".$_GET['groupIdf']."&chg=1");
		} else {
			header("Location: groupsActions.php?groupIdf=".$_GET['groupIdf']."&chg=0");
		}
	}

	require("../../SQLFunc.php");
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
						<img alt="" src="../../img/avatars/<?php echo $_SESSION["UserID"];?>.jpg" onerror="this.src="../../img/avatars/default.jpg""/>
						<span class="username"><?php echo $_SESSION["UserName"]." ".$_SESSION["UserLast"];?></span>
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
										<a href="../groups/actions.php?user=<?php echo $gCreator;?>">Grupos de <?php echo $uName." ".$uLast;?></a>
									</li>
									<li>
										<a href="#">Detalles</a>
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
									echo"<div class='alert alert-success col-xs-12 col-md-12'>Cambios guardados satisfactoriamente</div>";
								} else {
									echo"<div class='alert alert-danger col-xs-12 col-md-12'>Ha ocurrido un error, inténtelo de nuevo :( </div>";
								}
							}
							?>
							<div class="box">
						    	<div class="box-title small">
									<h4><i class="fa fa-bars"></i>Detalles de grupo y creador</h4>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-6" >
							<div class="col-xs-12 col-md-12" >
								<strong><h3><?php echo $gName;?></h3></strong>
							</div>
							<div class="col-xs-12 col-md-2">
								<strong><h5>ID:</h5></strong>
							</div>
							<div class="col-xs-12 col-md-10" >
								<strong><h5><?php echo $gId;?></h5></strong>
							</div>
							<div class="col-xs-12 col-md-2">
								<strong><h5>Tipo:</h5></strong>
							</div>
							<div class="col-xs-12 col-md-10" >
								<strong><h5><?php echo $gContent;?></h5></strong>
							</div>
							<div class="col-xs-12 col-md-2">
								<strong><h5><U></U>Usuarios:</h5></strong>
							</div>
							<div class="col-xs-12 col-md-10" >
								<strong><h5><?php echo usersGroupAdmin($_GET['groupIdf']);?></h5></strong>
							</div>
							<div class="divide-15"></div>
							<div class="col-xs-12 col-md-12" >
								<button class="btn btn-danger btn-xs ">Eliminar grupo</button>
							</div>
						</div>
						<div class="col-xs-12 col-md-6" >
							<div class="col-xs-12 col-md-12" >
								<strong><h3><?php echo $uName." ".$uLast;?></h3></strong>
							</div>
							<div class="col-xs-12 col-md-2" >
								<strong><h5>ID:</h5></strong>
							</div>
							<div class="col-xs-12 col-md-10" >
								<strong><h5><?php echo $gCreator;?></h5></strong>
							</div>
							<div class="col-xs-12 col-md-2" >
								<strong><h5>Nombre:</h5></strong>
							</div>
							<div class="col-xs-12 col-md-10" >
								<strong><h5><?php echo $uName." ".$uLast;?></h5></strong>
							</div>
							<div class="divide-15"></div>
							<div class="col-xs-12 col-md-12" >
								<a href="../users/actions.php?user=<?php echo $gCreator;?>"><button class="btn btn-info btn-xs ">Administrar usuario</button></a>
							</div>
						</div>
						<div class="divide-50"></div>
						<div class="col-xs-12 col-md-12">
							<div class="box">
						    	<div class="box-title small">
									<h4><i class="fa fa-group"></i>Miembros del grupo</h4>
								</div>
							</div>
							<form action="groupsActions.php?groupIdf=<?php echo $_GET['groupIdf']?>" method="POST">
								<div class="col-md-12 col-xs-12">
									<div class="col-xs-6 col-md-3">
										<input type='checkbox' id='selMembers' name="selMembers" class="pull-left"><label for="selMembers" class="labelMargin">Seleccionar todos</label>
									</div>
									<div class="col-xs-6 col-md-9">
										<input type='submit' name="delMembers" class="btn btn-danger btn-xs pull-right" value="Eliminar miembros seleccionados">
									</div>
								</div>
								<?php 
								$query="SELECT user_group.UserID, users.Name, users.LastName FROM user_group INNER JOIN users ON users.UserID=user_group.UserID WHERE user_group.GroupID='".$_GET['groupIdf']."' ORDER BY Name ASC";	
								$result=mysql_query($query,$dbconn);
								$total=mysql_num_rows($result);
								$index=0;

								while ($row=mysql_fetch_array($result)) {
									echo "<div class='col-md-3 col-xs-6 col-lg-2 user-container'>
											<a href='../profile/?user=".$row[0]."' class='styleLess'><img class='member-img' alt='' src='../../img/avatars/".$row[0].".jpg' onerror=\"this.src='../../img/avatars/default.jpg'\"/>
											<h5>".$row[1]." ".$row[2]."</h5></a>
											<input type='checkbox' id='".$index."' value='".$row[0]."' name='members[]'> <label for='".$index."' class='label label-info'> Seleccionar</label>
										</div>";
									$index++;								
								}
								?>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$("#selMembers").click(function(){
		if($(this).is(":checked")) {
			$("input:checkbox").prop("checked", true);
		} else {
			$("input:checkbox").prop("checked", false);
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
