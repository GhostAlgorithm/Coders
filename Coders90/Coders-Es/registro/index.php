<?php
	session_save_path("../sessions/");
	if(isset($_SESSION['UserID'])){
		header('Location: ../dashboard/');
	}
	
	if(isset($_POST['SignUp'])){
			
			include("../BDD.php");
			$firstname=trim($_POST['FirstName']);
			$lastname=trim($_POST['LastName']);
			$email=trim($_POST['ReEmail']);
			$password=hash('sha256',trim($_POST['Password']));
			$birthday=trim($_POST['Birthday']);
			
			$userid=strtolower(substr($firstname,0,3)).date("Y").strtolower(substr($lastname,0,2)).date("m").strtolower(substr($email,0,2)).date("d");
			$random=rand(0,99999);
			$randomcom=str_pad($random, 5, "0" ,STR_PAD_LEFT);
			$userid.=$randomcom;
						
			$exist = mysql_num_rows(mysql_query("SELECT Email FROM users WHERE Email='".$email."'"));
            
			if($exist==0){
				$insertar="INSERT INTO users VALUES('$userid','$firstname','$lastname','$email','$password','$birthday','0','0','0')";
				$res=mysql_query($insertar);
				if($res){
					session_start();
					$_SESSION['UserID']=$userid;
					$_SESSION['UserName']=$firstname;
					$_SESSION['UserLast']=$lastname;
					$_SESSION['UserEmail']=$email;
					$_SESSION['Admin']="0";
					
					$insFoll="INSERT INTO following VALUES('','".$userid."','".$userid."','1','1')";
					$result=mysql_query($insFoll);

					mkdir("../editor/codefiles/".$userid, 0777);

					if($result){
						header('Location: ../dashboard/');
					}
					
				} else {
					echo"<script>alert('Ocurrió un error al crear el usuario, intentelo de nuevo'".mysql_error().");window.history.back();</script>";
				}
			}else{
				echo"<script>alert('Correo regsitrado anteriormente, ingrese uno nuevo');window.history.back();</script>";
			}
         
            mysql_close();
		}
?>

<!DOCTYPE HTML>
<html lang="es">
		<head>
			<title>Registro</title>
			<!--Bootstrap / css / fonts-->
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">		
			<link rel="stylesheet" type="text/css" href="../css/style.css" >
			<link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.min.css"/>
			<link rel="stylesheet" type="text/css" href="../common/css/registro.css"/>
			<!--SEO / Responsive-->
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="shortcut icon" href="../common/img/favicon.png" />
			<script src="Func.js" type="text/javascript"></script>
			<script src="../editor/jquery-ui/js/jquery-1.10.2.js"></script>
			<script src="../editor/jquery-ui/js/jquery-ui-1.10.4.js"></script>
		</head>
	<body>
		<form method="POST" action="index.php">
			<div class="row">
				<div class="col-xs-12  col-md-12">
					<div class="col-xs-12 col-md-12">
						<h1 align="center">¡Nuevo Usuario!</h1>
					</div>
				</div>
				<div class="col-xs-12  col-md-12" id="panel">
					<div class="col-md-2"></div>
					<div class="col-xs-12 col-md-8">
						<div class="col-xs-12 col-md-6">
							<h4>Nombre:</h4>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input type="text" class="form-control" placeholder="Nombre" onkeypress="valText()" name='FirstName' maxlength="15" required/>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<h4>Apellido:</h4>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input type="text" class="form-control" placeholder="Apellido" onkeypress="valText()" name='LastName' maxlength="15" required/>
							</div>
						</div>
						<div class="col-xs-12 col-md-12">
							<h4>Email</h4>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
								<input type="email" class="form-control" placeholder="mail@domain.com" id="Email" name='Email' required/>
							</div>
						</div>
						<div class="col-xs-12 col-md-12">
							<h4>Re-escriba email:</h4>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
								<input type="email" class="form-control" placeholder="mail@domain.com" id="ReEmail" name='ReEmail' required/>
							</div>
						</div>
						<div class="col-xs-12 col-md-12">
							<h4>Contraseña:</h4>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-key"></i></span>
								<input type="password" class="form-control" placeholder="Contraseña" name='Password' maxlength="15" required/>
							</div>
						</div>
						<div class="col-xs-12 col-md-12">
							<h4>Fecha de Nacimiento:</h4>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="date" class="form-control" placeholder="01/01/2000" name='Birthday' id="Birthday" onblur="act()" required/>
							</div>
						</div>
						<div class="col-xs-12 col-md-12">
							<div class="divide-20"></div>
							<div class="pull-left" style="color: white; font-size:20px;" id="notification"></div>
							<button class="btn btn-lg btn-success pull-right spcBtn btnForm" type="submit" id='SignUp' name='SignUp'>Crear</button>
							<a href="../" class="pull-right"><button class="btn btn-lg btn-warning btnForm" type="button">Regresar</button></a> 
						</div>
					</div>
					<div class="col-md-2"></div>
				</div>
			</div>
		</form>

	<!--JQuery & JS bootstrap -->
	<script type="text/javascript">
		$("#ReEmail").keyup(function(){

			var mail1=$("#Email").val();
			var mail2=$("#ReEmail").val();

			if (mail1!="" && mail2!="") {
				if (mail2==mail1) {
					$.ajax({
	                data:  {mail: mail2, action: "mail"},
	                url:   'validations.php',
	                dataType: "html",
	                type:  'post',
	                success:  function (response) {
	                	if (response=="true") {
	                		$("#Email").css({ border: "solid 3px red", });
	                		$("#ReEmail").css({ border: "solid 3px red", });
	                		$('#SignUp').attr("disabled", true);
	                		$('#notification').html("Email registrado anteriormente");
	                	} else{
	                		$("#Email").css({ border: "solid 3px #31E229", });
	                		$("#ReEmail").css({ border: "solid 3px #31E229", });
	                		$('#SignUp').attr("disabled", false);
	                		$('#notification').html("");
	                	}
	                }

	            	});
				} else{
					$("#Email").css({ border: "solid 3px #f0ad4e", });
	                $("#ReEmail").css({ border: "solid 3px #f0ad4e", });
	                $('#SignUp').attr("disabled", true);
	                $('#notification').html("Los emails no coinciden");
				}
			} 
		});

		$("#Email").keyup(function(){

			var mail1=$("#Email").val();
			var mail2=$("#ReEmail").val();

			if (mail2!="") {
				if (mail1!=mail2) {
					$("#Email").css({ border: "solid 3px #f0ad4e", });
	                $("#ReEmail").css({ border: "solid 3px #f0ad4e", });
	                $('#SignUp').attr("disabled", true);
	                $('#notification').html("Los emails no coinciden");					
				}
			} 
		});

		$("#Birthday").keyup(function (){
			var dat = new Date();
			var dd = dat.getDate();
			var mm = dat.getMonth()+1; 
			var mm2 = mm.toString();
			var dd2 = dd.toString();
			var yy = dat.getFullYear();

			if (mm2.length<2){
				mm2=0+mm2;
			}
			
			if (dd2.length<2){
				dd2=0+dd2;
			}
				
			var actdate=yy+mm2+dd2;

			var pdate = $("Birthday").val();
			var py = pdate.slice(0,4);
			var pm = pdate.slice(5,7);
			var pd = pdate.slice(8,10);
			
			pdate=py+pm+pd;

			if(Number(pdate)>Number(actdate)){
				$('#notification').html("Fecha Inválida");	
			} 
		});
		
	</script>
	<script src="../Func.js"></script>
	<script src="../common/js/jquery.min.js"></script>
	<script src="../common/js/jquery-1.10.2.min.js"></script>
	<script src="../common/js/bootstrap.min.js"></script>
	<script src="../common/js/scroll.js"></script>
</body>
<!--Todos los derechos reservados 2014 El Salvador - Fernando Santamaría y Christian Zayas-->
</html>