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
	if(!isset($_SESSION["UserID"]) && $_SESSION["Admin"]!="1"){
		header("Location: ../../");
	} elseif ($_SESSION["Admin"]!="1") {
		header("Location: ../../dashboard/");
	}

	include("../../BDD.php");

	if (isset($_POST['visiblePost'])) {
		$query="UPDATE post SET View='0' WHERE PostID='".$_GET['postIdf']."'";
		echo $query;
		$resultVisible=mysql_query($query,$dbconn);

		if ($resultVisible) {
			header("Location: postActions.php?postIdf=".$_GET['postIdf']."&chg=1");
		} else {
			header("Location: postActions.php?postIdf=".$_GET['postIdf']."&chg=0");
		}

	}

	if (isset($_POST['noVisiblePost'])) {
		$query="UPDATE post SET View='1' WHERE PostID='".$_GET['postIdf']."'";
		$resultNoVisible=mysql_query($query,$dbconn);

		if ($resultNoVisible) {
			header("Location: postActions.php?postIdf=".$_GET['postIdf']."&chg=1");
		} else {
			header("Location: postActions.php?postIdf=".$_GET['postIdf']."&chg=0");
		}
	}

	if (isset($_POST['showComments'])) {
		$showIdf=$_POST['commentIdf'];
		$total=count($showIdf);

		for ($i=0; $i < $total; $i++) { 
			$query="UPDATE postcomments SET View='1' WHERE CommentID='".$showIdf[$i]."'";
			$result=mysql_query($query,$dbconn);
		}

		if ($result) {
			header("Location: postActions.php?postIdf=".$_GET['postIdf']."&chg=1");
		} else {
			header("Location: postActions.php?postIdf=".$_GET['postIdf']."&chg=0");
		}
	}

	if (isset($_POST['delComments'])) {
		$delIdf=$_POST['commentIdf'];
		$total=count($delIdf);

		for ($i=0; $i < $total; $i++) { 
			$query="UPDATE postcomments SET View='0' WHERE CommentID='".$delIdf[$i]."'";
			$result=mysql_query($query,$dbconn);
		}

		if ($result) {
			header("Location: postActions.php?postIdf=".$_GET['postIdf']."&chg=1");
		} else {
			header("Location: postActions.php?postIdf=".$_GET['postIdf']."&chg=0");
		}
	}

	$query="SELECT post.*, users.Name, users.LastName FROM post INNER JOIN users ON users.UserID = post.UserID WHERE post.PostID='".$_GET['postIdf']."'";
	$result=mysql_query($query,$dbconn);

	while ($row=mysql_fetch_array($result)) {
		$userId=$row[1];
		$fn=$row[6];
		$ln=$row[7];
		$cont=htmlentities($row[2],ENT_NOQUOTES,"UTF-8");
		$date=date("d/m/Y", strtotime($row[3]));
		$hour=date("g:i a", strtotime($row[4]));
		if ($row[5]=="1") {
			$state="Visible";
			$editForm="<input type='submit' name='visiblePost' class='btn btn-danger btn-xs pull-right btnSpace' value='Hide Post'>";
		} else {
			$state="No visible (Eliminado)";
			$editForm="<input type='submit' name='noVisiblePost' class='btn btn-success btn-xs pull-right btnSpace' value='Show Post'>";
		}
		
	}

	$query="SELECT * from postcomments WHERE PostID='".$_GET['postIdf']."'";
	$result=mysql_query($query,$dbconn);
	$totalComments=mysql_num_rows($result);
	
	$query="SELECT * from postcomments WHERE View='0' AND PostID='".$_GET['postIdf']."'";
	$result=mysql_query($query,$dbconn);
	$noVisibleComments=mysql_num_rows($result);
	$VisibleComments=($totalComments-$noVisibleComments);


	if ($totalComments!=0) {
		$selComments="<div class='pull-right'>
				<input type='checkbox' id='selPost' name='selPost'><label for='selPost' class='labelMargin'>Seleccionar todos los comentarios</label>
			</div>
		</div>
		<form method='POST' action='postActions.php?postIdf=".$_GET['postIdf']."'>
			<div class='col-xs-12 col-md-4'>
					<input type='submit' name='showComments' class='btn btn-success btn-xs pull-right btnSpace' value='Show Comments'>
					<input type='submit' name='delComments' class='btn btn-danger btn-xs pull-right btnSpace' value='Hide Comments'>
			</div>
			<div class='col-xs-12 col-md-12' >
				<div class='divide-20'></div>
				<div class='box-body clearfix adjust-text' style='word-wrap:break-word;z-index:2; position: relative;'>
					<span>
						<div class='adjust-img-post'>
							<img class='img-perfil' src='../../img/avatars/".$userId.".jpg' onerror=\'this.src='../img/avatars/default.jpg'\' width='50' height='50'>
						</div>
						<pre style='background-color: white;'><a style='text-decoration: none;'><h5 class='comment-name' style='margin-left:10px;'>".$fn." ".$ln."</h5></a><span class='pull-right comment-time'><i class='fa fa-clock-o'></i>".$date." a las ".$hour."</span>".$cont."</pre>
					</span>
				</div>";
	} else {
		$selComments="<div class='pull-right'>
				<input type='checkbox' id='selPost' name='selPost' disabled><label for='selPost' class='labelMargin'>Seleccionar todos los comentarios</label>
			</div>
		</div>
		<form method='POST' action='postActions.php?postIdf=".$_GET['postIdf']."'>
			<div class='col-xs-12 col-md-4'>
					<input type='submit' name='showComments' class='btn btn-success btn-xs pull-right btnSpace' value='Show Comments' disabled>
					<input type='submit' name='delComments' class='btn btn-danger btn-xs pull-right btnSpace' value='Hide Comments' disabled>
			</div>
			<div class='col-xs-12 col-md-12' >
				<div class='divide-20'></div>
				<div class='box-body clearfix adjust-text' style='word-wrap:break-word;z-index:2; position: relative;'>
					<span>
						<div class='adjust-img-post'>
							<img class='img-perfil' src='../../img/avatars/".$userId.".jpg' onerror=\'this.src='../img/avatars/default.jpg'\' width='50' height='50'>
						</div>
						<pre style='background-color: white;'><a style='text-decoration: none;'><h5 class='comment-name' style='margin-left:10px;'>".$fn." ".$ln."</h5></a><span class='pull-right comment-time'><i class='fa fa-clock-o'></i>".$date." a las ".$hour."</span>".$cont."</pre>
					</span>
				</div>";
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
						<li><a href="#"><i class="fa fa-user"></i> My Profile</a></li>
						<li><a href="../../dashboard/"><i class="fa fa-tachometer"></i> IGo to Dashboard</a></li>
						<li><a href="../../logout/index.php"><i class="fa fa-power-off"></i> Log Out</a></li>
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
				<input type="text" id="searchbar" class="search" autocomplete="off" placeholder="Name - Last Name - Email"><i class="fa fa-search search-icon"></i>
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
										<a href="../dashboard/">Administration Panel</a>
									</li>
									<li>
										<a href="../post/actions.php?user=<?php echo $userId;?>">Posts by <?php echo $fn." ".$ln;?></a>
									</li>
									<li>
										<a href="#">Details</a>
									</li>
								</ul>
								<!-- /BREADCRUMBS -->
								<div class="clearfix">
									<h3 class="content-title pull-left">
										<span><</span>
										<span>CODERS</span>
										<span>/</span>
										<span>></span>
										 - Administration Panel - Posts
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
							if(isset($_GET["chg"])){
								if ($_GET["chg"]==1) {
									echo"<div class='alert alert-success col-xs-12 col-md-12'>Data has been successfully updated</div>";
								} else {
									echo"<div class='alert alert-danger col-xs-12 col-md-12'>There was an error updating the data, try again :( </div>";
								}
							}
							?>
						</div>
						<div class="col-xs-12 col-md-12" >
							<div class="col-xs-12 col-md-2" >
								<strong><h5>Created by:</h5></strong>
							</div>
							<div class="col-xs-12 col-md-10">
								<h5><?php echo "  ".$fn." ".$ln." (".$userId.")"?></h5>
							</div>
							<div class="col-xs-12 col-md-2" >
								<strong><h5>Date and Time:</h5></strong>
							</div>
							<div class="col-xs-12 col-md-10">
								<h5><?php echo $date." a las ".$hour;?></h5>
							</div>
							<div class="col-xs-12 col-md-2" >
								<strong><h5>State:</h5></strong>
							</div>
							<div class="col-xs-12 col-md-10">
								<h5><?php echo $state;?></h5>
							</div>
							<div class="col-xs-12 col-md-2" >
								<strong><h5>Comments:</h5></strong>
							</div>
							<div class="col-xs-12 col-md-10">
								<h5><?php echo $totalComments." comentarios (".$VisibleComments." visibles y ".$noVisibleComments." no visible)"?></h5>
							</div>
						</div>
						<div class="col-xs-12 col-md-12" >
							<div class="divide-20"></div>
							<div class="divide-20"></div>
						</div>
						<div class="col-xs-12 col-md-2">
							<form method="POST" action="postActions.php?postIdf=<?php echo $_GET['postIdf'];?>">
								<?php echo $editForm;?>
							</form>
						</div>
						<div class="col-xs-12 col-md-6">
							<?php echo $selComments;?>
								<div class="comments pull-right">
								<div class="divide-15"></div>
								<div class="divide-20"></div>
								<?php 
									include("../../BDD.php");
									$query="SELECT postcomments.*, users.Name, users.LastName FROM postcomments INNER JOIN users ON users.UserID = postcomments.UserID WHERE postcomments.PostID='".$_GET['postIdf']."'";
									$result=mysql_query($query,$dbconn);

									while ($row=mysql_fetch_array($result)) {

											if ($row[3]==1) {
												echo "<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
														<span>
															<div class='adjust-img'>
																<img class='img-perfil' src='../../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
															</div>
															<div class='col-xs-12 col-md-12'>
																<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
																	<pre class='visible'><a style='text-decoration: none;' href='../profile/index.php?user=".$row[1]."'><h5 class='comment-name' >"."  ".$row[7]." ".$row[8]."</a></h5><span class='pull-right comment-time'><i class='fa fa-clock-o'></i> ".date("d/m/Y", strtotime($row[4])) ." a las ".date("g:i a", strtotime($row[5]))." "."<input type='checkbox' name='commentIdf[]' value='".$row[0]."'></span>".htmlentities($row[2],ENT_NOQUOTES,"UTF-8")."</pre>
																</div>
															</div>
														</span>
													</div>
													<div class='divide-15'></div>";
											} else {
												echo "<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
														<span>
															<div class='adjust-img'>
																<img class='img-perfil' src='../../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
															</div>
															<div class='col-xs-12 col-md-12'>
																<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
																	<pre class='no-visible'><a style='text-decoration: none;' href='../profile/index.php?user=".$row[1]."'><h5 class='comment-name' >"."  ".$row[7]." ".$row[8]."</a></h5><span class='pull-right comment-time'><i class='fa fa-clock-o'></i> ".date("d/m/Y", strtotime($row[4])) ." a las ".date("g:i a", strtotime($row[5]))." "."<input type='checkbox' name='commentIdf[]' value='".$row[0]."'></span>".htmlentities($row[2],ENT_NOQUOTES,"UTF-8")."</pre>
																</div>
															</div>
														</span>
													</div>
													<div class='divide-15'></div>";
											}

									}
								?>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$("#selPost").click(function(){
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
