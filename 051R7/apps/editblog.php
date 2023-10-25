<?php
defined('_TPL') or die('Restricted access');
echo '<h2>Blog bewerken:</h2>';
if(check_login()){
	$formulier = TRUE;
	$action = (!empty($_GET['action'])?trim($_GET['action']):'');
	$id = (!empty($_GET['id']) && is_numeric($_GET['id'])?trim($_GET['id']):'');
	if((isUserAuthorized(editBlog) OR isUserAuthorized(editOthersBlog)) && $id){
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$sql = mysql_query("SELECT `id`, `user_id`, `title`,`text` FROM `blogs` WHERE `id` = '".$id."'");
			$row = mysql_fetch_assoc($sql);
			if(mysql_num_rows($sql)==1){
				if(($row['id']==$id) AND ($row['user_id']==myID() OR isUserAuthorized(editOthersBlog))){
					$aFout = array();
					$title = trim($_POST['title']);
					$text = trim($_POST['text']);

					//als alles is ingevuld
					if(empty($title)){
						$aFout[] = 'Je bent vergeten een titel in te vullen!<br />';
						$fout['text']['title'] = TRUE;
						$fout['input']['title'] = TRUE;
					}
					if(empty($text)){
						$aFout[] = 'Je bent vergeten je bericht in te vullen!<br />';
						$fout['text']['text'] = TRUE;
						$fout['input']['text'] = TRUE;
					}
					//als er een true word gekregen dan gebruiken we het true gedeelte, als alles is ingevuld en we krijgen niks terug, dan gebruiken we de false
					if(!empty($aFout)){
						$errors = '';
						foreach($aFout as $sFout){
							$errors .= '    * '.$sFout.'<br />';
						}
						$errors .= '<br />';
					}else{ /* FALSE */
					$formulier = FALSE;
						//de gegevens beveiligen tegen mysql injection
						$title		= htmlentities($title);
						$text		= htmlentities($text);
						
						//de variabelen geescaped
						$title		= mysql_real_escape_string($title);
						$text		= mysql_real_escape_string($text);
						
						//de query om de gegevens in te voeren
						$query = mysql_query("UPDATE `blogs` SET
							`title` = '".$title."',
							`text` = '".$text."',
							`edit_datetime` = NOW()
						WHERE `id` = '".$id."'");
						
						//als de query succesvol wordt uitgevoerd
						if($sql){
							header('Location: ./showblogs&userid='.$row['user_id']);
						}else{
							echo 'Je bent (nog) <b>niet</b> geregistreerd';
						}
					}
				}else{ echo 'Geen voldoende rechten!'; }
			}else{ echo 'Geen geldige aanvraag!'; }
		}
		if($formulier){
			$sql = mysql_query("SELECT `id`, `user_id`, `title`,`text` FROM `blogs` WHERE `id` = '".$id."'");
			$row = mysql_fetch_assoc($sql);
			if(mysql_num_rows($sql)==1){
				if(($row['id']==$id) AND ($row['user_id']==myID() OR isUserAuthorized(editOthersBlog))){
					$title = (empty($title))?$row['title']:$title;
					$text = (empty($text))?$row['text']:$text;
					?>
					<form action="" method="post">
						<p>
							<?php if(isset($errors)){ echo $errors; } ?>
							<label <?php if(isset($fout['text']['title'])) { echo 'class="fout"'; } ?>>Titel:</label> <input type="text" name="title" <?php if(isset($fout['input']['title'])) { echo 'class="fout"'; } ?> value="<?php if (!empty($title)) { echo stripslashes($title); } ?>" /><br />
							<label <?php if(isset($fout['text']['text'])) { echo 'class="fout"'; } ?>>Bericht:</label> <textarea name="text" <?php if(isset($fout['input']['text'])) { echo 'class="fout"'; } ?>><?php if (!empty($text)) { echo stripslashes($text); } ?></textarea><br />
							<input type="submit" value="Verzenden" /> <input type="reset" value="Wissen" /><br />
						</p>
					</form>
					<?php
				}else{ echo 'Geen voldoende rechten!'; }
			}else{ echo 'Geen geldige aanvraag!'; }
		}
	}else{ echo 'Geen voldoende rechten!'; }
}else{ echo "Je bent nog niet ingelogd!"; }
?>