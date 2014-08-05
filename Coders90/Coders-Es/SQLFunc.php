<?php
session_save_path("sessions/");
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
function UserData(){
	include("BDD.php");
	$query="SELECT * FROM users WHERE UserID='".$_SESSION['UserID']."'";
	$result=mysql_query($query,$dbconn);

	while ($row=mysql_fetch_array($result)) {
		$_SESSION['UserName']=$row[1];
		$_SESSION['UserLast']=$row[2];
		$_SESSION['UserEmail']=$row[3];
		$_SESSION['BDate']=$row[5];
	}

	mysql_close();
}

function NewsFeed(){
	include("../BDD.php");
	$query="SELECT following.UserID, users.Name, users.LastName, post.UserID, post.Content, post.Date, post.Time, post.postID FROM (users INNER JOIN post ON users.UserID = post.UserID) INNER JOIN following ON users.UserID = following.UserID WHERE following.FollowerID='".$_SESSION['UserID']."' AND View='1' ORDER BY post.Date DESC, post.Time DESC LIMIT 500";
	$result=mysql_query($query,$dbconn);
	
	while($row=mysql_fetch_array($result)){
				
		if ($row[3]==$_SESSION['UserID']) {
			echo "
			<div class='box border green' style='z-index:1; position:relative;'>
		    	<div class='box-title small'>
					<h4><i class='fa fa-code'></i><a idf='".$row[0]."'  style='text-decoration: none; color:white; cursor:pointer;' class='profile'>".$row[1]." ".$row[2]."</a></h4>
					<div class='pull-right'>
						<span class='timeclass pull-right'>
							<i class='fa fa-clock-o'></i>
							<span>".strftime("%d de %B",strtotime($row[5])) .", ".date("g:i a", strtotime($row[6]))."</span>
							<span>&nbsp;&nbsp;<span class='compose tip-left' title='Eliminar publicación'><i class='fa fa-times-circle delete-comment timeclass' title='Eliminar publicacion' idf='".$row[7]."' post-idf='".$row[7]."' onClick='delPost(this)'></i></span></span>
						</span>
					</div>
				</div>	
				<div class='box-body clearfix' style='word-wrap:break-word;'>
					<span>
						<div class='col-xs-2 col-md-1'> 
							<img class='img-perfil' src='../img/avatars/".$row[0].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
						</div>
						<div class='col-xs-8 col-md-10'>
							<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
								<h5>
									<span>".htmlentities($row[4],ENT_NOQUOTES,"UTF-8")."</span>
								</h5>
							</div>
						</div>
						<div class='col-xs-2 col-md-1'> 
							<a><h3 class='pull-right'><span class='compose tip-left' title='Comentarios'><i class='fa fa-comments' idf='".$row[7]."''></i></span></h3></a>
						</div>
					</span>
				</div>	
			</div>
			<div class='comments pull-right' id='".$row[7]."'>
			</diV>
			<div class='divide-25'></div>";
		} else {
			echo "
			<div class='box border green' style='z-index:1; position:relative;'>
		    	<div class='box-title small'>
					<h4><i class='fa fa-code'></i>".$row[1]." ".$row[2]."</h4>
					<div class='pull-right'>
						<span class='timeclass pull-right'>
							<i class='fa fa-clock-o'></i>
							<span>".strftime("%d de %B",strtotime($row[5])) .", ".date("g:i a", strtotime($row[6]))."</span>
						</span>
					</div>
				</div>	
				<div class='box-body clearfix' style='word-wrap:break-word;'>
					<span>
						<div class='col-xs-2 col-md-1'> 
							<img class='img-perfil' src='../img/avatars/".$row[0].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
						</div>
						<div class='col-xs-8 col-md-10'>
							<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
								<h5>
									<span>".htmlentities($row[4],ENT_NOQUOTES,"UTF-8")."</span>
								</h5>
							</div>
						</div>
						<div class='col-xs-2 col-md-1'> 
							<a><h3 class='pull-right'><span class='compose tip-left' title='Comentarios'><i class='fa fa-comments' idf='".$row[7]."''></i></span></h3></a>
						</div>
					</span>
				</div>	
			</div>
			<div class='comments pull-right' id='".$row[7]."'>
			</diV>
			<div class='divide-25'></div>";
		}
			
	}
	mysql_close();
}

function UsersList($start,$length){
	include("../../BDD.php");
	$post="SELECT UserID, Name, LastName, Email FROM users ORDER BY Name Asc LIMIT ".$start.",".$length."";
	$result=mysql_query($post,$dbconn);
	$totalUsers=mysql_num_rows($result);
	$totalPages=ceil($totalUsers / 3);
	
	while($row=mysql_fetch_array($result)){
		echo "
			<tr>
				<td class='table-rows'><img class='img-perfil' src='../../img/avatars/".$row[0].".jpg' onerror=\"this.src='../../img/avatars/default.jpg'\" width='40' height='40'></td>
				<td class='table-rows'>".$row[0]."</td>
				<td class='table-rows'>".$row[1]." ".$row[2]."</td>
				<td class='table-rows'>".$row[3]."</td>
				<td class='actions'><a href='actions.php?user=".$row[0]."'><i class='fa fa-wrench'></i></a></td>
			  </tr>
		";
	}
	mysql_close();
}

function paginationUser($actPage,$querySql){
	include("../../BDD.php");
	$result=mysql_query($querySql,$dbconn);
	$totalUsers=mysql_num_rows($result);
	$totalPages=ceil($totalUsers / 3);
	$next=$actPage+1;
	$previous=$actPage-1;
	
	if ($totalPages==1){
		echo "<ul class='pager'>
			<li class='previous disabled'><a href=''>&larr; Anterior</a></li>
			<li class='next disabled'><a href=''>Siguiente &rarr;</a></li>
	      </ul>";
	}
	

	if ($actPage==1 && $totalPages!=1){
		echo "<ul class='pager'>
			<li class='previous disabled'><a href=''>&larr; Anterior</a></li>
			<li class='next'><a href='index.php?page=".$next."'>Siguiente &rarr;</a></li>
	      </ul>";
	}

	if ($actPage!=1 && $actPage!=$totalPages){
		echo "<ul class='pager'>
			<li class='previous'><a href=index.php?page='".$previous."'>&larr; Anterior</a></li>
			<li class='next'><a href='index.php?page=".$next."'>Siguiente &rarr;</a></li>
	      </ul>";
	}

	if ($actPage==$totalPages && $actPage!=1){
		echo "<ul class='pager'>
			<li class='previous'><a href='index.php?page=".$previous."'>&larr; Anterior</a></li>
			<li class='next disabled'><a href=''>Siguiente &rarr;</a></li>
	      </ul>";
	}

	echo "<div class='col-xs-12 col-md-12'>
			<center><h5>Página ".$actPage." de"." ".$totalPages."</h5><h6>(Se muestran 3 registros por página)</h6></center>
		  </div>";

	mysql_close();
}


function postList($idf,$start,$length){
	include("../../BDD.php");
	$query="SELECT content, Date, Time, PostID, View FROM post WHERE UserID='".$idf."' LIMIT ".$start.", ".$length." ";
	$result=mysql_query($query,$dbconn);

	while($row=mysql_fetch_array($result)){
		$viewRow=$row[4];
		if ($viewRow=="1") {
			echo "
			<tr>
				<td class='table-rows'><input type='checkbox' name='postIdf[]' value='".$row[3]."'></td>
				<td class='table-rows'>".htmlentities($row[0],ENT_NOQUOTES,"UTF-8")."</td>
				<td class='table-rows'>".date("d-m-Y", strtotime($row[1]))."</td>
				<td class='table-rows'>".date("g:i a", strtotime($row[2]))."</td>
				<td class='table-rows'><input type='button' class='btn btn-success btn-xs' value='Visible' style='width:65px;' disabled></td>
				<td class='actions'><a href='postActions.php?postIdf=".$row[3]."'><i class='fa fa-wrench'></i></a></td>
			</tr>";
		} else {
			echo "
			<tr>
				<td class='table-rows'><input type='checkbox' name='postIdf[]' value='".$row[3]."'></td>
				<td class='table-rows'>".htmlentities($row[0],ENT_NOQUOTES,"UTF-8")."</td>
				<td class='table-rows'>".date("d-m-Y", strtotime($row[1]))."</td>
				<td class='table-rows'>".date("g:i a", strtotime($row[2]))."</td>
				<td class='table-rows'><input type='button' class='btn btn-danger btn-xs' value='Eliminado' style='width:65px;' disabled></td>
				<td class='actions'><a href='postActions.php?postIdf=".$row[3]."'><i class='fa fa-wrench'></i></a></td>
			</tr>";
		}
	}
	mysql_close();
}

function paginationPost($idf,$actPage,$querySql){
	include("../../BDD.php");
	$result=mysql_query($querySql,$dbconn);
	$totalPost=mysql_num_rows($result);
	$totalPages=ceil($totalPost / 3);
	$next=$actPage+1;
	$previous=$actPage-1;

	if ($totalPages==1){
		echo "<ul class='pager'>
			<li class='previous disabled'><a href=''>&larr; Anterior</a></li>
			<li class='next disabled'><a href=''>Siguiente &rarr;</a></li>
	      </ul>";
	}
	

	if ($actPage==1 && $totalPages!=1){
		echo "<ul class='pager'>
			<li class='previous disabled'><a href=''>&larr; Anterior</a></li>
			<li class='next'><a href='actions.php?user=".$idf."&page=".$next."'>Siguiente &rarr;</a></li>
	      </ul>";
	}

	if ($actPage!=1 && $actPage!=$totalPages){
		echo "<ul class='pager'>
			<li class='previous'><a href='index.php?page='".$previous."'>&larr; Anterior</a></li>
			<li class='next'><a href='actions.php?user=".$idf."&page=".$next."'>Siguiente &rarr;</a></li>
	      </ul>";
	}

	if ($actPage==$totalPages && $actPage!=1){
		echo "<ul class='pager'>
			<li class='previous'><a href='actions.php?user=".$idf."&page=".$previous."'>&larr; Anterior</a></li>
			<li class='next disabled'><a href=''>Siguiente &rarr;</a></li>
	      </ul>";
	}

	echo "<div class='col-xs-12 col-md-12'>
			<center><h5>Página ".$actPage." de"." ".$totalPages."</h5><h6>(Se muestran 3 registros por página)</h6></center>
		  </div>";

	mysql_close();
}

function myGroups(){
	include("../BDD.php");
	$query="SELECT groups.*, users.UserId, users.Name, users.LastName FROM groups INNER JOIN user_group ON groups.GroupID=user_group.GroupID  INNER JOIN users ON users.userID=groups.UserId  WHERE user_group.UserId='".$_SESSION['UserID']."' ORDER BY groups.Name ASC";
	$result=mysql_query($query,$dbconn);

	while ($row=mysql_fetch_array($result)) {
		switch ($row[5]) {
			case "E74C3C":
				$border="C0392B";
				break;
			case "E67E22":
				$border="D35400";
				break;
			case "F1C40F":
				$border="F39C12";	
				break;
			case "1ABC9C":
				$border="16A085";
				break;
			case "2ECC71":
				$border="27AE60";
				break;
			case "3498DB":
				$border="2980B9";
				break;
			case "9B59B6":
				$border="8E44AD";
				break;
			case "95A5A6":
				$border="7F8C8D";
				break;
			case "34495E":
				$border="2C3E50";
				break;
		}

		if ($row[3]==$_SESSION['UserID']) {
			echo "<div class='col-xs-12 col-md-12'>
				<div class='col-xs-12 col-md-10 col-md-offset-1' style='background-color: #".$row[5]."; border-bottom: solid 5px #".$border.";color: white;'>
					<span class='pull-right'></br>".usersGroup($row[0])."</span>
					<a hreF='dashboard.php?group=".$row[0]."' style='text-decoration: none; color: white;'><h4>".$row[1]."</h4></a>
					<h6>Creador:"." ".$row[7]." ".$row[8]."</h6>
					<h6>Ultima actualización: ".lastUpdate($row[0])."</h6>
				</div>
			</div>
			<div class='divide-15'></div>";
		} else {
			echo "<div class='col-xs-12 col-md-12'>
				<div class='col-xs-12 col-md-10 col-md-offset-1' style='background-color: #".$row[5]."; border-bottom: solid 5px #".$border.";color: white;'>
					<span class='pull-right'></br>".usersGroup($row[0])."</span>
					<a hreF='dashboard.php?group=".$row[0]."' style='text-decoration: none; color: white;'><h4>".$row[1]."</h4></a>
					<h6>Creador:"." ".$row[7]." ".$row[8]."</h6>
					<h6>Ultima actualización: ".lastUpdate($row[0])."</h6>
				</div>
			</div>
			<div class='divide-15'></div>";
		}
	}
	mysql_close();
}

function myOwnGroups(){
	include("../BDD.php");
	$query="SELECT groups.*, users.UserId, users.Name, users.LastName FROM groups INNER JOIN users ON groups.USerID=users.UserID  WHERE groups.UserID='".$_SESSION['UserID']."' ORDER BY groups.Name ASC";
	$result=mysql_query($query,$dbconn);

	while ($row=mysql_fetch_array($result)) {
		switch ($row[5]) {
			case "E74C3C":
				$border="C0392B";
				break;
			case "E67E22":
				$border="D35400";
				break;
			case "F1C40F":
				$border="F39C12";	
				break;
			case "1ABC9C":
				$border="16A085";
				break;
			case "2ECC71":
				$border="27AE60";
				break;
			case "3498DB":
				$border="2980B9";
				break;
			case "9B59B6":
				$border="8E44AD";
				break;
			case "95A5A6":
				$border="7F8C8D";
				break;
			case "34495E":
				$border="2C3E50";
				break;
		}

		if ($row[3]==$_SESSION['UserID']) {
			echo "<div class='col-xs-12 col-md-12'>
				<div class='col-xs-12 col-md-10 col-md-offset-1' style='background-color: #".$row[5]."; border-bottom: solid 5px #".$border.";color: white;'>
					<span class='pull-right'></br>".usersGroup($row[0])."</span>
					<a hreF='dashboard.php?group=".$row[0]."' style='text-decoration: none; color: white;'><h4>".$row[1]."</h4></a>
					<h6>Creador:"." ".$row[7]." ".$row[8]."</h6>
					<h6>Ultima actualización: ".lastUpdate($row[0])."</h6>
				</div>
			</div>
			<div class='divide-15'></div>";
		} 
	}
	mysql_close();
}

function usersGroup($id){
	include("../BDD.php");
	$query="SELECT * FROM user_group WHERE GroupID='".$id.	"'";
	$result=mysql_query($query,$dbconn);
	$totalUser=mysql_num_rows($result);

	if ($totalUser==1) {
		$totalUser = "1 Usuario";
	} else {
		$totalUser = $totalUser." Usuarios";
	}
	mysql_close();
	return $totalUser;
}

function usersGroupAdmin($id){
	include("../../BDD.php");
	$query="SELECT * FROM user_group WHERE GroupID='".$id.	"'";
	$result=mysql_query($query,$dbconn);
	$totalUser=mysql_num_rows($result);

	if ($totalUser==1) {
		$totalUser = "1 Usuario";
	} else {
		$totalUser = $totalUser." Usuarios";
	}
	mysql_close();
	return $totalUser;
}

function lastUpdate($id){
	include("../BDD.php");
	$query="SELECT Date, Time FROM post_group WHERE GroupID='".$id.	"' ORDER BY Date DESC";
	$result=mysql_query($query,$dbconn);

	$last=mysql_fetch_array($result);
	mysql_close();
	if($last[0]==""){
		return "Aún no hay publicaciones";
	} else {
		return $lastUp=strftime("%d de %B",strtotime($last[0])).", ".date("g:i a", strtotime($last[1]));
	}

}

function NewsFeedGroups($id){
	include("../BDD.php");
	$query="SELECT post_group.*, users.UserID, users.Name, users.LastName FROM post_group INNER JOIN users ON users.UserID = post_group.UserID WHERE post_group.GroupID='".$id."' AND post_group.View='1' ORDER BY post_group.Date DESC, post_group.Time DESC LIMIT 500";	
	$result=mysql_query($query,$dbconn);
	
	while($row=mysql_fetch_array($result)){
				
		if ($row[1]==$_SESSION['UserID']) {
			echo "
			<div class='box border green' style='z-index:1; position:relative;'>
		    	<div class='box-title small'>
					<h4><i class='fa fa-code'></i>".$row[8]." ".$row[9]."</h4>
					<div class='pull-right'>
						<span class='timeclass pull-right'>
							<i class='fa fa-clock-o'></i>
							<span>".strftime("%d de %B",strtotime($row[5])) .", ".date("g:i a", strtotime($row[5]))."</span>
							<span>&nbsp;&nbsp;<span class='compose tip-left' title='Eliminar publicación'><i class='fa fa-times-circle delete-comment timeclass' title='Eliminar publicacion' idf='".$row[0]."' post-idf='".$row[0]."' onClick='delPost(this)'></i></span></span>
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
						<div class='col-xs-2 col-md-1'> 
							<a><h3 class='pull-right'><span class='compose tip-left' title='Comentarios'><i class='fa fa-comments' idf='".$row[0]."' idf-group='".$row[0]."-".$id."'></i></span></h3></a>
						</div>
					</span>
				</div>	
			</div>
			<div class='comments pull-right' id='".$row[0]."'>
			</diV>
			<div class='divide-25'></div>";
		} else {
			echo "
			<div class='box border green' style='z-index:1; position:relative;'>
		    	<div class='box-title small'>
					<h4><i class='fa fa-code'></i>".$row[8]." ".$row[9]."</h4>
					<div class='pull-right'>
						<span class='timeclass pull-right'>
							<i class='fa fa-clock-o'></i>
							<span>".strftime("%d de %B",strtotime($row[5])) .", ".date("g:i a", strtotime($row[5]))."</span>
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
						<div class='col-xs-2 col-md-1'> 
							<a><h3 class='pull-right'><span class='compose tip-left' title='Comentarios'><i class='fa fa-comments' idf='".$row[0]."' idf-group='".$row[0]."-".$id."'></i></span></h3></a>
						</div>
					</span>
				</div>	
			</div>
			<div class='comments pull-right' id='".$row[0]."'>
			</diV>
			<div class='divide-25'></div>";
		}
			
	}
	mysql_close();
}

function partOf($id){
	include("../BDD.php");
	$query="SELECT * FROM user_group WHERE UserID='".$_SESSION['UserID']."' AND GroupID='".$id."'";
	$result=mysql_query($query,$dbconn);
	$totalrows=mysql_num_rows($result);
	mysql_close();
	if ($totalrows==0) {
		$part=false;
	} else {
		$part=true;
	}

	return $part;
}

function partOfComments($id){
	include("BDD.php");
	$query="SELECT * FROM user_group WHERE UserID='".$_SESSION['UserID']."' AND GroupID='".$id."'";
	$result=mysql_query($query,$dbconn);
	$totalrows=mysql_num_rows($result);
	mysql_close();
	if ($totalrows==0) {
		$part=false;
	} else {
		$part=true;
	}

	return $part;
}

function myFeed($user){
	include("BDD.php");
	$query="SELECT post.*, users.Name, users.LastName FROM post INNER JOIN users ON post.USerID=users.UserID WHERE post.UserID='".$user."' AND View='1' ORDER BY post.Date DESC, post.Time DESC LIMIT 500";
	$result=mysql_query($query,$dbconn);
	
	while($row=mysql_fetch_array($result)){
				
		//if ($row[3]==$_SESSION['UserID']) {
			echo "
			<div class='box border green' style='z-index:1; position:relative;'>
		    	<div class='box-title small'>
					<h4><i class='fa fa-code'></i>".$row[6]." ".$row[7]."</h4>
					<div class='pull-right'>
						<span class='timeclass pull-right'>
							<i class='fa fa-clock-o'></i>
							<span>".strftime("%d de %B",strtotime($row[3])) .", ".date("g:i a", strtotime($row[4]))."</span>
							<span>&nbsp;&nbsp;<span class='compose tip-left' title='Delete Post'><i class='fa fa-times-circle delete-comment timeclass' title='Delete Post' idf='".$row[7]."' post-idf='".$row[7]."' onClick='delPost(this)'></i></span></span>
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
						<div class='col-xs-2 col-md-1'> 
							<a><h3 class='pull-right'><span class='compose tip-left' title='Comments'><i class='fa fa-comments' idf='".$row[0]."''></i></span></h3></a>
						</div>
					</span>
				</div>	
			</div>
			<div class='comments pull-right' id='".$row[0]."'>
			</diV>
			<div class='divide-25'></div>";
	}
	mysql_close();


}

function myMessages($userTo){
	include("BDD.php");
	$query="SELECT sub.UserFrom, users.Name, users.LastName FROM (SELECT messages.*, users.Name, users.LastName FROM messages INNER JOIN users ON users.UserID=messages.UserFrom Where messages.UserID='".$_SESSION['UserID']."' ORDER BY messages.Date DESC, messages.Time DESC Limit 5 )sub INNER JOIN users ON users.UserID=sub.UserFrom GROUP BY sub.UserFrom";
	$result=mysql_query($query,$dbconn);
	
	echo "<li class='dropdown' id='header-message'>
				<a href='#' class='dropdown-toggle' data-toggle='dropdown'>
				<i class='fa fa-envelope'></i>
				</a>
				<ul class='dropdown-menu inbox'>
					<li class='dropdown-title'>
						<span><i class='fa fa-envelope-o'></i>Mensajes</span>
						<span class='compose pull-right tip-right' title='Crear mensaje'><i class='fa fa-pencil-square-o'></i></span>
					</li>
					<li>";

	while($row=mysql_fetch_array($result)){

		$lastMessage="(SELECT messages.* FROM messages WHERE UserID='".$_SESSION['UserID']."' AND UserFrom='".$row[0]."') UNION (SELECT messages.* FROM messages WHERE UserID='".$row[0]."' AND UserFrom='".$_SESSION['UserID']."') ORDER BY Date DESC, Time DESC LIMIT 1";
		$resultLast=mysql_query($lastMessage,$dbconn);

		while($rowLast=mysql_fetch_array($resultLast)){

			if (strlen($rowLast[3])>40) {
				$content=substr($rowLast[3], 0,40)." ...";
			} else {
				$content=$rowLast[3];
			}

			echo "<li>
				<a href='../messages/?f=".$row[0]."'>
					<img src='../img/avatars/".$row[0].".jpg' alt='' onerror='this.src='../img/avatars/default.jpg''/>
					<span class='body'>
						<span class='from'>".$row[1]." ".$row[2]."</span>
						<span class='message' style='word-break:break-all;'>
						".$content."
						</span> 
						<span class='time'>
							<i class='fa fa-clock-o'></i>
							<span>".strftime("%d de %B",strtotime($rowLast[5])).", ".date("g:i a", strtotime($rowLast[6]))."</span>
						</span>
					</span>
					 
				</a>
			</li>";
		}

	}

	echo "	<li class='footer'>
				<a href='#'>Todos los mensajes<i class='fa fa-arrow-circle-right'></i></a>
			</li>
			</ul>
		</li>";


	mysql_close();
}

function messageList(){
	include("BDD.php");
	$query="SELECT messages.*, users.Name, users.LastName FROM messages INNER JOIN users ON users.UserID=messages.UserFrom Where messages.UserID='".$_SESSION['UserID']."' GROUP BY messages.UserFrom  ORDER BY messages.Date ASC, messages.Time ASC";
	$result=mysql_query($query,$dbconn);

	while ($row=mysql_fetch_array($result)) {
		if (strlen($row[3])>75) {
			$content=substr($row[3], 0,75)." ...";
		} else {
			$content=$row[3];
		}

		echo "<a href='../messages/?f=".$row[2]."' class='styleLess'>
				<div class='media-body chat-pop messages'>
					<img class='img-perfil pull-left spacer-7' alt='User image'  width='50px' height='50px' src='../img/avatars/".$row[2].".jpg'>
					<h4 class='media-heading padding-left'>".$row[8]." ".$row[9]."<span class='pull-right'><i class='fa fa-clock-o'></i> <abbr class='timeago' title='".date('d/m/Y', strtotime($row[5]))." a las ".date('g:i a', strtotime($row[6]))."' >".strftime("%d de %B",strtotime($row[5])).", ".date("g:i a", strtotime($row[6]))."</abbr> </span></h4>
					<p class='padding-left'>".$content."</p>
				</div>
			</a>
			<div class='divide-20'></div>";
	}
	mysql_close();
}

function messagesList(){
	include("BDD.php");
	$query="SELECT sub.UserFrom, users.Name, users.LastName FROM (SELECT messages.*, users.Name, users.LastName FROM messages INNER JOIN users ON users.UserID=messages.UserFrom Where messages.UserID='".$_SESSION['UserID']."' ORDER BY messages.Date DESC, messages.Time DESC Limit 5 )sub INNER JOIN users ON users.UserID=sub.UserFrom GROUP BY sub.UserFrom";
	$result=mysql_query($query,$dbconn);

	while($row=mysql_fetch_array($result)){

		$lastMessage="(SELECT messages.* FROM messages WHERE UserID='".$_SESSION['UserID']."' AND UserFrom='".$row[0]."') UNION (SELECT messages.* FROM messages WHERE UserID='".$row[0]."' AND UserFrom='".$_SESSION['UserID']."') ORDER BY Date DESC, Time DESC LIMIT 1";
		$resultLast=mysql_query($lastMessage,$dbconn);

		while($rowLast=mysql_fetch_array($resultLast)){

			if (strlen($rowLast[3])>40) {
				$content=substr($rowLast[3], 0,40)." ...";
			} else {
				$content=$rowLast[3];
			}

			echo "<a href='../messages/?f=".$row[0]."' class='styleLess'>
				<div class='media-body chat-pop messages'>
					<img class='img-perfil pull-left spacer-7' alt='User image'  width='50px' height='50px' src='../img/avatars/".$row[0].".jpg'>
					<h4 class='media-heading padding-left'>".$row[1]." ".$row[2]."<span class='pull-right'><i class='fa fa-clock-o'></i> <abbr class='timeago' title='".date('d/m/Y', strtotime($rowLast[5]))." a las ".date('g:i a', strtotime($rowLast[6]))."' >".strftime("%d de %B",strtotime($rowLast[5])).", ".date("g:i a", strtotime($rowLast[6]))."</abbr> </span></h4>
					<p class='padding-left'>".$content."</p>
				</div>
			</a>
			<div class='divide-20'></div>";
		}

	}

	mysql_close();
}

function groupList($u,$start,$length){
	include("../../BDD.php");
	$query="SELECT groups.* FROM groups WHERE UserID='".$u."' LIMIT ".$start.", ".$length;
	$result=mysql_query($query,$dbconn);

	while($row=mysql_fetch_array($result)){
		/*echo "<tr>
			<td class='table-rows'><input type='checkbox' name='groupIdf[]' value='".$row[3]."'></td>
			<td class='table-rows'>".$row[0]."</td>
			<td class='table-rows'>".$row[1]."</td>
			<td class='table-rows'>".$row[2]."</td>
			<td class='actions'><a href='groupsActions.php?groupIdf=".$row[0]."'><i class='fa fa-wrench'></i></a></td>
		</tr>";*/
		echo "<tr>
			<td class='table-rows'>".$row[0]."</td>
			<td class='table-rows'>".$row[1]."</td>
			<td class='table-rows'>".$row[2]."</td>
			<td class='actions'><a href='groupsActions.php?groupIdf=".$row[0]."'><i class='fa fa-wrench'></i></a></td>
		</tr>";
	}
}

function paginationGroups($idf,$actPage,$querySql){
	include("../../BDD.php");
	$result=mysql_query($querySql,$dbconn);
	$totalPost=mysql_num_rows($result);
	$totalPages=ceil($totalPost / 3);
	$next=$actPage+1;
	$previous=$actPage-1;

	if ($totalPages==1){
		echo "<ul class='pager'>
			<li class='previous disabled'><a href=''>&larr; Anterior</a></li>
			<li class='next disabled'><a href=''>Siguiente &rarr;</a></li>
	      </ul>";
	}
	

	if ($actPage==1 && $totalPages!=1){
		echo "<ul class='pager'>
			<li class='previous disabled'><a href=''>&larr; Anterior</a></li>
			<li class='next'><a href='actions.php?user=".$idf."&page=".$next."'>Siguiente &rarr;</a></li>
	      </ul>";
	}

	if ($actPage!=1 && $actPage!=$totalPages){
		echo "<ul class='pager'>
			<li class='previous'><a href='index.php?page='".$previous."'>&larr; Anterior</a></li>
			<li class='next'><a href='actions.php?user=".$idf."&page=".$next."'>Siguiente &rarr;</a></li>
	      </ul>";
	}

	if ($actPage==$totalPages && $actPage!=1){
		echo "<ul class='pager'>
			<li class='previous'><a href='actions.php?user=".$idf."&page=".$previous."'>&larr; Anterior</a></li>
			<li class='next disabled'><a href=''>Siguiente &rarr;</a></li>
	      </ul>";
	}

	echo "<div class='col-xs-12 col-md-12'>
			<center><h5>Página ".$actPage." de"." ".$totalPages."</h5><h6>(Se muestran 3 registros por página)</h6></center>
		  </div>";

	mysql_close();
}
?>





