<?php
	session_save_path("../sessions/");
	session_start();
	error_reporting(0);
	if(!isset($_SESSION['UserID'])){
		header('Location: ../');
	}

	if (isset($_GET['id']) && isset($_GET['type'])) {
		$esp="false";
		$type=$_GET['type'];
		$Html = strpos($_GET['id'], ".html");
	  	$Htm = strpos($_GET['id'], ".htm");
	  	$Css = strpos($_GET['id'], ".css");
	  	$Js = strpos($_GET['id'], ".js");

	  	if ($Html==false && $Htm==false && $Css==false && $Js==false) {
	  		$esp="true";
	  	}

	  	$path="codefiles/".$_SESSION['UserID']."/".$_GET['id']."";

	  	if (!file_exists($path)) {
	  		header('Location: ../editor/');
	  	}

	  	if ($type=="javascript") {
	  		$type="js";
	  	}

	  	if ($esp=="false") {
	  		$validType=strpos($_GET['id'],$type);
	  		if($validType==false){
	  			header('Location: ../editor/');
		  	}	
	  	} else {
	  		if($esp=="true" && $type!="php"){
	  			header('Location: ../editor/');
		  	}
	  	}
	}

	require("../SQLFunc.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>Coders {}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta name="description" content="La primera comunidad de programadores de El Salvador">
	<meta name="author" content="Fernando Santamaría - Christian Zayas">
	
	<!-- STYLESHEETS --><!--[if lt IE 9]><script src="../js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
	
	<link rel="stylesheet" type="text/css" href="../css/style.css" >
	<link rel="stylesheet" type="text/css"  href="../css/themes/default.css">
	<link rel="stylesheet" type="text/css"  href="../css/responsive.css" >
	<link rel="stylesheet" href="jquery-ui/css/coders/jquery-ui-1.10.4.custom.css">

	<script src="jquery-ui/js/jquery-1.10.2.js"></script>
	<script src="jquery-ui/js/jquery-ui-1.10.4.js"></script>
	<script src="../ace/src-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>

	<link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- FONTS -->
	<link href='../css/fonts.css' rel='stylesheet' type='text/css'>
	<!-- Favicon -->
	<link rel="shortcut icon" href="../common/img/favicon.png" />
	<script>
	var id="blank", type="blank";
	var url = $(location).attr('href');
	url = url.replace(/.*\?(.*?)/,"$1");
	vars = url.split ("&");
	if (vars.length==1) {
		id="blank";
		type="blank";
	}else{
		for (i = 0; i < vars.length; i++) {
			separate = vars[i].split("=");	
			eval ('var '+separate[0]+'="'+separate[1]+'"');
		}
	}

	var tabCounter=2,
	fileName="Prueba.html";
	var fileArray= new Array ();

		$(function() {
			var tabTitle = $( "#tab_title" ),
			  tabContent = $( "#tab_content" ),
			  tabCounter = 2;

			var tabs = $( "#tabs" ).tabs();

			var dialog = $( "#dialog" ).dialog({
			  autoOpen: false,
			  resizable: false,
		      modal: true,
			  buttons: {
			    Create: function() {
				    if (tabTitle.val()!="") {
				    	if (verifyName(tabTitle.val()+"."+tabContent.val())) {
					      	alert('Ya existe un archivo con ese nombre')
					      	form[ 0 ].reset();
					      }else{
					      	addTab();
					      	$( this ).dialog( "close" );
					      	fileArray[(tabCounter-2)]=tabTitle.val()+"."+tabContent.val();
					      	form[ 0 ].reset();
					      }
				    } else {
				    	$("#tab_title").attr("placeholder", "Escribe un nombre");
				    	$("#tab_title").css({ border: "solid 1px red", });
					}
				},
			    Cancel: function() {
			      $( this ).dialog( "close" );
			    }
			  },
			  Close: function() {
			    form[ 0 ].reset();
			  }
			});

			var dialogEmpty = $( "#dialog-empty" ).dialog({
			  autoOpen:false,
			  resizable: false,
		      height:180,
		      width: 400,
		      modal: true,
			  buttons: {
			    Ok: function() {
				    $( this ).dialog( "close" );
				}
			  }
			});

			var dialogSuccess = $( "#dialog-success" ).dialog({
			   autoOpen:false,
			  resizable: false,
		      height:180,
		      width: 400,
		      modal: true,
			  buttons: {
			    Ok: function() {
				    $( this ).dialog( "close" );
				}
			  }
			});

			var form = dialog.find( "form" ).submit(function( event ) {
			  addTab();
			  dialog.dialog( "close" );
			  event.preventDefault();
			});

			function addTab() {
			  var label = tabTitle.val()+"."+tabContent.val(),
			    id = "tabs-" + tabCounter,
			    tabTemplate = "<li class=\"file\"><a href='#{href}' onClick=\"activeEditor(this)\" id='"+tabTitle.val()+"."+tabContent.val()+"' editor='aceEditor"+tabCounter+"'>#{label}</a> <span class='ui-icon ui-icon-close' role='presentation'>Cerrar</span></li>";
			    li = $( tabTemplate.replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ) ),
			    tabContentHtml = "<div id='aceEditor"+tabCounter+"' class='Editor'></div>";

			  tabs.find( ".ui-tabs-nav" ).append( li );
			  tabs.append( "<div id='" + id + "'>" + tabContentHtml + "</div>" );
			  tabs.tabs( "refresh" );
			  newEditor();
			}

			function newEditor(){
			  var lang;
			  var idf = document.getElementById("aceEditor"+tabCounter);
			  var editor = ace.edit(idf);

			  editor.setTheme("ace/theme/dawn");
			  editor.setShowPrintMargin(false);
			  
			  lang=tabContent.val()

			  if(tabContent.val()=="js"){
			    lang="javascript" 
			  }

			  editor.getSession().setMode("ace/mode/"+lang+"");

			  editor.commands.addCommand({
			    name: 'Guardar'+tabCounter,
			    bindKey: {win: 'Ctrl-S',  mac: 'Command-S'},
			    exec: function(editor) {
			       saveFile();
			    },
			      readOnly: false
			  });

			  //$("#tabs").tabs({ active: (tabCounter-1)});
			  tabCounter++;
			}

			function verifyName(idfName){
				for (var i = 0 ; i <= fileArray.length; i++) {
					if (fileArray[i] == idfName) {
			            return true;
			        }
				}
				return false
			}

			function saveFile() {
			  if(editor.getSession().getValue()!=""){
			      var contents = editor.getSession().getValue();
			        $.post("savefile.php", 
			              {contents: contents, doc_name: fileName},
			              function() {
			                   dialogSuccess.dialog( "open" );
			              }
			        );
			    } else {
			      dialogEmpty.dialog( "open" );
			    }
			}

			$( "#add_tab" )
			  .button()
			  .click(function() {
			  	dialog.dialog( "open" );
			  });

			tabs.delegate( "span.ui-icon-close", "click", function() {
			  var panelId = $( this ).closest( "li" ).remove().attr( "aria-controls" );
			  $( "#" + panelId ).remove();
			  tabs.tabs( "refresh" );
			});

			$("#saveFileBtn")
				.button()
				.click(function () {
				saveFile();
			})

			$("#tab_title").focus(function () {
				$("#tab_title").css({ border: "solid 1px #aaaaaa"});
				$("#tab_title").attr("placeholder", "");	
			})

		});
	</script>
</head>
<body>
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
											<a href="#">Editor de Código</a>
										</li>
									</ul>
									<!-- /BREADCRUMBS -->
									<div class="clearfix">
										<h3 class="content-title pull-left" id="title">
											Editor de Código
										</h3>
									</div>
								</div>
							</div>
						</div>
						<!-- /Header de contenido -->
						<!-- Contenido general -->
						<div class="row">
							<div class="col-xs-12 col-md-12" >
								<div id="dialog" title="Nuevo Archivo">
								  <form>
								    <fieldset class="ui-helper-reset">
								      <label for="tab_title">Nombre del archivo</label>
								      <input type="text" name="tab_title" id="tab_title" autocomplete="off" class="ui-widget-content ui-corner-all" required>
								      <label for="tab_content">Lenguaje de programación</label>
								      <select name="tab_content" id="tab_content" class="ui-widget-content ui-corner-all">
								        <option value="html">HTML</option>
								        <option value="php">PHP</option>
								        <option value="css">CSS</option>
								        <option value="js">Javascript</option>
								      </select> 
								    </fieldset>
								  </form>
								</div>
								 
								<button id="add_tab" class="btn btn-primary">Nuevo Archivo</button>
								<button id="saveFileBtn" class="btn btn-primary pull-right">Guardar cambios</button>
								 
								<div id="tabs">
								  <ul id="tabs-identifier">
								    <?php 
								    		if (isset($_GET['id'])) {
								    			if ($esp) {
								    				echo "<li><a id='".$_GET['id'].".php' editor='aceEditor1' href='#tabs-1' onClick='activeEditor(this)'>".$_GET['id'].".php</a> <span class='ui-icon ui-icon-close' role='presentation'>Cerrar</span></li>";	
											} else {
								    				echo "<li><a id='".$_GET['id']."' editor='aceEditor1' href='#tabs-1' onClick='activeEditor(this)'>".$_GET['id']."</a> <span class='ui-icon ui-icon-close' role='presentation'>Cerrar</span></li>";
								    			}
								    		} else {
								    			echo "<li><a id='Prueba.html' editor='aceEditor1' href='#tabs-1' onClick='activeEditor(this)'>Coders</a> <span class='ui-icon ui-icon-close' role='presentation'>Cerrar</span></li>";	
								    		}
								    ?> 
								  </ul>
								  <div id="tabs-1">
								    <div id="aceEditor1" class="Editor" ><?php if (isset($_GET['id'])) {
								    	$file = fopen("codefiles/".$_SESSION['UserID']."/".$_GET['id']."", "r") or exit("Error al abrir el archivo");
										while(!feof($file)){
										echo htmlentities(fgets($file));
										}
										fclose($file);
										echo "</br>";
								    } else {
								    	echo"                                   <span><</span>CODERS<span>/></span>
                           ••• Editor de código •••

En este panel podras crear tus propios archivos de código incrementando tu 
eficiencia aún cuando no estés en casa.

Generalidades:

<span><</span><span>/></span> Puedes crear tus archivos en los siguientes lenguajes de programación:
	•HTML.
	•PHP.
	•CSS.
	•JavaScript.

<span><</span><span>/></span> Para crear tus archivos simplemente presiona el botón 'Nuevo Archivo'
    y completa los datos del formulario.

<span><</span><span>/></span> Para guardar tus archivos basta con presionar el botón 'Guardar Archivo'
    o tan solo presionando las teclas «Ctrl+S».

<span><</span><span>/></span> Los archivos aquí creados puedes descargarlos desde tu Workspace.";
								    }
									?>
								    </div>
								  </div>
								</div>
							</div>
						</div>
						<!-- /Contenido general --> 
					</div>
				</div>
			</div>
		</div>
		<div id="dialog-empty" title="Coders" style="display:none">
		 	<p><h3><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></h3></span>No puedes guardar un archivo vacío</p>
		</div>
		<div id="dialog-success" title="Coders" style="display:none">
		 	<p><span style="float:left; margin:0 7px 20px 0;"></span><br>Archivo guardado exitosamente</p>
		</div>
		<div id="dialog-empty-2" title="Coders" style="display:none">
		 	<p><h3><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></h3></span>No puedes guardar un archivo vacío</p>
		</div>
		<div id="dialog-success-2" title="Coders" style="display:none">
		 	<p><span style="float:left; margin:0 7px 20px 0;"></span><br>Archivo guardado exitosamente</p>
		</div>
	</section>
	<!-- Core Bootstrap-->
	<!--/PAGE -->
	<!-- JAVASCRIPTS -->
	<!-- ACE CODE EDITOR -->

	<script type="text/javascript">
	var dialogEmptyEdit=null, dialogSuccessEdit=null;

	$(function() {
		dialogEmptyEdit = $( "#dialog-empty-2" ).dialog({
		  autoOpen:false,
		  resizable: false,
	       height:180,
	       width: 400,
	       modal: true,
		  buttons: {
		    Ok: function() {
			    $( this ).dialog( "close" );
			}
		  }
		});

		dialogSuccessEdit = $( "#dialog-success-2" ).dialog({
		  autoOpen:false,
		  resizable: false,
	       height:180,
	       width: 400,
	       modal: true,
		  buttons: {
		    Ok: function() {
			    $( this ).dialog( "close" );
			}
		  }
		});
	   });

  	  var editor = ace.edit('aceEditor1');

	  editor.setTheme("ace/theme/dawn");
	  editor.getSession().setTabSize(4);
	  editor.setShowPrintMargin(false);
	  
	  if (id=="blank" && type=="blank") {
	     editor.setReadOnly(true);
	     editor.setFontSize(14);
		editor.getSession().setMode("ace/mode/text");
	  }

	  if (id!="blank" && type!="blank") {
	  	editor.setReadOnly(false);
		editor.setFontSize(12);
		editor.getSession().setMode("ace/mode/"+type);

		editor.commands.addCommand({
		    name: 'myCommand',
		    bindKey: {win: 'Ctrl-S',  mac: 'Command-S'},
		    exec: function(editor) {
		        if(editor.getSession().getValue()!=""){
			      var contents = editor.getSession().getValue();
			        $.post("savefile.php", 
			              {contents: contents, doc_name: id},
			              function() {
			                   dialogSuccessEdit.dialog( "open" );
			              }
			        );
			    } else {
			      dialogEmptyEdit.dialog( "open" );
			    }
		    },
		    readOnly: false
		});

	  }

	  function activeEditor(element){
	      fileName = element.id;
	      idfEditor= $(element).attr("editor");
	      editor=ace.edit(document.getElementById(idfEditor));
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
	<script>
		jQuery(document).ready(function() {		
			App.init(); //Initialise plugins and elements
		});
	</script>
	<!-- /JAVASCRIPTS -->
</body>
</html>	