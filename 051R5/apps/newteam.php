<?php
defined('_TPL') or die('Restricted access');
if(check_login()){
	$formulier = TRUE;
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$aFout = array();
		$naam = mysql_real_escape_string(trim($_POST['naam']));
		$plaats = mysql_real_escape_string(trim($_POST['plaats']));
		$speelsterkte = mysql_real_escape_string(trim($_POST['speelsterkte']));
		if(empty($naam)){
			$aFout[] = 'Er is geen teamnaam ingevuld.';
            $fout['text']['naam'] = TRUE;
            $fout['input']['naam'] = TRUE;
		}
		if(empty($plaats)){
			$aFout[] = 'Er is geen plaats ingevuld.';
            $fout['text']['plaats'] = TRUE;
            $fout['input']['plaats'] = TRUE;
		}
		if(empty($speelsterkte)){
			$aFout[] = 'Er is geen speelsterkte ingevuld.';
            $fout['text']['speelsterkte'] = TRUE;
            $fout['input']['speelsterkte'] = TRUE;
		}
        if(!empty($aFout)){ /* TRUE */
			$errors = '';
			foreach($aFout as $sFout){
				$errors .= '    * '.$sFout.'<br />'.PHP_EOL;
			}
			$errors .= '<br />'.PHP_EOL;
		}else{ /* FALSE */
			$sql = "INSERT INTO `voetbalteams`
                (`naam`,`plaats`,`speelsterkte`)
                    VALUES
                ('".$naam."','".$plaats."','".$speelsterkte."')";
			if(mysql_query($sql)){
				echo 'Toegevoegd!';
                unset($naam, $plaats, $speelsterkte);
			}else{
				echo 'Niet toegevoegd!<br />MySQL Error: '.mysql_error();
			}
		}
	}
	if($formulier){
		echo '<h2>Team toevoegen</h2>';
		if(isset($errors)) { echo $errors; }
		echo '<form action="" method="post">';
		echo '<label'.((isset($fout['text']['naam']))?' class="fout"':'').'>Naam:</label><br />';
		echo '<input type="text" name="naam" maxlength="40" '.((isset($fout['input']['naam']))?'class="fout"':'').' value="'.((!empty($naam))?stripslashes($naam):'').'" /><br />';
		echo '<br />';
		echo '<label'.((isset($fout['text']['plaats']))?' class="fout"':'').'>Plaats:</label><br />';
		echo '<input type="text" name="plaats" maxlength="40" '.((isset($fout['input']['plaats']))?'class="fout"':'').' value="'.((!empty($plaats))?stripslashes($plaats):'').'" /><br />';
		echo '<br />';
		echo '<label'.((isset($fout['text']['speelsterkte']))?' class="fout"':'').'>Speelsterkte:</label><br />';
		echo '<input type="text" name="speelsterkte" maxlength="40" '.((isset($fout['input']['speelsterkte']))?'class="fout"':'').' value="'.((!empty($speelsterkte))?stripslashes($speelsterkte):'').'" /><br />';
		echo '<br />';
		echo '<input type="submit" name="submit" value=" Verzenden " />';
		echo '</form>';
	}
}else{ echo 'Sorry, deze actie is niet toegestaan!'; }
?>