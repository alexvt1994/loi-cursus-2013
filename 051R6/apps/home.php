<?php
defined('_TPL') or die('Restricted access');
$formulier = TRUE;
$sportonderdelen = array('tennis','voetbal','tafeltennis','biljart');
$lesdagen = array('maandag','dinsdag','woensdag','donderdag','vrijdag');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$aFout = array();
	$voornaam = mysql_real_escape_string(trim($_POST['voornaam']));
	$tussenvoegsels = mysql_real_escape_string(trim($_POST['tussenvoegsels']));
	$achternaam = mysql_real_escape_string(trim($_POST['achternaam']));
	$straat = mysql_real_escape_string(trim($_POST['straat']));
	$huisnummer = mysql_real_escape_string(trim($_POST['huisnummer']));
	$postcode = mysql_real_escape_string(trim($_POST['postcode']));
	$woonplaats = mysql_real_escape_string(trim($_POST['woonplaats']));
	$emailadres = mysql_real_escape_string(trim($_POST['emailadres']));
	$geboortedatum = mysql_real_escape_string(trim($_POST['geboortedatum']));
	$geboortedatum_arr  = explode('-', $geboortedatum);
	$geslacht = mysql_real_escape_string(trim($_POST['geslacht']));
	$datumingang = mysql_real_escape_string(trim($_POST['datumingang']));
	$datumingang_arr  = explode('-', $geboortedatum);
	$datumeinde = mysql_real_escape_string(trim($_POST['datumeinde']));
	$datumeinde_arr  = explode('-', $geboortedatum);
	$sportonderdeel = mysql_real_escape_string(trim($_POST['sportonderdeel']));
	$lesdag = mysql_real_escape_string(trim($_POST['lesdag']));
	if(empty($voornaam)){
		$aFout[] = 'Er is geen voornaam ingevuld.';
		$fout['input']['voornaam'] = TRUE;
	}
	if(empty($achternaam)){
		$aFout[] = 'Er is geen achternaam ingevuld.';
		$fout['input']['achternaam'] = TRUE;
	}
	if(empty($straat)){
		$aFout[] = 'Er is geen straat ingevuld.';
		$fout['input']['straat'] = TRUE;
	}
	if(empty($huisnummer) || is_numeric($huisnummer)){
		$aFout[] = 'Er is geen huisnummer ingevuld.';
		$fout['input']['huisnummer'] = TRUE;
	}
	if(empty($postcode) || !preg_match('/^[1-9]{1}[0-9]{3}\s?[A-Za-z]{2}$/', $postcode)){
		$aFout[] = 'Er is geen postcode ingevuld.';
		$fout['input']['postcode'] = TRUE;
	}
	if(empty($woonplaats)){
		$aFout[] = 'Er is geen woonplaats ingevuld.';
		$fout['input']['woonplaats'] = TRUE;
	}
	if(empty($emailadres) || checkmail($emailadres) == 0){
		$aFout[] = 'Er is geen emailadres ingevuld.';
		$fout['input']['emailadres'] = TRUE;
	}
	if(empty($geboortedatum)){
		$aFout[] = 'Er is geen geboortedatum ingevuld.';
		$fout['input']['geboortedatum'] = TRUE;
	}
	elseif(sizeof($geboortedatum_arr) != 3 || !checkdate($geboortedatum_arr[1], $geboortedatum_arr[0], $geboortedatum_arr[2])) {
		$aFout[] = 'Geboortedatum is niet geldig.';
	}
	if(empty($geslacht) || $geslacht=='m' || $geslacht=='v'){
		$aFout[] = 'Er is geen (geldige) geslacht ingevuld.';
	}
	if(empty($datumingang)){
		$aFout[] = 'Er is geen datumingang ingevuld.';
		$fout['input']['datumingang'] = TRUE;
	}
	elseif(sizeof($datumingang_arr) != 3 || !checkdate($datumingang_arr[1], $datumingang_arr[0], $datumingang_arr[2])) {
		$aFout[] = 'Speeldatum is niet geldig.';
	}
	if(empty($datumeinde)){
		$aFout[] = 'Er is geen datumeinde ingevuld.';
		$fout['input']['datumeinde'] = TRUE;
	}
	if(!in_array($sportonderdeel, $sportonderdelen)){
		$aFout[] = 'Er is geen geldige sportonderdeel ingevuld.';
		$fout['input']['sportonderdeel'] = TRUE;
	}
	if(!in_array($lesdag, $lesdagen)){
		$aFout[] = 'Er is geen geldige lesdag ingevuld.';
		$fout['input']['lesdag'] = TRUE;
	}
	if(!empty($aFout)){ /* TRUE */
		$errors = '';
		foreach($aFout as $sFout){
			$errors .= '    * '.$sFout.'<br />'.PHP_EOL;
		}
		$errors .= '<br />'.PHP_EOL;
	}else{ /* FALSE */
		$geboortedatum_for_db = $geboortedatum_arr[2].'-'.$geboortedatum_arr[1].'-'.$geboortedatum_arr[0];
		$datumingang_for_db = $geboortedatum_arr[2].'-'.$geboortedatum_arr[1].'-'.$geboortedatum_arr[0];
		$sql = "INSERT INTO `leden`(
				`voornaam`,`tussenvoegsels`,`achternaam`,`straat`,`huisnummer`,`postcode`,`woonplaats`,`emailadres`,`geboortedatum`,`geslacht`
			) VALUES (
				'".$voornaam."','".$tussenvoegsels."','".$achternaam."','".$straat."','".$huisnummer."','".$postcode."','".$woonplaats."','".$emailadres."','".$geboortedatum_for_db."','".$geslacht."'
			)";
		if(mysql_query($sql)){
			$headers_bevestiging  = 'MIME-Version: 1.0' . "\r\n";
			$headers_bevestiging .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers_bevestiging .= 'From: Testelatest <no-reply@lexoft.nl>'."\r\n".'X-Mailer: PHP/' . phpversion();
			$subject_bevestiging = 'Bevestiging';
			$body_bevestiging = '<html>';
			$body_bevestiging = '<body>';
			$body_bevestiging = 'Hierbij een bevestiging van de sport die je hebt uitgezocht: <strong>'.$sportonderdeel.'</strong>';
			$body_bevestiging = '</body>';
			$body_bevestiging = '</html>';

			$headers_admin  = 'MIME-Version: 1.0' . "\r\n";
			$headers_admin .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers_admin .= 'From: Testelatest <no-reply@lexoft.nl>'."\r\n".'X-Mailer: PHP/' . phpversion();
			$subject_admin = 'Bevestiging';
			$body_admin = '<html>';
			$body_admin = '<body>';
			$body_admin = 'Hierbij een bevestiging van de sport die je hebt uitgezocht: <strong>'.$sportonderdeel.'</strong>';
			$body_admin = '</body>';
			$body_admin = '</html>';
			if(mail($emailadres, $subject_bevestiging, $body_bevestiging, $headers_bevestiging) /* Lid */ && mail($mailadmin, $subject_admin, $body_admin, $headers_admin) /* Ledenadministratie */){
				echo 'Toegevoegd!';
				unset($voornaam,$tussenvoegsels,$achternaam,$straat,$huisnummer,$postcode,$woonplaats,$emailadres,$geboordedatum,$geslacht,$datumingang,$datumeinde,$sportonderdeel,$lesdag);
			}else{
				echo 'Niet toegevoegd!';
			}
		}else{
			echo 'Niet toegevoegd!<br />MySQL Error: '.mysql_error();
		}
	}
}
if($formulier){
	echo '<h2>Inschrijfformulier</h2>';
	if(isset($errors)) { echo $errors; }
	echo '<form action="" method="post">';
	echo '<table>';
	echo '<tr><td colspan=2><strong>Persoonsgegevens:</strong></td></tr>';
	echo '<tr><td>Voornaam*:</td><td><input type="text" name="voornaam" maxlength="20" '.((isset($fout['input']['voornaam']))?'class="fout"':'').' value="'.((!empty($voornaam))?stripslashes($voornaam):'').'" /></td></tr>';
	echo '<tr><td>Tussenvoegsels:</td><td><input type="text" name="tussenvoegsels" maxlength="15" value="'.((!empty($tussenvoegsels))?stripslashes($tussenvoegsels):'').'" /></td></tr>';
	echo '<tr><td>Achternaam*:</td><td><input type="text" name="achternaam" maxlength="30" '.((isset($fout['input']['achternaam']))?'class="fout"':'').' value="'.((!empty($achternaam))?stripslashes($achternaam):'').'" /></td></tr>';
	echo '<tr><td>Straat*:</td><td><input type="text" name="straat" maxlength="50" '.((isset($fout['input']['straat']))?'class="fout"':'').' value="'.((!empty($straat))?stripslashes($straat):'').'" /></td></tr>';
	echo '<tr><td>Huisnummer*:</td><td><input type="text" name="huisnummer" maxlength="10" '.((isset($fout['input']['huisnummer']))?'class="fout"':'').' value="'.((!empty($huisnummer))?stripslashes($huisnummer):'').'" /></td></tr>';
	echo '<tr><td>Postcode*:</td><td><input type="text" name="postcode" maxlength="6" '.((isset($fout['input']['postcode']))?'class="fout"':'').' value="'.((!empty($postcode))?stripslashes($postcode):'').'" /> <i>(1234AB)</i></td></tr>';
	echo '<tr><td>Woonplaats*:</td><td><input type="text" name="woonplaats" maxlength="30" '.((isset($fout['input']['woonplaats']))?'class="fout"':'').' value="'.((!empty($woonplaats))?stripslashes($woonplaats):'').'" /></td></tr>';
	echo '<tr><td>Emailadres*:</td><td><input type="text" name="emailadres" maxlength="50" '.((isset($fout['input']['emailadres']))?'class="fout"':'').' value="'.((!empty($emailadres))?stripslashes($emailadres):'').'" /></td></tr>';
	echo '<tr><td>Geboortedatum*:</td><td><input type="text" name="geboortedatum" '.((isset($fout['input']['geboortedatum']))?'class="fout"':'').' maxlength="30" value="'.((!empty($geboortedatum))?stripslashes($geboortedatum):'').'" /> <i>(dd-mm-yyyy)</i></td></tr>';
	echo '<tr><td>Geslacht:</td><td><input type="radio" name="geslacht" value="M" checked> M <input type="radio" name="geslacht" value="V"> V</td></tr>';
	echo '<tr><td colspan=2><strong>Sport:</strong></td></tr>';
	echo '<tr><td>Datumingang:</td><td><input type="text" name="datumingang" maxlength="30" '.((isset($fout['input']['datumingang']))?'class="fout"':'').' value="'.((!empty($datumingang))?stripslashes($datumingang):'').'" /> <i>(dd-mm-yyyy)</i></td></tr>';
	echo '<tr><td>Datumeinde:</td><td><input type="text" name="datumeinde" maxlength="30" '.((isset($fout['input']['datumingang']))?'class="fout"':'').' value="'.((!empty($datumeinde))?stripslashes($datumeinde):'').'" /> <i>(dd-mm-yyyy)</i></td></tr>';
	asort($sportonderdelen);
	echo '<tr><td>Sportonderdelen</td><td><select name="sportonderdeel">';
	foreach($sportonderdelen as $sport){
		echo '<option value="'.$sport.'"'.(($sport==$sportonderdeel)?' selected':'').'>'.ucfirst($sport).'</option>';
	}
	echo '</select></td></tr>';
	echo '<tr><td>Lesdag:</td><td><select name="lesdag">';
	foreach($lesdagen as $lesdag){
		echo '<option value="'.$lesdag.'">'.ucfirst($lesdag).'</option>';
	}
	echo '</select></td></tr>';
	echo '<tr><td><input type="submit" name="submit" value=" Verzenden " /></td><td><input type="submit" name="reset" value=" Wissen " /></td></tr>';
	echo '</table>';
	echo '</form>';
}
?>