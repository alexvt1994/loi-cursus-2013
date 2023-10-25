<?php
defined('_TPL') or die('Restricted access');
if(!empty($_GET['userid']) && is_numeric($_GET['userid'])){
	echo '<h2>Blogs van '.db_element('login',$_GET['userid'],'schermnaam').':</h2>';

	$sql = mysql_query("SELECT * FROM `blogs` WHERE `user_id` = '".$_GET['userid']."' ORDER BY `id` DESC");
	if(mysql_num_rows($sql) != 0){
		while($res = mysql_fetch_array($sql)){
			$datetime = strtotime($res['datetime']);
			if(isUserAuthorized(editOthersBlog) && isUserAuthorized(deleteOthersBlog)){
				echo '<h3>'.$res['title'].' <small>| <i>'.date("d F'y", $datetime).' om '.date("g:i:s", $datetime).'</i> | <a href="./editblog&id='.$res['id'].'">Bewerken</a> / <a href="./deleteblog&id='.$res['id'].'">Verwijderen</a></small></h3>';
			} else {
				echo '<h3>'.$res['title'].' <small>| <i>'.date("d F'y", $datetime).' om '.date("g:i:s", $datetime).'</i></small></h3>';
			}
			echo '<hr />';
			echo nl2br($res['text']).'<br />';
			echo '<br />';
		}
	}else{ echo 'Er zijn nog geen blogs geschreven. :('; }
}else{ echo 'Sorry, deze actie is niet toegestaan!'; }
?>