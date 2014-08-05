<?php
	session_save_path("../sessions/");
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['UserID'])){
		header('Location: ../');
	}
	date_default_timezone_set("America/El_Salvador");

	if(isset($_GET['group'])){
		include("../BDD.php");
		$query="SELECT * FROM groups where GroupID='".$_GET['group']."'";
		$preValid=mysql_query($query,$dbconn);
		$valid=mysql_num_rows($preValid);

		if ($valid==0) {
			header('Location: ../error/404.html');
		}
	} else {
		header('Location: ../groups/');
	}

	include("../BDD.php");
	$query="SELECT groups.*, users.UserID, users.Name, users.LastName FROM groups INNER JOIN users ON groups.UserID = users.UserID WHERE groups.GroupID='".$_GET['group']."'";	
	$result=mysql_query($query,$dbconn);

	while($row=mysql_fetch_array($result)){
		$gName=$row[1];
		$gColor=$row[4];
		$gCreator=$row[7]." ".$row[8];
		$idCreator=$row[3];
	}

	if (isset($_POST["action"]) && $_POST["action"] == "upload"){
		$type = $_FILES['FileToUpload']['type'];
		$name =  $_FILES['FileToUpload']['name'];
		$tempName = $_FILES['FileToUpload']['tmp_name'];
		$resultPhp = strpos($name, ".php");

		if ($name!="") {
			if ($type=="text/css" || $type="text/html" || $type="application/javascript") {
				if (strpos($name, ".php")) {
					$name=str_replace(".php", "", $name);
				}

				$path="../editor/codefiles/groups/".$_GET['group']."/".$name."";
				
				if(file_exists($path)) {
				    header("Location: workspace.php?group=".$_GET['group']."&chg=2");
				} else {
					
					$uploadDir = "../editor/codefiles/groups/".$_GET['group']."/";
					$uploadFile = $uploadDir . basename($name);

					if (move_uploaded_file($tempName, $uploadFile)) {
					    header("Location: workspace.php?group=".$_GET['group']."&chg=1");

					    //Notificaciones de subida de archivo en grupo
						$query="SELECT UserID FROM user_group WHERE GroupID='".$_GET['group']."'";
						$sql=mysql_query($query,$dbconn);

						$udate=date("Y-m-d");
						$uhour=date("H:i:s");

						while ($row=mysql_fetch_array($sql)) {
							if ($row[0]!=$_SESSION['UserID']) {
								$insertNotif="INSERT INTO notifications VALUES ('','".$row[0]."','0','".$udate."','".$uhour."','".$_SESSION['UserID']."','4','".$_GET['group']."')";
								$resNotif=mysql_query($insertNotif,$dbconn);
							}
						}
					} else {
					    header("Location: workspace.php?group=".$_GET['group']."&chg=0");
					}

				}

			} else {
				header("Location: workspace.php?group=".$_GET['group']."&chg=0");
			}
			
		} else {
			header("Location: workspace.php?group=".$_GET['group']."&chg=0");
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
	<link rel="stylesheet" href="../editor/jquery-ui/css/coders/jquery-ui-1.10.4.custom.css">

	<script src="../editor/jquery-ui/js/jquery-1.10.2.js"></script>
	<script src="../editor/jquery-ui/js/jquery-ui-1.10.4.js"></script>

	<link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- FONTS -->
	<link href='../css/fonts.css' rel='stylesheet' type='text/css'>
	<!-- Favicon -->
	<link rel="shortcut icon" href="../common/img/favicon.png" />
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
					data-icon2="fa fa-bars"></i>
			</div>
			<!-- /Ocultar Menu -->
		</div>
		
		<!-- General Menu -->					
		<ul class="nav navbar-nav pull-right">
			<!-- User Menu -->
			<li class="dropdown user" id="header-user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img alt="" src="../img/avatars/<?php echo $_SESSION['UserID'];?>.jpg" onerror="this.src='../img/avatars/default.jpg'"/>
					<span class="username"><?php echo $_SESSION['UserName']." ".$_SESSION['UserLast'];?></span>
					<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li><a href="../profile/"><i class="fa fa-user"></i> Mi Perfil</a></li>
					<?php 
						if ($_SESSION['Admin']=="1") {
							echo"<li><a href='../admin/dashboard/'><i class='fa fa-wrench'></i> Panel de Administración </a></li>";
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
						<input type="text" id="searchbar" class="search" autocomplete="off" placeholder="Nombre - Apellido - Email"><i class="fa fa-search search-icon"></i>
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
							<a href="../messages/">
								<i class="fa fa-envelope fa-fw"></i><span class="menu-text">Mensajes
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
										<a href="dashboard.php?group=<?php echo $_GET['group'];?>"><?php echo $gName;?></a>
									</li>
									<li>
										<a href="#">Workspace</a>
									</li>
								</ul>
								<!-- /BREADCRUMBS -->
								<div class="clearfix">
									<h3 class="content-title pull-left">
										<?php echo $gName;?> Workspace
									</h3>
								</div>
							</div>
						</div>
					</div>
					<!-- /Header de contenido -->
					<!-- Contenido general -->
					<div class="row">
						<div class="col-md-12">
							<div id="newsFeed">
								<!--/Files-->
								<?php 
								if(isset($_GET['chg'])){
									if ($_GET['chg']==1) {
										echo"<div class='alert alert-success col-xs-12 col-md-12'>Archivo subido exitosamente</div>";
									}elseif ($_GET['chg']==2) {
										echo"<div class='alert alert-warning col-xs-12 col-md-12'>Hay otro archivo con el mismo nombre</div>";
									} else {
										echo"<div class='alert alert-danger col-xs-12 col-md-12'>Ocurrió un error al subir el archivo, intentelo de nuevo :( </div>";
									}
								}
								?>
								<div class="box">
									<div class="box-title">
										<h4><i class="fa fa-bars"></i> Archivos de 	<?php echo $gName;?></h4>
									</div>
									<div class="box-body clearfix">
									   <div class="divide-40 visible-xs"></div>
									   <div class="btn-group">
										  <div class="btn-group">
											  <div class="hidden-xs">
												  <button class="btn btn-warning" id="allBtn">Todos</button>
												  <button class="btn btn-primary" id="htmlBtn">HTML</button>
												  <button class="btn btn-danger" id="phpBtn">PHP</button>
												  <button class="btn btn-info" id="cssBtn">CSS</button>
												  <button class="btn btn-success" id="jsBtn">Javascript</button>
											  </div>
											  <div class="visible-xs pull-left">
												   <select id="e1" class="form-control">
														<option>Todos</option>
														<option>HTML</option>
														<option>PHP</option>
														<option>CSS</option>
														<option>Javascript</option>
													</select>
											  </div>
										   </div>
									    </div>
									    <div class="pull-right">
									    	<form action="workspace.php?group=<?php echo $_GET['group'];?>" method="POST" name="NewFileUpload" id="NewFileUpload" enctype="multipart/form-data">
										    	<button class="btn btn-primary pull-right" name="Upload" id="Upload"><input type="file" accept="text/css,text/html,application/javascript" name="FileToUpload" id="FileToUpload" style="overflow: hidden;opacity: 0; position: absolute;border: solid 1px orange; z-index:100;width:75px;"/>Subir Archivo</button>
												<input name="action" type="hidden" value="upload" /> 
											</form>
									    </div>
										<div class="divide-20"></div>
										<div class="row">
											<?php 
												$dir = "../editor/codefiles/groups/".$_GET['group']."/";
												$directorio=opendir($dir); 
												while ($file = readdir($directorio)){
													  if ($file != '.' && $file != '..') { 
													  	$resultadoHtml = strpos($file, ".html");
													  	$resultadoHtm = strpos($file, ".htm");
													  	$resultadoCss = strpos($file, ".css");
													  	$resultadoJs = strpos($file, ".js");
													  	
													  	if ($resultadoHtml==true || $resultadoHtm==true) {
													  		echo "<div class='col-md-3 idfHtml'>
																	<div>
													  					<h5><span>".$file."</span>
													  					<a href='".$dir.$file."' download='".$file."'>
													  					<span class='pull-right'><i class='fa fa-fw fa-cloud-download' title='Download File'></i></span></a>
													  					<a href='../editor/?id=".$file."&type=html'><span class='pull-right'><i class='fa fa-edit btnSpace' title='Edit File'></i></a></span></h5>
													  				</div>
																	<div class='filter-content'>
																		<div class='img-text'><span>{ ".$file." }</span></div>
																		<img src='../img/workspace/simplehtml.png' alt='' class='img-responsive' />
																	</div>
																</div>";
													  	} elseif ($resultadoJs==true) {
													  		echo "<div class='col-md-3 idfJs'>
																	<div>
													  					<h5><span>".$file."</span>
													  					<a href='".$dir.$file."' download='".$file."'>
													  					<span class='pull-right'><i class='fa fa-fw fa-cloud-download' title='Download File'></i></span></a>
													  					<a href='../editor/?id=".$file."&type=javascript'><span class='pull-right'><i class='fa fa-edit btnSpace' title='Edit File'></i></a></span></h5>
													  				</div>
																	<div class='filter-content'>
																		<div class='img-text'><span>{ ".$file." }</span></div>
																		<img src='../img/workspace/simplejs.png' alt='' class='img-responsive' />
																	</div>
																</div>";
													  	} elseif ($resultadoCss==true) {
													  		echo "<div class='col-md-3 idfCss'>
																	<div>
													  					<h5><span>".$file."</span>
													  					<a href='".$dir.$file."' download='".$file."'>
													  					<span class='pull-right'><i class='fa fa-fw fa-cloud-download' title='Download File'></i></span></a>
													  					<a href='../editor/?id=".$file."&type=css'><span class='pull-right'><i class='fa fa-edit btnSpace' title='Edit File'></i></a></span></h5>
													  				</div>
																	<div class='filter-content'>
																		<div class='img-text'><span>{ ".$file." }</span></div>
																		<img src='../img/workspace/simplecss.png' alt='' class='img-responsive' />
																	</div>
																</div>";
													  	} else {
													  		$fileNew=$file.".php";
													  		echo "<div class='col-md-3 idfPhp'>
													  				<div>
													  					<h5><span>".$fileNew."</span>
													  					<a href='".$dir.$file."' download='".$fileNew."'>
													  					<span class='pull-right'><i class='fa fa-fw fa-cloud-download' title='Download File'></i></span></a>
													  					<a href='../editor/?id=".$file."&type=php'><span class='pull-right'><i class='fa fa-edit btnSpace' title='Edit File'></i></a></span></h5>
													  				</div>
																	<div class='filter-content'>
																		<div class='img-text'><span>{ ".$fileNew." }</span></div>
																		<img src='../img/workspace/simplephp.png' alt='' class='img-responsive' />
																	</div>
																</div>";
													  	}
													 
													 }
												}
												closedir($directorio); 		 	
											?>
										</div>
									</div>
								</div>
								<!--/Files-->
							</div>
						</div>
					</div>
					<!-- /Contenido general --> 
				</div>
			</div>
		</div>
	</div>
</section>
<div id="dialog-confirm-comment" title="Coders" style="display:none">
  <p><h3><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></h3></span>¿Realmente desea borrar este comentario?</p>
</div>
<div id="dialog-confirm-post" title="Coders" style="display:none">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><br>¿Realmente desea borrar esta publicación?</p>
</div>
<!-- Core Bootstrap-->
<!--/PAGE -->
<!-- JAVASCRIPTS -->
<!-- JQUERY -->
<script type="text/javascript">
$("#FileToUpload").change(function() {
	$("#NewFileUpload").submit();
});

$("#htmlBtn").click(function(){
	$('.col-md-3').hide(250);
    $('.col-md-3').hide("fast");

    $('.idfHtml').show(250);
    $('.idfHtml').show("fast");
	
});

$("#phpBtn").click(function(){
	$('.col-md-3').hide(250);
    $('.col-md-3').hide("fast");

    $('.idfPhp').show(250);
    $('.idfPhp').show("fast");
});

$("#cssBtn").click(function(){
	$('.col-md-3').hide(250);
    $('.col-md-3').hide("fast");

    $('.idfCss').show(250);
    $('.idfCss').show("fast");
});

$("#jsBtn").click(function(){
	$('.col-md-3').hide(250);
    $('.col-md-3').hide("fast");

    $('.idfJs').show(250);
    $('.idfJs').show("fast");
});

$("#allBtn").click(function(){
	$('.col-md-3').show(250);
    $('.col-md-3').show("fast");
});


</script>
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
<script>
	jQuery(document).ready(function() {	
		App.init(); //Initialise plugins and elements
	});
</script>
<!-- /JAVASCRIPTS -->
</body>
</html>