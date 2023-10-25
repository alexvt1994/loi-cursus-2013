<?php
defined('_TPL') or die('Restricted access');
echo '<h2>Blog toevoegen:</h2>';
if(check_login()){
	$formulier = TRUE;
	if(isUserAuthorized(addBlog)){
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$aFout = array();
			$title = trim($_POST['title']);
			$text = trim($_POST['text']);

			//als alles is ingevuld
			if(empty($title)){
				$aFout[] = 'Je bent vergeten een titel in te vullen!';
				$fout['text']['title'] = TRUE;
				$fout['input']['title'] = TRUE;
			}
			if(empty($text)){
				$aFout[] = 'Je bent vergeten je bericht in te vullen!';
				$fout['text']['text'] = TRUE;
				$fout['input']['text'] = TRUE;
			}
			//als er een true word gekregen dan gebruiken we het true gedeelte, als alles is ingevuld en we krijgen niks terug, dan gebruiken we de false
			if(!empty($aFout)){ /* TRUE */
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
				$sql = mysql_query("INSERT INTO `blogs` (`user_id`, `title`, `text`, `datetime`) VALUES ('".myID()."', '".$title."', '".$text."', NOW())");
				
				//als de query succesvol wordt uitgevoerd
				if($sql){
					header('Location: ./showblogs&userid='.myID());
				}else{
					echo 'Er is iets fouts gegaan met het plaatsen';
				}
			}
		}
		if($formulier){
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
		}
	}
}else{ echo "Je bent nog niet ingelogd!"; }
?>