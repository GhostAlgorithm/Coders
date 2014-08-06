<?php
	session_save_path("../sessions/");
	session_start();
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
	//error_reporting(0);
	if(!isset($_SESSION['UserID'])){
		header('Location: ../');
	}

	include("../BDD.php");

	if((isset($_GET['r']) && !empty($_GET['r'])) && (isset($_GET['i']) && !empty($_GET['i']))){

		if ($_GET['r']=='post') {
			$comment="";
			$query="SELECT post.*, users.Name, users.Lastname FROM post INNER JOIN users on users.UserID=post.UserID WHERE post.PostID='".$_GET['i']."' AND View='1' LIMIT 1";
			$result=mysql_query($query,$dbconn);
			$valid=mysql_num_rows($result);

			if ($valid=='0') {
				header('Location: ../error/404.html');
			}

			while ($row=mysql_fetch_array($result)) {
				if ($row[1]==$_SESSION['UserID']) {
					$content= "
					<div class='box border green' style='z-index:1; position:relative;'>
				    	<div class='box-title small'>
							<h4><i class='fa fa-code'></i><a idf='".$row[0]."'  style='text-decoration: none; color:white; cursor:pointer;' class='profile'>".$row[6]." ".$row[7]."</a></h4>
							<div class='pull-right'>
								<span class='timeclass pull-right'>
									<i class='fa fa-clock-o'></i>
									<span>".strftime("%d de %B",strtotime($row[3])) .", ".date("g:i a", strtotime($row[4]))."</span>
									<span>&nbsp;&nbsp;<span class='compose tip-left' title='Eliminar publicación'><i class='fa fa-times-circle delete-comment timeclass' title='Eliminar publicacion' idf='".$row[0]."' post-idf='".$row[7]."' onClick='delPost(this)'></i></span></span>
								</span>
							</div>
						</div>	
						<div class='box-body clearfix' style='word-wrap:break-word;'>
							<span>
								<div class='col-xs-2 col-md-1'> 
									<img class='img-perfil' src='../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
								</div>
								<div class='col-xs-8 col-md-10'>
									<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
										<h5>
											<span>".htmlentities($row[2],ENT_NOQUOTES,"UTF-8")."</span>
										</h5>
									</div>
								</div>
							</span>
						</div>	
					</div>";
				} else {
					$content="
					<div class='box border green' style='z-index:1; position:relative;'>
				    	<div class='box-title small'>
							<h4><i class='fa fa-code'></i>".$row[6]." ".$row[7]."</h4>
							<div class='pull-right'>
								<span class='timeclass pull-right'>
									<i class='fa fa-clock-o'></i>
									<span>".strftime("%d de %B",strtotime($row[3])) .", ".date("g:i a", strtotime($row[4]))."</span>
								</span>
							</div>
						</div>	
						<div class='box-body clearfix' style='word-wrap:break-word;'>
							<span>
								<div class='col-xs-2 col-md-1'> 
									<img class='img-perfil' src='../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
								</div>
								<div class='col-xs-8 col-md-10'>
									<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
										<h5>
											<span>".htmlentities($row[2],ENT_NOQUOTES,"UTF-8")."</span>
										</h5>
									</div>
								</div>
							</span>
						</div>	
					</div>";
				}
					
			}

			$query="SELECT postcomments.*, users.Name, users.Lastname FROM postcomments INNER JOIN users on users.UserID=postcomments.UserID WHERE postcomments.PostID='".$_GET['i']."' AND View='1' ORDER BY Date ASC, Time ASC";
			$result=mysql_query($query,$dbconn);

			$comment.="<div class='comment pull-right' style='border: solid 1px #cbcbcb; position: relative; width:95%; border-radius: 5px; margin-top: -25px;'>
						<div class='divide-20'></div>";

			while($row = mysql_fetch_array($result)){
				$postIDF=$row[6];
				$resPost=substr($postIDF, 0,20)	;

				if ($_SESSION['UserID']==$resPost) {
					$comment.="<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
								<span>
									<div class='adjust-img'>
										<img class='img-perfil' src='../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
									</div>
									<div class='col-xs-12 col-md-12'>
										<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
											<pre><a style='text-decoration: none;' href='../profile/index.php?user=".$row[1]."'><h5 class='comment-name' >"."  ".$row[7]." ".$row[8]."</a></h5><span class='pull-right comment-time'><i class='fa fa-clock-o'></i> ".strftime("%d de %B",strtotime($row[4])) .", ".date("g:i a", strtotime($row[5]))." "."<i class='fa fa-times-circle delete-comment' title='Eliminar comentario' idf='".$row[0]."' post-idf='".$row[6]."' onClick='delComment(this)'></i></span>".htmlentities($row[2],ENT_NOQUOTES,"UTF-8")."</pre>
										</div>
									</div>
								</span>
							</div>
							<div class='divide-15'></div>";
				} else {
					if ($_SESSION['UserID']==$row[1]) {
						$comment.="<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
								<span>
									<div class='adjust-img'>
										<img class='img-perfil' src='../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
									</div>
									<div class='col-xs-12 col-md-12'>
										<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
											<pre><a style='text-decoration: none;' href='../profile/index.php?user=".$row[1]."'><h5 class='comment-name' >"."  ".$row[7]." ".$row[8]."</a></h5><span class='pull-right comment-time'><i class='fa fa-clock-o'></i> ".strftime("%d de %B",strtotime($row[4])) .", ".date("g:i a", strtotime($row[5]))." "."<i class='fa fa-times-circle delete-comment' title='Eliminar comentario' idf='".$row[0]."' post-idf='".$row[6]."' onClick='delComment(this)'></i></span>".htmlentities($row[2],ENT_NOQUOTES,"UTF-8")."</pre>
										</div>
									</div>
								</span>
							</div>
							<div class='divide-15'></div>";
					} else {
						$comment.="<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
								<span>
									<div class='adjust-img'>
										<img class='img-perfil' src='../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
									</div>
									<div class='col-xs-12 col-md-12'>
										<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
											<pre><a style='text-decoration: none;' href='../profile/index.php?user=".$row[1]."'><h5 class='comment-name' >"."  ".$row[7]." ".$row[8]."</a></h5><span class='pull-right comment-time'><i class='fa fa-clock-o'></i> ".strftime("%d de %B",strtotime($row[4])) .", ".date("g:i a", strtotime($row[5]))."</span>".htmlentities($row[2],ENT_NOQUOTES,"UTF-8")."</pre>
										</div>
									</div>
								</span>
							</div>
							<div class='divide-15'></div>";
					}
				}
			}
			$comment.="<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
						<span>
							<div class='adjust-img'>
								<img class='img-perfil' src='../img/avatars/".$_SESSION['UserID'].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
							</div>
							<div class='col-xs-10 col-md-11'>
								<div class='col-xs-12 col-md-12'>
									<textarea style='padding: 1em;' class='comment-area ".$_GET['i']."' placeholder='Escribe un comentario...'></textarea>
									<div class='divide-10'></div>
								</div>
							</div>
							<div class='col-xs-1 col-md-1'>
								<div class='col-xs-12 col-md-12'>
									<button class='btn btn-primary comment-btn' idf='".$_GET['i']."' style='margin-left:-4.2em; margin-top:0em; height:3.7em;' onClick='postComment(this)' onKeyDown='enterPress(this)'>Post</button>
								</div>
							</div>
						</span>
					</div>
				</div>";			

		} elseif ($_GET['r']=='group') {
			$comment="";
			$query="SELECT post_group.*, users.Name, users.Lastname FROM post_group INNER JOIN users on users.UserID=post_group.UserID WHERE post_group.PostID='".$_GET['i']."' AND View='1' LIMIT 1";
			$result=mysql_query($query,$dbconn);
			$valid=mysql_num_rows($result);

			if ($valid=='0') {
				header('Location: ../error/404.html');
			}

			while ($row=mysql_fetch_array($result)) {
				if ($row[1]==$_SESSION['UserID']) {
					$content= "
					<div class='box border green' style='z-index:1; position:relative;'>
				    	<div class='box-title small'>
							<h4><i class='fa fa-code'></i><a idf='".$row[0]."'  style='text-decoration: none; color:white; cursor:pointer;' class='profile'>".$row[7]." ".$row[8]."</a></h4>
							<div class='pull-right'>
								<span class='timeclass pull-right'>
									<i class='fa fa-clock-o'></i>
									<span>".strftime("%d de %B",strtotime($row[4])) .", ".date("g:i a", strtotime($row[5]))."</span>
									<span>&nbsp;&nbsp;<span class='compose tip-left' title='Eliminar publicación'><i class='fa fa-times-circle delete-comment timeclass' title='Eliminar publicacion' idf='".$row[0]."' post-idf='".$row[7]."' onClick='delPost(this)'></i></span></span>
								</span>
							</div>
						</div>	
						<div class='box-body clearfix' style='word-wrap:break-word;'>
							<span>
								<div class='col-xs-2 col-md-1'> 
									<img class='img-perfil' src='../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
								</div>
								<div class='col-xs-8 col-md-10'>
									<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
										<h5>
											<span>".htmlentities($row[3],ENT_NOQUOTES,"UTF-8")."</span>
										</h5>
									</div>
								</div>
							</span>
						</div>	
					</div>";
				} else {
					$content="
					<div class='box border green' style='z-index:1; position:relative;'>
				    	<div class='box-title small'>
							<h4><i class='fa fa-code'></i>".$row[7]." ".$row[8]."</h4>
							<div class='pull-right'>
								<span class='timeclass pull-right'>
									<i class='fa fa-clock-o'></i>
									<span>".strftime("%d de %B",strtotime($row[4])) .", ".date("g:i a", strtotime($row[5]))."</span>
								</span>
							</div>
						</div>	
						<div class='box-body clearfix' style='word-wrap:break-word;'>
							<span>
								<div class='col-xs-2 col-md-1'> 
									<img class='img-perfil' src='../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
								</div>
								<div class='col-xs-8 col-md-10'>
									<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
										<h5>
											<span>".htmlentities($row[3],ENT_NOQUOTES,"UTF-8")."</span>
										</h5>
									</div>
								</div>
							</span>
						</div>	
					</div>";
				}
					
			}

			$query="SELECT postcomments_group.*, users.Name, users.Lastname FROM postcomments_group INNER JOIN users on users.UserID=postcomments_group.UserID WHERE postcomments_group.PostID='".$_GET['i']."' AND View='1' ORDER BY Date ASC, Time ASC";
			$result=mysql_query($query,$dbconn);

			$comment.="<div class='comment pull-right' style='border: solid 1px #cbcbcb; position: relative; width:95%; border-radius: 5px; margin-top: -25px;'>
						<div class='divide-20'></div>";

			while($row = mysql_fetch_array($result)){
				$postIDF=$row[6];
				$resPost=substr($postIDF, 0,20)	;

				if ($_SESSION['UserID']==$resPost) {
					$comment.="<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
								<span>
									<div class='adjust-img'>
										<img class='img-perfil' src='../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
									</div>
									<div class='col-xs-12 col-md-12'>
										<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
											<pre><a style='text-decoration: none;' href='../profile/index.php?user=".$row[1]."'><h5 class='comment-name' >"."  ".$row[7]." ".$row[8]."</a></h5><span class='pull-right comment-time'><i class='fa fa-clock-o'></i> ".strftime("%d de %B",strtotime($row[4])) .", ".date("g:i a", strtotime($row[5]))." "."<i class='fa fa-times-circle delete-comment' title='Eliminar comentario' idf='".$row[0]."' post-idf='".$row[6]."' onClick='delComment(this)'></i></span>".htmlentities($row[2],ENT_NOQUOTES,"UTF-8")."</pre>
										</div>
									</div>
								</span>
							</div>
							<div class='divide-15'></div>";
				} else {
					if ($_SESSION['UserID']==$row[1]) {
						$comment.="<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
								<span>
									<div class='adjust-img'>
										<img class='img-perfil' src='../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
									</div>
									<div class='col-xs-12 col-md-12'>
										<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
											<pre><a style='text-decoration: none;' href='../profile/index.php?user=".$row[1]."'><h5 class='comment-name' >"."  ".$row[7]." ".$row[8]."</a></h5><span class='pull-right comment-time'><i class='fa fa-clock-o'></i> ".strftime("%d de %B",strtotime($row[4])) .", ".date("g:i a", strtotime($row[5]))." "."<i class='fa fa-times-circle delete-comment' title='Eliminar comentario' idf='".$row[0]."' post-idf='".$row[6]."' onClick='delComment(this)'></i></span>".htmlentities($row[2],ENT_NOQUOTES,"UTF-8")."</pre>
										</div>
									</div>
								</span>
							</div>
							<div class='divide-15'></div>";
					} else {
						$comment.="<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
								<span>
									<div class='adjust-img'>
										<img class='img-perfil' src='../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
									</div>
									<div class='col-xs-12 col-md-12'>
										<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
											<pre><a style='text-decoration: none;' href='../profile/index.php?user=".$row[1]."'><h5 class='comment-name' >"."  ".$row[7]." ".$row[8]."</a></h5><span class='pull-right comment-time'><i class='fa fa-clock-o'></i> ".strftime("%d de %B",strtotime($row[4])) .", ".date("g:i a", strtotime($row[5]))."</span>".htmlentities($row[2],ENT_NOQUOTES,"UTF-8")."</pre>
										</div>
									</div>
								</span>
							</div>
							<div class='divide-15'></div>";
					}
				}
			}
			$comment.="<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
						<span>
							<div class='adjust-img'>
								<img class='img-perfil' src='../img/avatars/".$_SESSION['UserID'].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
							</div>
							<div class='col-xs-10 col-md-11'>
								<div class='col-xs-12 col-md-12'>
									<textarea style='padding: 1em;' class='comment-area ".$_GET['i']."' placeholder='Escribe un comentario...'></textarea>
									<div class='divide-10'></div>
								</div>
							</div>
							<div class='col-xs-1 col-md-1'>
								<div class='col-xs-12 col-md-12'>
									<button class='btn btn-primary comment-btn' idf='".$_GET['i']."' style='margin-left:-4.2em; margin-top:0em; height:3.7em;' onClick='postComment(this)' onKeyDown='enterPress(this)'>Post</button>
								</div>
							</div>
						</span>
					</div>
				</div>";			
			
		} else{
			header('Location: ../error/404.html');
		}
		
	} else {
		header('Location: ../error/404.html');
	}

	require("../SQLFunc.php");
?>	
<!DOCTYPE html>
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
<body>
<div class="overlay-content" id='loader-div'>
	<center><p class="overlay-icon"><i class="fa fa-spinner fa-spin"></i></p></center>
</div>
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
			<!-- Notifications -->
			<li class="dropdown" id="header-notification">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-bell"></i>
					<span class="badge"><?php echo numberNotifications();?></span>						
				</a>
				<ul class="dropdown-menu notification" id="notifications">
					<li class="dropdown-title">
						<span><i class="fa fa-bell"></i>Notificaciones</span>
					</li>
					<?php
					notifList();
					?>
					<li class="footer">
						<a href="../notifications/">Todas las notificaciones <i class="fa fa-arrow-circle-right"></i></a>
					</li>
				</ul>
			</li>
			<!-- /Notifications -->
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
						} else {
							echo "";
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
								<i class="fa fa-file-text fa-fw"></i><span class="menu-text">EDitor de Código
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
										<a href="../notifications/">Notificaciones</a>
									</li>
									<li>
										<a href="#">Revisión de contenido</a>
									</li>
								</ul>
								<!-- /BREADCRUMBS -->
								<div class="clearfix">
									<h3 class="content-title pull-left">
										Revisión de contenido
									</h3>
								</div>
							</div>
						</div>
					</div>
					<!-- /Header de contenido -->
					<div class="row">
						<div class="col-xs-12 col-md-12 pull-right">
						<?php 
							echo $content; 
							echo $comment;
						?>
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
<script type="text/javascript">
		function postComment(e){
		var idf=$("."+$(e).attr("idf")).val();
		var postIdf=$(e).attr("idf");

		if(idf!=""){
	       $.post("userActions.php", 
	              {contents: idf, postidf: postIdf, action: "postComment"},
	              function() {
	                  location.reload();
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

	$( "#searchbar" ).keyup(function(){
		var text = $( "#searchbar" ).val();
		var text2=$.trim(text);

		if (text2!="" && text.length>2) {
			getData('cons.php', 'targetDiv',tag());
		} else {
			$("#targetDiv").html("");
		};
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