<?php
if(check_login() && isUserAuthorized(editBlog)){
	echo '<h3>Blogs aanpassen:</h3>';
	$sql = mysql_query("SELECT * FROM `blogs` WHERE `user_id` = '".myID()."' ORDER BY `id` DESC");
	if(mysql_num_rows($sql) != 0){
		while($res = mysql_fetch_array($sql)){
			$datetime = strtotime($res['datetime']);
			echo '<small>('.date("d-m'y", $datetime).')</small> '.$res['title'].' | <a href="./editblog&id='.$res['id'].'">Bewerken</a> / <a href="./deleteblog&id='.$res['id'].'">Verwijderen</a><br />';
		}
	}else{ echo 'Je hebt nog niks geschreven. :(';}
}
?>