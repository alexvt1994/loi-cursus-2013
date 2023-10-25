<?php
defined('_TPL') or die('Restricted access');
$sql = mysql_query("SELECT * FROM `competitieschema` WHERE `score_thuis`!='0' AND `score_uit`!='0'");
$num = mysql_num_rows($sql);
$colortoggle=TRUE;
?>
<h1>Gespeelde wedstrijden</h1>
<?php
if($num!=0){
	echo '<ul>';
	while($row = mysql_fetch_assoc($sql)){
		echo '<li class="left '.($colortoggle?'dark':'light').'"><a href="./viewscore&id='.$row['id'].'">'.db_element('voetbalteams',$row['thuis_id'],'naam').' - '.db_element('voetbalteams',$row['uit_id'],'naam').'</a>';
		echo (check_login())?' <small>(<a href="./score&id='.$row['id'].'">Score aanpassen</a>)</small>':'';
		echo '</li>';
		echo '<li class="right '.($colortoggle?'dark':'light').'">'.$row['score_thuis'].'</li><li class="right '.($colortoggle?'dark':'light').'">'.$row['score_uit'].'</li>';
		$colortoggle = !$colortoggle;
	}
	echo '</ul>';
}else{
	echo '<ul><li class="left light">Leeg</li></ul>';
}
$sql = mysql_query("SELECT * FROM `competitieschema` WHERE `score_thuis`='0' AND `score_uit`='0'");
$num = mysql_num_rows($sql);
$colortoggle=TRUE;
?>
<br style="clear:both;" />
<h1>Aankomende wedstrijden</h1>
<?php
if($num!=0){
	echo '<ul>';
	while($row = mysql_fetch_assoc($sql)){
		echo '<li class="left '.($colortoggle?'dark':'light').'"><a href="./viewscore&id='.$row['id'].'">'.db_element('voetbalteams',$row['thuis_id'],'naam').' - '.db_element('voetbalteams',$row['uit_id'],'naam').'</a>';
		echo (check_login())?' <small>(<a href="./score&id='.$row['id'].'">Score invullen</a>)</small>':'';
		echo '</li>';
		echo '<li class="right '.($colortoggle?'dark':'light').'">'.$row['score_thuis'].'</li><li class="right '.($colortoggle?'dark':'light').'">'.$row['score_uit'].'</li>';
		$colortoggle = !$colortoggle;
	}
	echo '</ul>';
}else{
	echo '<ul><li class="left light">Leeg</li></ul>';
}
?>