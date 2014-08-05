<?php
session_start();
$contenido=$ref.$_POST["contents"];
$contenido=str_replace("http://coders.host56.com/editor/", "", $contenido);
$name=$_POST["doc_name"];

if (strpos($name, ".php")) {
	$name=str_replace(".php", "", $name);
}

$newfile = file_put_contents("codefiles/".$_SESSION['UserID']."/".$name."", $contenido) or die("Error al guardar");
?>
