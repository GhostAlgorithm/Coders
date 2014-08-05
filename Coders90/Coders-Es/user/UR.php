<?php
session_save_path("../sessions/");
session_start();

include("SimpleImage.class.php");
$thumbnail = 1;
$width = 150; 
$height = 150; 

if ($_FILES["fileUpload"]["error"] > 0){ 
	echo "Hay alg&uacute;n error con la imagen, para regresar haga <a href=\"form_funcion.html\">Click aqu&iacute;.</a>";
}else{ 
	$imgName = $_FILES["fileUpload"]["name"]; 
	$imgDir = "../img/avatars/"; 
	if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $imgDir.$imgName)){ 
		$succes = true; 
	}
	if ($succes === true){ 
		$objSimpleimage = new SimpleImage(); 
		$objSimpleimage->load($imgDir.$imgName); 
		if ( ($_FILES["fileUpload"]["type"]) != 'image/gif' && $thumbnail == 1){
			$newFile = $_SESSION['UserID'].".jpg"; 
			$objSimpleimage->resize($width,$height); 
		}else{ //sino
			$newFile = $_SESSION['UserID'].".jpg"; 
		}
		$objSimpleimage->save($imgDir.$newFile); 
		unlink($imgDir . $imgName); 
		header("location: ../user/index.php?up=1");
	}
}
