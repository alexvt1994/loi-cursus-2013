<?php
defined('_TPL') or die('Restricted access');
if(!check_login()){
	require_once('secure/generate.func.php');
	$formulier = TRUE;
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$aFout = array();
		$captcha = trim($_POST['captcha']);
		$naam = trim($_POST['naam']);
		$user = trim($_POST['username']);
		$email = trim($_POST['email']);

		//als alles is ingevuld
		if(empty($naam)){
			$aFout[] = 'Je bent vergeten je naam in te vullen!';
			$fout['text']['naam'] = TRUE;
			$fout['input']['naam'] = TRUE;
		}
		if(empty($user)){
			$aFout[] = 'Je bent vergeten je username in te vullen!';
			$fout['text']['user'] = TRUE;
			$fout['input']['user'] = TRUE;
		}
		if(empty($email)){
			$aFout[] = 'Je bent vergeten je e-mailadres in te vullen!';
			$fout['text']['email'] = TRUE;
			$fout['input']['email'] = TRUE;
		}
		elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$aFout[] = 'Geldig e-mailadres alsjeblieft!';
			$fout['text']['email'] = TRUE;
			$fout['input']['email'] = TRUE;
		}
		if(empty($captcha)){
			$aFout[] = 'Captcha is niet ingevuld!';
			$fout['text']['captcha'] = TRUE;
			$fout['input']['captcha'] = TRUE;
		}
		elseif(sha1($captcha) != $_SESSION["captcha_code"]){
			$aFout[] = 'Captcha klopt niet!';
			$fout['text']['captcha'] = TRUE;
			$fout['input']['captcha'] = TRUE;
		}
		//als er een true word gekregen dan gebruiken we het true gedeelte, als alles is ingevuld en we krijgen niks terug, dan gebruiken we de false
		if(!empty($aFout)){ /* TRUE */
			$errors = '';
			foreach($aFout as $sFout){
				$errors .= '* '.$sFout.'<br />';
			}
			$errors .= '<br />';
		}else{ /* FALSE */
			$formulier = FALSE;
			unset($_SESSION["captcha"]);
			//de gegevens beveiligen tegen mysql injection
			$naam			= htmlentities($naam);
			$user			= htmlentities($user);
			$email			= htmlentities($email); 
			
			//de query en resultset om te kijken of er al een gebruiker die zo heet bestaat
			$sql = "SELECT `id` FROM `login` WHERE `user` = '".$user."'";
			$res = mysql_query($sql);
			
			//als het resultaat voor deze naam 0 is dan is deze gebruikersnaam nog niet bezet
			if(mysql_num_rows($res) == 0){
				//de variabelen geescaped
				$naam		= mysql_real_escape_string($naam);
				$user		= mysql_real_escape_string($user);
				$email		= mysql_real_escape_string($email);
				
				//de random pass genereren
				$genpass = maakpass(10);
				$pass = md5($genpass);
				
				//de query om de gegevens in te voeren
				$sql = mysql_query("INSERT INTO `login` (`schermnaam`, `user`, `pass`, `email`, `regdate`) VALUES ('".$naam."', '".$user."', '".$pass."', '".$email."', NOW())");
				
				//de mail gegevens
				$subject = "Accountregistratie";
				$message = nl2br("Je hebt een account geregistreerd.

							Gebruikersnaam: ".$user."
							Wachtwoord: ".htmlentities($genpass)."

							Heb jij je niet geregistreerd, doe dan niets.");
				
				$header = "From: Lexoft <noreply@lexoft.nl>\r\n";
				$header .= "MIME-Version: 1.0\r\n";
				$header .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$header .= "X-Priority: 0\r\n"; # 1 voor erg belangrijk
				$header .= "X-MSMail-Priority: High\r\n"; 
				$header .= "X-Mailer: PHP/".phpversion();
				
				//als de query succesvol wordt uitgevoerd
				if($sql AND @mail($email, $subject, $message, $header)){
					echo '<p>Bedankt voor het registreren.</p><p>Er is een e-mail gestuurd naar <b>'.$email.'</b>. Hierin vind je een link welke je moet gebruiken om je account te activeren. Veel plezier!</p>';
				}else{
					echo 'Je bent (nog) <b>niet</b> geregistreerd.';
				}
			}else{
				echo 'De ingevoerde gebruikersnaam bestaat al.';
			}
		}
	}
	if($formulier){
	?>
		<form action="" method="post">
			<p>
				<h2>Account registreren:</h2>
				<?php if(isset($errors)){ echo $errors; } ?>
				<label <?php if(isset($fout['text']['naam'])) { echo 'class="fout"'; } ?>>Naam*:</label> <input type="text" name="naam" <?php if(isset($fout['input']['naam'])) { echo 'class="fout"'; } ?> maxlength="50" value="<?php if (!empty($naam)) { echo stripslashes($naam); } ?>" /><br />
				<label <?php if(isset($fout['text']['user'])) { echo 'class="fout"'; } ?>>Gebruikersnaam*:</label> <input type="text" name="username" <?php if(isset($fout['input']['user'])) { echo 'class="fout"'; } ?> maxlength="50" value="<?php if (!empty($user)) { echo stripslashes($user); } ?>" /><br />
				<label>Wachtwoord:</label> Wordt automatisch gegenereerd.<br />
				<br />
				<label <?php if(isset($fout['text']['email'])) { echo 'class="fout"'; } ?>>Emailadres*:</label> <input type="pass" name="email" <?php if(isset($fout['input']['email'])) { echo 'class="fout"'; } ?> maxlength="40" value="<?php if (!empty($email)) { echo stripslashes($email); } ?>" /><br />
				<label><img src="secure/captcha.php" /></label> Neem de code precies zo over zoals aangegeven.<br />
				<label <?php if(isset($fout['text']['captcha'])) { echo 'class="fout"'; } ?>>Code*:</label> <input type="text" name="captcha"  <?php if(isset($fout['input']['captcha'])) { echo 'class="fout"'; } ?>><br />
				<br />
				<input type="submit" value="Registreer"> <input type="reset" value="Wissen">
			</p>
		</form>
	<?php
	}
}else{ echo "Je bent al ingelogd!"; }
?>