<?php
	error_reporting(0);
	session_start();
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
	if(!isset($_SESSION['UserID'])){
		header('Location: ../');
	} 

	if (isset($_GET['f'])) {
		include("../BDD.php");
		$query="SELECT FollowID FROM following WHERE UserID='".$_GET['f']."' AND FollowerID='".$_SESSION['UserID']."'";
		$result=mysql_query($query,$dbconn);
		$validID1=mysql_num_rows($result);

		$query="SELECT FollowID FROM following WHERE UserID='".$_SESSION['UserID']."' AND FollowerID='".$_GET['f']."'";
		$result=mysql_query($query,$dbconn);
		$validID2=mysql_num_rows($result);

		if ($validID1!=1 || $validID2!=1) {
			header('Location: ../messages/');
		}

		$query="SELECT Name, LastName FROM users WHERE UserID='".$_GET['f']."' LIMIT 1";
		$result=mysql_query($query,$dbconn);
		
		while ($row=mysql_fetch_array($result)) {
			$uName=$row[0];
			$uLastName=$row[1];
		}

		$valid=true;
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
			<!-- Notificaciones de mensajes -->
			<?php 
				require("../SQLFunc.php");
				myMessages();
			?>
			<!-- /Notificaciones de mensajes -->
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

<!-- Content -->
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
								<i class="fa fa-envelope fa-fw"></i><span class="menu-text">Mensajes</span>
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
										<a href="../messages/">Mensajes</a>
									</li>
									<li>
										<a href="#"><?php if(isset($_GET['f']) && $valid){echo $uName." ".$uLastName;}?></a>
									</li>
								</ul>
								<!-- /BREADCRUMBS -->
								<div class="clearfix">
									<h3 class="content-title pull-left">
										Mensajes <?php if(isset($_GET['f']) && $valid){echo " con ".$uName." ".$uLastName;}?>
									</h3>
								</div>
							</div>
						</div>
					</div>
					<!-- /Header de contenido -->
					<!-- Contenido general -->
					<div class="row">
						<div class="col-xs-12 col-md-12">
						 	<!-- CHAT -->
							<div class="row">
								<div class="col-md-12">
									<?php 								
										if (isset($_GET['f']) && $valid) {
											
											$query="SELECT messages.*, users.Name, users.LastName FROM messages INNER JOIN users on users.UserID=messages.UserFrom WHERE messages.UserID = '".$_SESSION['UserID']."' AND messages.UserFrom ='".$_GET['f']."' OR messages.UserID ='".$_GET['f']."' AND messages.UserFrom ='".$_SESSION['UserID']."' ORDER BY Date ASC, Time ASC";
											$result=mysql_query($query,$dbconn);

											echo"<div class='box border orange'>
													<div class='box-title'>
														<h4><i class='fa fa-comments'></i>Mensajes</h4>
													</div>
													<div class='box-body big'>
														<div class='scroller' id='messageField' data-height='300px' data-always-visible='0' data-rail-visible='0'>
															<ul class='media-list chat-list'>";

											while ($row=mysql_fetch_array($result)) {
												if ($row[2]==$_SESSION['UserID']) {
													echo "<li class='media'>
															<a class='pull-right' href='../profile/?user=".$row[2]."'>
																<img style='border: solid 2px #3498DB;' class='media-object'  alt='User image' width='50px' height='50px'  src='../img/avatars/".$row[2].".jpg'>
															</a>
															<div class='pull-right media-body chat-pop mod'>
																<h4 class='media-heading'>Tú <span class='pull-left'><abbr class='timeago' title='".date("d/m/Y", strtotime($row[5])) ." a las ".date("g:i a", strtotime($row[6]))."' >".strftime("%d de %B",strtotime($row[5])) .", ".date("g:i a", strtotime($row[6]))."</abbr> <i class='fa fa-clock-o'></i></span></h4></h4>
																".$row[3]."
															</div>
														</li>";
													} else {
														echo "<li class='media'>
															<a class='pull-left' href='../profile/?user=".$row[2]."'>
																<img style='border: solid 2px #3498DB;' class='media-object' alt='User image'  width='50px' height='50px' src='../img/avatars/".$row[2].".jpg'>
															</a>
															<div class='media-body chat-pop'>
																<h4 class='media-heading'>".$row[8]." "."$row[9]"." "."<span class='pull-right'><i class='fa fa-clock-o'></i> <abbr class='timeago' title='".date("d/m/Y", strtotime($row[5])) ." a las ".date("g:i a", strtotime($row[6]))."' >".strftime("%d de %B",strtotime($row[5])) .", ".date("g:i a", strtotime($row[6]))."</abbr> </span></h4>
																<p>".$row[3]."</p>
															</div>
														</li>";
													}
												}

												echo "</ul>
														</div>
														<div class='divide-20'></div>
														<div class='chat-form'>
															<div class='input-group'> 
																<input type='text' class='form-control' id='messageContent'> 
																	<span class='input-group-btn'> <button class='btn btn-primary' type='button' id='sendMessage'><i class='fa fa-check'></i></button> </span> 
															</div>
														</div>
													</div>
												</div>";
									} else {
										echo "<div class='box'>
										    	<div class='box-title small'>
													<h4><i class='fa fa-envelope'></i>Nuevo Mensaje</h4>
												</div>
											</div>
											<div class='input-group search-admin'>
												<span class='input-group-addon'><i class='fa fa-search'></i></span>
												<input type='text' id='searchbar-message' class='form-control' autocomplete='off' placeholder='Nombre - Apellido - Email'/>
											</div>
											<div id='targetDivMessages' class='search-div search-box'>
											</div>
											<div class='divide-40'></div>
											<div class='box'>
										    	<div class='box-title small'>
													<h4><i class='fa fa-comments'></i>Conversaciones</h4>
												</div>
											</div>";

										messageList();	
									}
									?>
								</div>
							</div>
							<!-- /CHAT -->
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
$(function() {
	var userTo="<?php echo $_GET['f']?>";
	$("#sendMessage").click(function(){
		var contents=$("#messageContent").val();
		contents=$.trim(contents);
		
		if (contents!="") {
			$.post("userActions.php", 
	              {contents: contents, userTo: userTo, action: "sendMessage"},
	              function() {
	                $.ajax({
		                data:  {userTo: userTo, action: "updateMessage"},
		                url:   'userActions.php',
		                dataType: "html",
		                type:  'post',
		                success:  function (response) {
		                	$("#messageContent").val("");
		                	$("#messageField").html(response);
		                	$("#messageField").animate({ scrollTop: $('#messageField')[0].scrollHeight}, 1000);
		                }
		            });
	              }
	        );
		}
	});

	$("#messageContent").focus(function(){
		$.post("userActions.php", 
	       {userTo: userTo, action: "readState"}
	    );
	});

	$( "#searchbar" ).keyup(function(){
		var text = $( "#searchbar" ).val();
		var text2=$.trim(text);

		if (text2!="" && text.length>2) {
			getData('cons.php', 'targetDiv',tag());
		} else {
			$("#targetDiv").html("");
		};
	});

	$( "#searchbar-message" ).keyup(function(){
		var text = $( "#searchbar-message" ).val();
		var text2=$.trim(text);

		if (text2!="" && text.length>2) {
			$.ajax({
                data:  {action: "search", tag: text2},
                url:   'userActions.php',
                dataType: "html",
                type:  'post',
                success:  function (response) {
                	$("#targetDivMessages").html(response);
                }
            });
		} else {
			$("#targetDivMessages").html("");
		};
	});
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
		$("#messageField").animate({ scrollTop: $('#messageField')[0].scrollHeight}, 1000);
		$(".slimScrollBar").css({ visible: "none", });
		$(".slimScrollRail").css({ visible: "none", });

		function updateMessages(){
			var userTo="<?php echo $_GET['f']?>";
			$.ajax({
                data:  {userTo: userTo, action: "updateMessage"},
                url:   'userActions.php',
                dataType: "html",
                type:  'post',
                success:  function (response) {
                	$("#messageField").html(response);
                	$("#messageField").animate({ scrollTop: $('#messageField')[0].scrollHeight}, 1000);
                }
            });
		}

		setInterval (updateMessages, 5000);
	});
</script>
	<!-- /JAVASCRIPTS -->
</body>
</html>