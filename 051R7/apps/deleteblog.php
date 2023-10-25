<?php
defined('_TPL') or die('Restricted access');
if(check_login()){
	$id = (!empty($_GET['id']) && is_numeric($_GET['id'])?trim($_GET['id']):'');
	if(((isUserAuthorized(deleteBlog) && db_element('blogs', $id, 'user_id') == myID()) OR isUserAuthorized(deleteOthersBlog)) && $id ){
		$sql = mysql_query("SELECT `id`, `user_id` FROM `blogs` WHERE `id` = '".$id."'");
		$row = mysql_fetch_assoc($sql);
		if(mysql_num_rows($sql)==1){
			if(($row['id']==$id) AND ($row['user_id']==myID() OR isUserAuthorized(deleteOthersBlog))){
				$query = "DELETE FROM `blogs` WHERE `id` = '".$_GET['id']."'";
				$resultaat = mysql_query($query);
				if($resultaat){
					if(isUserAuthorized(deleteOthersBlog)){
						echo 'Verwijderen is geslaagd!';
					} else {
						header('Location: ./');
					}
				}else{ echo "Mislukt! ".mysql_error(); }
			}else{ echo 'Geen voldoende rechten!'; }
		}else{ echo 'Geen geldige aanvraag!'; }
	}else{ echo 'Geen geldige aanvraag!'; }
}else{ echo "Je bent nog niet ingelogd!"; }
?>