<?php
defined('_TPL') or die('Restricted access');
if(check_login()){
	$teams = array();
	$sql = mysql_query("SELECT `id`,`naam` FROM `voetbalteams` ORDER BY `naam` ASC");
	while($res = mysql_fetch_array($sql)){
		$teams[$res['id']] = $res['naam'];
	}
	if(!empty($teams)){
		$formulier = TRUE;
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$aFout = array();
			$thuis = mysql_real_escape_string(trim($_POST['thuis']));
			$uit = mysql_real_escape_string(trim($_POST['uit']));
			$speeldatum = mysql_real_escape_string(trim($_POST['speeldatum']));
			$speeldatum_arr  = explode('-', $speeldatum);
			if(!is_numeric($thuis)){
				$aFout[] = 'Er is geen thuis ingevuld.';
			}
			if(!is_numeric($uit)){
				$aFout[] = 'Er is geen uit ingevuld.';
			}
			if($thuis == $uit){
				$aFout[] = '\'Thuis\' en \'uit\' kan niet gelijk zijn.';
			}
			if(empty($speeldatum)){
				$aFout[] = 'Er is geen datum ingevuld.';
			}
			elseif(sizeof($speeldatum_arr) != 3 || !checkdate($speeldatum_arr[1], $speeldatum_arr[0], $speeldatum_arr[2])) {
				$aFout[] = 'Speeldatum is niet geldig.';
			}
			if(!empty($aFout)){ /* TRUE */
				$errors = '';
				foreach($aFout as $sFout){
					$errors .= '    * '.$sFout.'<br />'.PHP_EOL;
				}
				$errors .= '<br />'.PHP_EOL;
			}else{ /* FALSE */
				$date_for_db = $speeldatum_arr[2].'-'.$speeldatum_arr[1].'-'.$speeldatum_arr[0];
				$sql = "INSERT INTO `competitieschema`
						(`speeldatum`, `thuis_id`,`uit_id`)
							VALUES
						('".$date_for_db."','".$thuis."','".$uit."')";
				if(mysql_query($sql)){
					unset($thuis, $uit);
					header("Location: ./viewscore&id=".mysql_insert_id());
				}else{
					echo 'Niet toegevoegd!<br />MySQL Error: '.mysql_error();
				}
			}
		}
		if($formulier){
			echo '<h2>Wedstrijd toevoegen</h2>';
			if(isset($errors)) { echo $errors; }
			echo '<form action="" method="post">';
			echo '<br />';
			echo 'Wedstrijd <select name="thuis">';
			foreach($teams as $id=>$team){
				echo '<option value="'.$id.'"'.(($id==$thuis)?' selected':'').'>'.$team.'</option>';
			}
			echo '</select> tegen <select name="uit">';
			foreach($teams as $id=>$team){
				echo '<option value="'.$id.'"'.(($id==$uit)?' selected':'').'>'.$team.'</option>';
			}
			echo '</select> op  <input type="text" name="speeldatum" value="'.((!empty($speeldatum))?$speeldatum:'').'" /> (dd-mm-yyyy) <input type="submit" value=" Verzenden " />';
			echo '</form>';
		}
	}else{ echo 'Sorry, deze actie is (nog) niet beschikbaar!'; }
}else{ echo 'Sorry, deze actie is niet toegestaan!'; }
?>