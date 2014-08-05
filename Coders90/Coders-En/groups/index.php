<?php
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['UserID'])){
		header('Location: ../');
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
	<script type="text/javascript">
		
	$(function() {
		var dialog = $( "#new-dialog" ).dialog({
			  autoOpen: false,
			  modal: true,
			  buttons: {
			    Create: function() {
			    	if ($("#groupName").val()!="") {
			    		var gName=$("#groupName").val();
				    	var gContent=$("#groupContent").val();
				    	var gTheme=$("#groupColor").val();

				      	$.post("userActions.php", 
				              {name: gName, content: gContent, theme: gTheme, action: "create"},
				              function() {
				              	location.href="../groups/"
				              }
			        	);
			    	} else{
			    		$("#groupName").attr("placeholder", "Type a name");
				    	$("#groupName").css({ border: "solid 1px red", });
			    	};
			    },
			    Cancel: function() {
			      $( this ).dialog( "close" );
			    }
			  },
			  Close: function() {
			    form[ 0 ].reset();
			  }
			});

		$( "#newGroup" )
		  .button()
		  .click(function() {
		  	dialog.dialog( "open" );
		  });

		$("#groupName").focus(function () {
			$("#groupName").css({ border: "solid 1px #aaaaaa"});
			$("#groupName").attr("placeholder", "");	
		})
	});
	</script>
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
					<li><a href="../profile/"><i class="fa fa-user"></i> My Profile</a></li>
					<?php 
						if ($_SESSION['Admin']=="1") {
							echo"<li><a href='../admin/dashboard/'><i class='fa fa-wrench'></i> Administration Panel</a></li>";
						}
					?>
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
				<input type="text" id="searchbar" class="search" autocomplete="off" placeholder="Name - Last Name - Email"><i class="fa fa-search search-icon"></i>
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
						<i class="fa fa-calendar fa-fw"></i><span class="menu-text">Planner
						</span>
					</a>
				</li>
				<li>
					<a href="../editor/">
						<i class="fa fa-file-text fa-fw"></i><span class="menu-text">Code Editor
						</span>
					</a>
				</li>
				<li>
					<a href="../groups/">
						<i class="fa fa-group fa-fw"></i><span class="menu-text">Groups
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
										<a href="">Groups</a>
									</li>
								</ul>
								<!-- /BREADCRUMBS -->
								<div class="clearfix">
									<h3 class="content-title pull-left">
										Groups
									</h3>
									<span><button class="btn btn-info btn-group pull-right" id="newGroup">Create Group</button></span>
								</div>
							</div>
						</div>
					</div>
					<!-- /Header de contenido -->
					<!-- Contenido general -->
					<div class="row">
						<div class="col-xs-12 col-md-12">
							<div class="box">
						    	<div class="box-title small">
									<h4><i class="fa fa-search"></i>Search for groups</h4>
								</div>
							</div>
							<div class="col-xs-12 col-md-10 col-md-offset-1">
								<div class="input-group search-admin">
									<span class="input-group-addon"><i class="fa fa-search"></i></span>
									<input type="text" id="searchbar-admin" class="form-control"  autocomplete="off" placeholder="Groups"/>
								</div>
								<div id="targetDivGroups" class="search-div search-box">
								</div>
								<div class="divide-40"></div>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="box">
						    	<div class="box-title small">
									<h4><i class="fa fa-group"></i>My Groups</h4>
								</div>
							</div>
							<?php 
								require("../SQLFunc.php");
								myOwnGroups();
							?>
						</div>
						
						<div class="col-xs-12 col-md-6">
							<div class="box">
						    	<div class="box-title small">
									<h4><i class="fa fa-user"></i><i class="fa fa-arrow-right"></i><i class="fa fa-group"></i>Groups I belong to</h4>
								</div>
							</div>
							<?php 
								myGroups();
							?>
						</div>					
					</div>
					<div id="new-dialog" title="New Group">
					  <form>
					    <fieldset class="ui-helper-reset">
					      <label for="groupName">Name:</label>
					      <input type="text" name="groupName" id="groupName" autocomplete="off" style="display:block" class="ui-widget-content ui-corner-all">
					      <label for="groupContent">Programming Language:</label>
					      <select name="groupContent" id="groupContent" class="ui-widget-content ui-corner-all">
					        <option value="C">C</option>
							<option value="C#">C#</option>
							<option value="C++">C++</option>
							<option value="CSS">CSS</option>
							<option value="Delphi">Delphi</option>
							<option value="HTML">HTML</option>
							<option value="Java">Java</option>
							<option value="Javascript">Javascript</option>
							<option value="Perl">Perl</option>
							<option value="PHP">PHP</option>
							<option value="Python">Python</option>
							<option value="Transact-SQL">Transact-SQL</option>
							<option value="Visual Basic">Visual Basic</option>
							<option value="Visual Basic .NET">Visual Basic .NET</option>
							<option value="Otro">Otro</option>
					      </select>
					      <label for="groupColor">Choose a theme:</label>
					      <select name="groupColor" id="groupColor" style="display:block" class="ui-widget-content ui-corner-all">
					      	<option value="E74C3C" style="background-color:#E74C3C; color: white;">Alizarin</option>
					      	<option value="E67E22" style="background-color:#E67E22; color: white;">Carrot</option>
					      	<option value="F1C40F" style="background-color:#F1C40F; color: white;">Sun Flower</option>
					      	<option value="1ABC9C" style="background-color:#1ABC9C; color: white;">Turquoise</option>
					      	<option value="2ECC71" style="background-color:#2ECC71; color: white;">Emeral</option>
					      	<option value="3498DB" style="background-color:#3498DB; color: white;">Peter River</option>
					      	<option value="9B59B6" style="background-color:#9B59B6; color: white;">Amethyst</option>
					      	<option value="95A5A6" style="background-color:#95A5A6; color: white;">Concrete</option>
					      	<option value="34495E" style="background-color:#34495E; color: white;">Wet Asphalt</option>
					      </select>
					    </fieldset>
					  </form>
					</div>
					<!-- /Contenido general --> 
				</div>
			</div>
		</div>
	</div>
</section>
<!-- JAVASCRIPTS -->
<!-- AJAX -->
<script src="../Func.js"></script>
<script type="text/javascript">
	
	$( "#searchbar-admin" ).keyup(function(){
		var text = $( "#searchbar-admin" ).val();
		var text2=$.trim(text);

		if (text2!="" && text.length>2) {
			getData('cons3.php', 'targetDivGroups',tagAdmin());
		} else {
			$("#targetDivGroups").html("");
		};
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


</script>
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
