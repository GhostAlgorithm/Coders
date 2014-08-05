<?php
	session_save_path("sessions/");
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
	session_start();
	$idf=$_GET['vineta'];
	include("BDD.php");
	$query="SELECT postcomments.*, users.Name, users.LastName FROM postcomments INNER JOIN users ON users.UserID = postcomments.UserID WHERE postcomments.PostID='".$idf."' AND View='1'";
	$sql=mysql_query($query,$dbconn);

	echo "<div class='divide-20'></div>";
	while($row = mysql_fetch_array($sql)){
		$userIdf="".$_SESSION['UserID'];
		$postIDF="".$row[6];
		$resPost=substr($postIDF, 0,20)	;
			
		if ($userIdf==$resPost) {
			echo "<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
						<span>
							<div class='adjust-img'>
								<img class='img-perfil' src='../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
							</div>
							<div class='col-xs-12 col-md-12'>
								<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
									<pre><a style='text-decoration: none;' href='../profile/index.php?user=".$row[1]."'><h5 class='comment-name' >"."  ".$row[7]." ".$row[8]."</a></h5><span class='pull-right comment-time'><i class='fa fa-clock-o'></i> ".strftime("%d de %B",strtotime($row[4])) .", ".date("g:i a", strtotime($row[5]))." "."<i class='fa fa-times-circle delete-comment' title='Eliminar comentario' idf='".$row[0]."' post-idf='".$row[6]."' onClick='delComment(this)'></i></span>".htmlentities($row[2],ENT_NOQUOTES,"UTF-8")."</pre>
								</div>
							</div>
						</span>
					</div>
					<div class='divide-15'></div>";
		} else {
			if ($_SESSION['UserID']==$row[1]) {
				echo "<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
						<span>
							<div class='adjust-img'>
								<img class='img-perfil' src='../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
							</div>
							<div class='col-xs-12 col-md-12'>
								<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
									<pre><a style='text-decoration: none;' href='../profile/index.php?user=".$row[1]."'><h5 class='comment-name' >"."  ".$row[7]." ".$row[8]."</a></h5><span class='pull-right comment-time'><i class='fa fa-clock-o'></i> ".strftime("%d de %B",strtotime($row[4])) .", ".date("g:i a", strtotime($row[5]))." "."<i class='fa fa-times-circle delete-comment' title='Eliminar comentario' idf='".$row[0]."' post-idf='".$row[6]."' onClick='delComment(this)'></i></span>".htmlentities($row[2],ENT_NOQUOTES,"UTF-8")."</pre>
								</div>
							</div>
						</span>
					</div>
					<div class='divide-15'></div>";
			} else {
				echo "<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
						<span>
							<div class='adjust-img'>
								<img class='img-perfil' src='../img/avatars/".$row[1].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
							</div>
							<div class='col-xs-12 col-md-12'>
								<div class='col-xs-12 col-md-12' style='word-wrap:break-word;'>
									<pre><a style='text-decoration: none;' href='../profile/index.php?user=".$row[1]."'><h5 class='comment-name' >"."  ".$row[7]." ".$row[8]."</a></h5><span class='pull-right comment-time'><i class='fa fa-clock-o'></i>".strftime("%d de %B",strtotime($row[4])) .", ".date("g:i a", strtotime($row[5]))."</span>".htmlentities($row[2],ENT_NOQUOTES,"UTF-8")."</pre>
								</div>
							</div>
						</span>
					</div>
					<div class='divide-15'></div>";
			}
		}
	}
	echo "<div class='box-body clearfix adjust-text' style='word-wrap:break-word;'>
			<span>
				<div class='adjust-img'>
					<img class='img-perfil' src='../img/avatars/".$_SESSION['UserID'].".jpg' onerror=\"this.src='../img/avatars/default.jpg'\" width='50' height='50'>
				</div>
				<div class='col-xs-10 col-md-11'>
					<div class='col-xs-12 col-md-12'>
						<textarea style='padding: 1em;' class='comment-area ".$idf."' placeholder='Escribe un comentario...'></textarea>
						<div class='divide-10'></div>
					</div>
				</div>
				<div class='col-xs-1 col-md-1'>
					<div class='col-xs-12 col-md-12'>
						<button class='btn btn-primary comment-btn' idf='".$idf."' style='margin-left:-4.2em; margin-top:0em; height:3.7em;' onClick='postComment(this)' onKeyDown='enterPress(this)'>Post</button>
					</div>
				</div>
			</span>
		</div>";

?>

