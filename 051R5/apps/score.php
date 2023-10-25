<?php
defined('_TPL') or die('Restricted access');
if(check_login()){
	if(isset($_GET['id']) && is_numeric($_GET['id'])){
      $sql = mysql_query("SELECT * FROM `competitieschema` WHERE `id`='".$_GET['id']."'");
      $count = mysql_num_rows($sql);
      if($count!=0){
		$res = mysql_fetch_assoc($sql);
    	if($_SERVER['REQUEST_METHOD'] == 'POST'){
    		$score_thuis = mysql_real_escape_string(trim($_POST['score_thuis']));
    		$score_uit = mysql_real_escape_string(trim($_POST['score_uit']));
			if(empty($score_thuis)){
				echo 'U heeft geen thuis-score ingevuld<br />';
				$terug = true;
    		}
    		if(empty($score_uit)){
    			echo 'U heeft geen uit-score ingevuld<br />';
    			$terug = true;
    		}
    		if(isset($terug)){ /* TRUE */
    			echo '<br />U heeft het formulier niet volledig ingevuld!<br />Klik <a href="javascript:history.go(-1)">hier</a> om het nog een keer te proberen.';
    		}else{ /* FALSE */
     			$sql = "INSERT INTO `competitieschema`
                    (`score_thuis`,`score_uit`)
                        VALUES
                    ('".$score_thuis."','".$score_uit."')";
    			if(mysql_query($sql)){
    				echo 'Wel toegevoegd!';
    			}else{
    				echo 'Niet toegevoegd!<br />MySQL Error: '.mysql_error();
    			}
    		}
    	}else{
    		echo '<form action="" method="post">';
    		echo '<h2>Score toevoegen/bewerken</h2>';
    		echo 'Thuis-score:<br /><input type="text" maxlength="40" name="score_thuis" value="'.$res['score_thuis'].'" /><br />';
    		echo '<br />';
    		echo 'Uit-score:<br /><input type="text" maxlength="40" name="score_uit" value="'.$res['score_uit'].'" /><br />';
    		echo '<br />';
    		echo '<input type="submit" name="submit" value=" Verzenden " />';
    		echo '</form>';
    	}
      }else{ echo 'Sorry, deze actie is niet toegestaan!'; }
    }else{ echo 'Sorry, deze actie is niet toegestaan!'; }
}else{ echo 'Sorry, deze actie is niet toegestaan!'; }
?>