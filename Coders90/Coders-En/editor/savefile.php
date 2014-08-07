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
$contenido=$ref.$_POST["contents"];
$contenido=str_replace("http://coders.host56.com/editor/", "", $contenido);
$name=$_POST["doc_name"];

if (strpos($name, ".php")) {
	$name=str_replace(".php", "", $name);
}

$newfile = file_put_contents("codefiles/".$_SESSION['UserID']."/".$name."", $contenido) or die("Error al guardar");
?>
