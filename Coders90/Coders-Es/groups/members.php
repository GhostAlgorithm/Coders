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

	include("../BDD.php");
	$query="SELECT groups.*, users.UserID, users.Name, users.LastName FROM groups INNER JOIN users ON groups.UserID = users.UserID WHERE groups.GroupID='".$_GET['group']."'";	
	$result=mysql_query($query,$dbconn);

	while($row=mysql_fetch_array($result)){
		$gName=$row[1];
		$gColor=$row[5];
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
					data-icon2="fa fa-bars" ></i>
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
										<a href="../groups/dashboard.php?group=<?php echo $_GET['group'];?>"><?php echo $gName;?></a>
									</li>
									<li>
										<a href="#">Miembros</a>
									</li>
								</ul>
								<!-- /BREADCRUMBS -->
								<div class="clearfix">
									<h3 class="content-title pull-left">
										Miembros de <?php echo $gName;?>
									</h3>
								</div>
							</div>
						</div>
					</div>
					<!-- /Header de contenido -->
					<!-- Contenido general -->
					<div class="row">
						<div class="col-xs-12 col-md-12 pull-right">
						<div class="box">
					    	<div class="box-title small">
								<h4><i class="fa fa-user"></i><i class="fa fa-arrow-right"></i><i class="fa fa-group"></i>Agregar miembros al grupo</h4>
							</div>
						</div>
						<div class="col-xs-12 col-md-12">
							<div class="input-group search-admin col-xs-12 col-md-9 pull-left">
								<span class="input-group-addon"><i class="fa fa-search"></i></span>
								<input type="text" id="searchbar-members" class="form-control" autocomplete="off" placeholder="Nombre - Apellido - Email"/>
							</div>
							<div class="divide-15 visible-xs"></div>
							<div class="col-xs-12 col-md-2 pull-right">
								<button class="btn btn-primary disabled=" id="addMembers" disabled>Agregar</button>
							</div>
						</div>
						<div id="targetDivMembers" class="search-div search-box" style="margin-top:2.75em; width:70%"></div>
						<div id="new-members">
							<div class="divide-15"></div>
						</div>
						<div class="divide-25"></div>
						<div class="box">
					    	<div class="box-title small">
								<h4><i class="fa fa-group"></i>Miembros actuales</h4>
							</div>
						</div>
						<?php 
							$query="SELECT user_group.UserID, users.Name, users.LastName FROM user_group INNER JOIN users ON users.UserID=user_group.UserID WHERE user_group.GroupID='".$_GET['group']."' ORDER BY Name ASC";	
							$result=mysql_query($query,$dbconn);
							$total=mysql_num_rows($result);

							while ($row=mysql_fetch_array($result)) {
								if ($idCreator==$_SESSION['UserID']) {
									if($row[0]==$_SESSION['UserID']){
										echo "<div class='col-md-3 col-xs-6 col-lg-2 user-container'>
											<a href='../profile/?user=".$row[0]."' class='styleLess'><img class='member-img' alt='' src='../img/avatars/".$row[0].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\"/>
											<h5>".$row[1]." ".$row[2]."</h5></a>
											<button class='btn btn-xs btn-info disabled' id='btnEliminar'>Tú (Administrador)</button>
										</div>";
 									} else {
 										echo "<div class='col-md-3 col-xs-6 col-lg-2 user-container'>
											<a href='../profile/?user=".$row[0]."' class='styleLess'><img class='member-img' alt='' src='../img/avatars/".$row[0].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\"/>
											<h5>".$row[1]." ".$row[2]."</h5></a>
											<button class='btn btn-xs btn-info' id='btnEliminar' u='".$row[0]."' onClick='delUser(this)'>Eliminar</button>
										</div>";
 									}
								} else {
									if($row[0]==$idCreator){
										echo "<div class='col-md-3 col-xs-6 col-lg-2 user-container'>
											<a href='../profile/?user=".$row[0]."' class='styleLess'><img class='member-img' alt='' src='../img/avatars/".$row[0].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\"/>
											<h5>".$row[1]." ".$row[2]."</h5>
											<button class='btn btn-xs btn-info disabled'>Administrador</button></a>
										</div>";
									} else {
										if ($row[0]==$_SESSION['UserID']) {
											echo "<div class='col-md-3 col-xs-6 col-lg-2 user-container'>
												<a href='../profile/' class='styleLess'><img class='member-img' alt='' src='../img/avatars/".$row[0].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\"/>
												<h5>".$row[1]." ".$row[2]."</h5>
												<button class='btn btn-xs btn-info'>Tú</button></a>
											</div>";
										} else {
											echo "<div class='col-md-3 col-xs-6 col-lg-2 user-container'>
												<a href='../profile/?user=".$row[0]."' class='styleLess'><img class='member-img' alt='' src='../img/avatars/".$row[0].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\"/>
												<h5>".$row[1]." ".$row[2]."</h5>
												<button class='btn btn-xs btn-info'>Ver perfil</button></a>
											</div>";
										}
									}
								}
							}

						?>
						</div>
					</div>
					<!-- /Contenido general --> 
				</div>
			</div>
		</div>
	</div>
</section>
<div id="dialog-confirm-user" title="Coders" style="display:none">
  <p><h3><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></h3></span>¿Realmente desea eliminar a este usuario de <?php echo $gName;?>?</p>
</div>
<!-- Core Bootstrap-->
<!--/PAGE -->
<!-- JAVASCRIPTS -->
<!-- JQUERY -->
<script type="text/javascript">
	var arrayUser=new Array();
	var index=0;

	$( "#searchbar" ).keyup(function(){
		var text = $( "#searchbar" ).val();
		var text2=$.trim(text);

		if (text2!="" && text.length>2) {
			getData('cons.php', 'targetDiv',tag());
		} else {
			$("#targetDiv").html("");
		};
	});

	function delUser(e){
		$(".btn, .btn-xs, .btn-info").attr("disabled","true");
		$(".btn, .btn-xs, .btn-info").addClass("disabled");
		$( "#dialog-confirm-user" ).dialog({
	      resizable: false,
	      height:200,
	      width: 400,
	      modal: true,
	      buttons: {
	        "Eliminar ": function (){
	            $( this ).dialog( "close" );
	            $("#loader-div").css({ display: "block", });
	            var user=$(e).attr("u");
	            $.post("userActions.php", 
		              {idf: user, action: "delUser", group: "<?php echo $_GET['group'];?>"},
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

	$( "#searchbar-members" ).keyup(function(){
		var text = $( "#searchbar-members" ).val();
		var text2=$.trim(text);

		if (text2!="" && text.length>2) {
			$.ajax({
                data:  {action: "searchUser", tag: text2},
                url:   'userActions.php',
                dataType: "html",
                type:  'post',
                success:  function (response) {
                	$("#targetDivMembers").html(response);
                }
            });
		} else {
			$("#targetDivMembers").html("");
		};
	});

	$("#targetDivMembers").on('click','a',function(){
		var identifier=$(this).attr("idf");
		var name=$(this).attr("n");

		if ($("#"+identifier).length){
			$("#targetDivMembers").html("");
			$("#searchbar-members").val("");
			return false;
		} else {
			$("#new-members").before("<span style='margin-top:7px; text-align:left;' class='label label-info spacer-7 col-xs-6 col-md-3' id='"+identifier+"'><i class='fa fa-times' idf='"+identifier+"' onClick='delMember(this)'></i> "+name+"</span>")
			$("#targetDivMembers").html("");
			$("#searchbar-members").val("");
			index=arrayUser.length;
			arrayUser[index]=identifier;
			if (arrayUser.length==0) {
				$("#addMembers").attr("disabled",true);
				$("#addMembers").addClass("disabled");
			} else {
				$("#addMembers").attr("disabled",false);
				$("#addMembers").removeClass("disable");
			}
		}
	});

	function delMember(e){
		var idf=$(e).attr("idf");
		$("#"+	idf).remove();
		removeArray(idf);
	}

	$("#addMembers").click(function(index){
		$("#loader-div").css({ display: "block", });
		$.post("userActions.php", 
			{idf: arrayUser, action: "newMembers", group: "<?php echo $_GET['group'];?>"},
			function() {
				  location.reload();
			}
        );
	});

	function removeArray(id){
		arrayUser.splice($.inArray(id, arrayUser),1);
		if (arrayUser.length==0) {
			$("#addMembers").attr("disabled",true);
			$("#addMembers").addClass("disabled");
		}else {
			$("#addMembers").attr("disabled",false);
			$("#addMembers").removeClass("disable");
		}
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