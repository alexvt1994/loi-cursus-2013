<?php
defined('_TPL') or die('Restricted access');
if(check_login()){
	$formulier = TRUE;
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$aFout = array();
		$user = mysql_real_escape_string(trim($_POST['user']));
		$pass = mysql_real_escape_string(trim($_POST['pass']));
		$email = mysql_real_escape_string(trim($_POST['email']));
		$schermnaam = mysql_real_escape_string(trim($_POST['schermnaam']));
		if(empty($user)){
			$aFout[] = 'Er is geen gebruikersnaam ingevuld.';
            $fout['text']['user'] = TRUE;
            $fout['input']['user'] = TRUE;
		}
		elseif(strlen($user) < 3){
			$aFout[] = 'Gebruikersnaam moet minimaal uit 3 tekens bestaan.';
            $fout['text']['user'] = TRUE;
            $fout['input']['user'] = TRUE;
		}
		if(empty($pass)){
			$aFout[] = 'Er is geen wachtwoord ingevuld.';
            $fout['text']['pass'] = TRUE;
            $fout['input']['pass'] = TRUE;
		}
		elseif(strlen($pass) < 8){
			$aFout[] = 'Wachtwoord moet minimaal uit 8 tekens bestaan.';
            $fout['text']['pass'] = TRUE;
            $fout['input']['pass'] = TRUE;
		}
		if(empty($email) || checkmail($email) == 0){
			$aFout[] = 'Er is geen e-mailadres ingevuld.';
            $fout['text']['email'] = TRUE;
            $fout['input']['email'] = TRUE;
		}
		if(empty($schermnaam)){
			$aFout[] = 'Er is geen schermnaam ingevuld.';
            $fout['text']['schermnaam'] = TRUE;
            $fout['input']['schermnaam'] = TRUE;
		}
		if(!empty($aFout)){ /* TRUE */
			$errors = '';
			foreach($aFout as $sFout){
				$errors .= '    * '.$sFout.'<br />'.PHP_EOL;
			}
			$errors .= '<br />'.PHP_EOL;
		}else{ /* FALSE */
            $formulier = FALSE;
			$sql = "INSERT INTO `login`
				(`user`,`pass`,`email`,`schermnaam`)
					VALUES
				('".$user."','".md5($pass)."','".$email."','".$schermnaam."')";
			if(mysql_query($sql)){
				echo 'Wel toegevoegd!';
                unset($user, $pass, $email, $schermnaam);
			}else{
				echo 'Niet toegevoegd!<br />MySQL Error: '.mysql_error();
			}
		}
	}
	if($formulier){
		echo '<h2>Gebruiker toevoegen</h2>';
		if(isset($errors)) { echo $errors; }
		echo '<form action="" method="post">';
		echo '<label'.((isset($fout['text']['user']))?' class="fout"':'').'>Gebruikersnaam:</label><br />';
		echo '<input type="text" name="user" maxlength="40" '.((isset($fout['input']['user']))?'class="fout"':'').' value="'.((!empty($user))?stripslashes($user):'').'" /><br />';
		echo '<br />';
		echo '<label'.((isset($fout['text']['pass']))?' class="fout"':'').'>Wachtwoord:</label><br />';
		echo '<input type="password" name="pass" maxlength="40" '.((isset($fout['input']['pass']))?'class="fout"':'').' value="'.((!empty($pass))?stripslashes($pass):'').'" /><br />';
		echo '<br />';
		echo '<label'.((isset($fout['text']['email']))?' class="fout"':'').'>E-mailadres:</label><br />';
		echo '<input type="text" name="email" maxlength="40" '.((isset($fout['input']['email']))?'class="fout"':'').' value="'.((!empty($email))?stripslashes($email):'').'" /><br />';
		echo '<br />';
		echo '<label'.((isset($fout['text']['schermnaam']))?' class="fout"':'').'>Schermnaam:</label><br />';
		echo '<input type="text" name="schermnaam" maxlength="40" '.((isset($fout['input']['schermnaam']))?'class="fout"':'').' value="'.((!empty($schermnaam))?stripslashes($schermnaam):'').'" /><br />';
		echo '<br />';
		echo '<input type="submit" name="submit" value=" Verzenden " />';
		echo '</form>';
	}
}else{ echo 'Sorry, deze actie is niet toegestaan!'; }
?>