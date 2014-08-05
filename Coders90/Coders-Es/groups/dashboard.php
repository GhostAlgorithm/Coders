<?php
	session_save_path("../sessions/");
	session_start();
	//error_reporting(0);
	if(!isset($_SESSION['UserID'])){
		header('Location: ../');
	}

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

	if(isset($_POST["btnPost"])){
		$user=$_SESSION['UserID'];
		$content=$_POST["PContent"];

		date_default_timezone_set("America/El_Salvador");

		$pdate=date("Y-m-d");
		$phour=date("H:i:s");

		include("../BDD.php");
		$post="INSERT INTO post_group (UserID, GroupID, Content, Date, Time, View) VALUES ('$user','".$_GET['group']."','$content','$pdate','$phour','1')";
		$result=mysql_query($post,$dbconn);

		//Notificaciones de publicaciones en grupos
		$query="SELECT UserID FROM user_group WHERE GroupID='".$_GET['group']."'";
		$sql=mysql_query($query,$dbconn);

		while ($row=mysql_fetch_array($sql)) {
			if ($row[0]!=$_SESSION['UserID']) {
				$insertNotif="INSERT INTO notifications VALUES ('','".$row[0]."','0','".$pdate."','".$phour."','".$_SESSION['UserID']."','2','".$_GET['group']."')";
				$resNotif=mysql_query($insertNotif,$dbconn);
			}
		}


		if ($result) {
			header("location: dashboard.php?group=".$_GET['group']."");
		} 

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

	require("../SQLFunc.php");

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>Coders - <?php echo $gName;?></title>
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
					data-icon2="fa fa-bars" ></i>
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
							echo"<li><a href='../admin/dashboard/'><i class='fa fa-wrench'></i> Panel de Administración</a></li>";
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
										<a href="../groups/">Grupos</a>
									</li>
									<li>
										<a href="#"><?php echo $gName;?></a>
									</li>
								</ul>
								<!-- /BREADCRUMBS -->
								<div class="clearfix">
									<h3 class="content-title pull-left">
										<?php echo $gName;?>
									</h3>
									<div class="hidden-xs">
									<?php 
										if (partOf($_GET['group'])) {
											echo "<span><button class='compose tip btn btn-danger btn-group spacer-7 pull-right' data-original-title='Abandonar' user='".$_SESSION['UserID']."' group='".$_GET['group']."' id='leaveGroup'><i class='fa fa-sign-out'></i></button></span>
												  <span><a href='settings.php?group=".$_GET['group']."'><button class='compose tip btn btn-primary  btn-group spacer-7 pull-right' data-original-title='Configuración' id='htmlBtn'><i class='fa fa-cog'></i></button></a></span>
												  <span><a href='workspace.php?group=".$_GET['group']."'><button class='compose tip btn btn-warning  btn-group spacer-7 pull-right' data-original-title='Workspace' id='phpBtn'><i class='fa fa-desktop'></i></button></a></span>
												  <span><a href='members.php?group=".$_GET['group']."'><button class='compose tip btn btn-success  btn-group spacer-7 pull-right' data-original-title='Miembros' id='jsBtn'><i class='fa fa-users'></i></button></a></span>";
										} else {
											echo "<span><button class='compose tip btn btn-success btn-group pull-right' data-original-title='Unirme' user='".$_SESSION['UserID']."' group='".$_GET['group']."' id='joinGroup'><i class='fa fa-plus'></i> <i class='fa fa-user'></i></button></span>";
										}
									?>
									</div>
								</div>
								<div class="description">Creado por: <?php echo $gCreator;?></div>
							</div>
						</div>
					</div>
					<!-- /Header de contenido -->
					<!-- Contenido general -->
					<div class="row">
						<div class="col-xs-12 col-md-12 pull-right">
							<div class="visible-xs col-xs-12">
							<?php 
								if (partOf($_GET['group'])) {
									echo "<center><a href='members.php?group=".$_GET['group']."'><button class='btn btn-success col-xs-5 pull-left' id='jsBtn'><i class='fa fa-users'></i> Miembros</button></a>
										  <a href='workspace.php?group=".$_GET['group']."'><button class='btn btn-warning col-xs-5 pull-right' id='phpBtn'><i class='fa fa-desktop'></i> Workspace</button></a>
										  <div class='divide-25'></div>
										  <a href='settings.php?group=".$_GET['group']."'><button class='btn btn-primary col-xs-5 pull-left' id='htmlBtn'><i class='fa fa-cog'></i> Configuración</button></a>
										  <button class='btn btn-danger col-xs-5  pull-right' user='".$_SESSION['UserID']."' group='".$_GET['group']."' id='leaveGroup'><i class='fa fa-sign-out'></i> Abandonar</button><center></center>";
								} else {
									echo "<button class=btn btn-success pull-right' user='".$_SESSION['UserID']."' group='".$_GET['group']."' id='joinGroup'><i class='fa fa-plus'></i> <i class='fa fa-user'></i></button>";
								}
							?>
							<div class="divide-25"></div>
							</div>
							<!-- Post-->
							<?php 
								if (partOf($_GET['group'])) {
									echo "<div class='box border green'>
									    	<div class='box-title small'>
												<h4><i class='fa fa-code'></i>¿Qué estás pensando?</h4>
											</div>
											<div class='box-body clearfix' style='word-wrap:break-word;'>
												<span>
													<form method='post' action='dashboard.php?group=".$_GET['group']."'>
														<div class='col-xs-2 col-md-1'> 
															<img class='img-perfil' src='../img/avatars/".$_SESSION['UserID'].".jpg' onerror='this.src='../img/avatars/default.jpg'' width='50' height='50'>
														</div>
														<div class='col-xs-10 col-md-11'>
															<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
																<textarea class='form-control' rows='4' name='PContent' id='PContent'></textarea>
															</div>
															<div class='col-xs-12 col-md-6 pull-right'>
																<center></br><input name='btnPost' id='btnPost' type='submit' class='btn btn-primary col-xs-12 col-md-4 pull-right' value='Code it!'/></center></br>
															</div>
															<div class='col-xs-12 col-md-6 pull-left'>
																</br>
																<h4>
																	<span><</span>
																	<span>CODERS</span>
																	<span>/</span>
																	<span>></span>
																</h4>
															</div>
														</div>
													</form> 
												</span>
											</div>
										</div>";
							} 
							?>
							<!-- /Post-->
							<div id="newsFeed">
							<?php 
							NewsFeedGroups($_GET['group']);
							?>
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
	var idf=null;

	$( "#searchbar" ).keyup(function(){
		var text = $( "#searchbar" ).val();
		var text2=$.trim(text);

		if (text2!="" && text.length>2) {
			getData('cons.php', 'targetDiv',tag());
		} else {
			$("#targetDiv").html("");
		};
	});

	$( "#joinGroup" )
		.click(function() {
		var user = $(this).attr("user");
		var group = $(this).attr("group");
		$(this).attr("disabled","true");
		$(this).addClass("disabled");
		$.post("userActions.php", 
              {user: user, group: group, action: "join"},
              function() {
                  location.href="dashboard.php?group="+group+"";
              }
        );				
	});

	$( "#leaveGroup" )
		.click(function() {
		var user = $(this).attr("user");
		var group = $(this).attr("group");
		$(this).attr("disabled","true");
		$(this).addClass("disabled");
		$.post("userActions.php", 
              {user: user, group: group, action: "leave"},
              function() {
                  location.href="dashboard.php?group="+group+"";
              }
        );				
	});

	
	$( ".fa-comments" ).click(function() {
		var idf = $(this).attr("idf");
		var idfGroup = $(this).attr("idf-group");
		getData('commentsGroup.php',idf,idfGroup);				
	});

	function postComment(e){
		var idf=$("."+$(e).attr("idf")).val();
		var idfGroup = $(e).attr("idf-group");
		var postIdf=$(e).attr("idf");
		if(idf!=""){
	       $.post("userActions.php", 
	              {contents: idf, postidf: postIdf, action: "postComment"},
	              function() {
	                  getData('commentsGroup.php',postIdf,idfGroup);
	              }
	        );
	    } else {
	      return false;
	    }
	}

	function delComment(e){
		$( "#dialog-confirm-comment" ).dialog({
	      resizable: false,
	      height:180,
	      width: 400,
	      modal: true,
	      buttons: {
	        "Borrar": function (){
	          $( this ).dialog( "close" );
	            var idf=$(e).attr("idf");
				var postIdf=$(e).attr("post-idf");
				$.post("userActions.php", 
		              {idf: idf, action: "delComment"},
		              function() {
		              	  getData('commentsGroup.php',postIdf,postIdf);
		              }
		        );
	        },
	        Cancelar: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });				
	}

	function delPost(e){
		$( "#dialog-confirm-post" ).dialog({
	      resizable: false,
	      height:180,
	      width: 400,
	      modal: true,
	      buttons: {
	        "Borrar": function (){
	          $( this ).dialog( "close" );
	            var idf=$(e).attr("idf");
				$.post("userActions.php", 
		              {idf: idf, action: "delPost"},
		              function() {
		              	  location.reload();
		              }
		        );
	        },
	        Cancelar: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });				
	}

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