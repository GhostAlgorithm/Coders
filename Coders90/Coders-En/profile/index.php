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
	session_save_path("../sessions/");
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

	if(isset($_GET['user'])){
		include("../BDD.php");
		$query="SELECT * FROM users where UserID='".$_GET['user']."'";
		$preValid=mysql_query($query,$dbconn);
		$valid=mysql_num_rows($preValid);

		if ($valid==0) {
			header('Location: ../error/404.html');
		}
		if ($_GET['user']!=$_SESSION['UserID']) {

			$query="SELECT * FROM following WHERE UserID='".$_GET['user']."' AND FollowerID='".$_SESSION['UserID']."'";
			$preValid=mysql_query($query,$dbconn);
			$valid=mysql_num_rows($preValid);

			if ($valid==0) {
				$btn="<button class='btn btn-success' id='btnFollow'>Seguir</button></h1>";
			} else {
				$btn="<button class='btn btn-danger' id='btnUnfollow'>Dejar de seguir</button></h1>";
			}
		}
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

	require("../SQLFunc.php");
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
			<!-- Notifications -->
			<li class="dropdown" id="header-notification">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-bell"></i>
					<span class="badge"><?php echo numberNotifications();?></span>						
				</a>
				<ul class="dropdown-menu notification" id="notifications">
					<li class="dropdown-title">
						<span><i class="fa fa-bell"></i>Notifications</span>
					</li>
					<?php
					notifList();
					?>
					<li class="footer">
						<a href="../notifications/">See all notifications  <i class="fa fa-arrow-circle-right"></i></a>
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
						<li><a href="../profile/"><i class="fa fa-user"></i> My Profil</a></li>
						<?php 
							if ($_SESSION['Admin']=="1") {
								echo"<li><a href='../admin/dashboard/'><i class='fa fa-wrench'></i> Administration Panel </a></li>";
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
						<input type="text" id="searchbar" class="search" placeholder="Name - Last Name - Email" autocomplete="off"><i class="fa fa-search search-icon"></i>
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
								<i class="fa fa-envelope fa-fw"></i><span class="menu-text">Messages
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
					<!-- Contenido general -->
					<div class="row">
						<section class="col-md-12 header">
						<div class="col-md-4 col-xs-12 imagen">
							<div class="divide-75"></div>
						<center><img alt="" class="avatar" src="../img/avatars/<?php echo $user;?>.jpg" onerror="this.src='../img/avatars/default.jpg'" height="200" width="200"/></center> 	
						</div>
						<div class="col-md-8 col-xs-12 clearfix informacion">
							<div class="divide-25 hidden-xs hidden-md hidden-sm"></div>
						<span>
							<h1 class="nombre-usuario"><?php echo $userName." ".$userLast;?>
							<?php if (isset($btn)){ echo $btn;};?> 
						</span>
						<h4 class="miembro-desde">Member since: April 2014</h4>
						<br>
						<br>
						<div class="col-lg-offset-1 datos">
						<h3 class="publicaciones">
							<?php echo $PostCount;?><br>
							Post
						</h3>
						<h3 class="seguidos">
							<?php echo $Following;?><br>
							Following
						</h3>
						<h3 class="seguidores">
							<?php echo $Followers;?><br>
							Followers
						</h3>
						</div>
						</div>
						</section>										
					<div id="myFeed" class="col-md-12 col-xs-12 pull-right cleafix">
					<div class="divide-20"></div>
					<div class="box">
				    	<div class="box-title small">
							<h4><i class="fa fa-edit"></i>post</h4>
						</div>
					</div>
                    <?php 
                        myFeed($user);
                    ?>
                    </div>
				</div>
			</div>
		</div>
	</div>
</section>
<div id="dialog-confirm-comment" title="Coders" style="display:none">
  <p><h3><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></h3></span>Are you sure you want to delete this?</p>
</div>
<div id="dialog-confirm-post" title="Coders" style="display:none">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><br>Are you sure you want to delete this?</p>
</div>
<!-- Core Bootstrap-->
<!--/PAGE -->
<!-- JAVASCRIPTS -->
<script type="text/javascript">
var idf=null;

$( ".fa-comments" ).click(function() {
	var idf = $(this).attr("idf");
	getData('comments.php',idf,idf);				
});

function postComment(e){
	var idf=$("."+$(e).attr("idf")).val();
	var postIdf=$(e).attr("idf");

	if(idf!=""){
       $.post("userActions.php", 
              {contents: idf, postidf: postIdf, action: "postComment"},
              function() {
                  getData('comments.php',postIdf,postIdf);
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
	              	  getData('comments.php',postIdf,postIdf);
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

$( "#btnFollow" ).click(function(){
	$.post("userActions.php", 
          {idf: "<?php echo $_GET['user'];?>", action: "follow"},
          function() {
          	  location.reload();
          }
    );
});

$( "#btnUnfollow" ).click(function(){
	$.post("userActions.php", 
          {idf: "<?php echo $_GET['user'];?>", action: "unfollow"},
          function() {
          	  location.reload();
          }
    );
});

</script>
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