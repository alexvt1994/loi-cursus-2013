<?php
defined('_TPL') or die('Restricted access');
if(check_login()){
if(isset($_GET['id']) && is_numeric($_GET['id'])){
$sql = mysql_query("SELECT *, DATE_FORMAT(`speeldatum`, '%d-%m-%Y') AS `speeldatum` FROM `competitieschema` WHERE `id`='".$_GET['id']."'");
$num = mysql_num_rows($sql);
$colortoggle=TRUE;
if($num!=0){
?>
<ul>
<?php
	while($row = mysql_fetch_assoc($sql)){
		echo '<li class="left '.($colortoggle?'dark':'light').'">'.db_element('voetbalteams',$row['thuis_id'],'naam').' - '.db_element('voetbalteams',$row['uit_id'],'naam');
		echo ((check_login() && ($row['score_thuis']==0 && $row['score_uit']==0))?' <small>(<a href="">Score invullen</a>)</small>':'').'<br />';
		echo 'Speeldatum: '.$row['speeldatum'];
		echo '</li>';
		echo '<li class="right '.($colortoggle?'dark':'light').'">'.$row['score_thuis'].'</li><li class="right '.($colortoggle?'dark':'light').'">'.$row['score_uit'].'</li>';
		$colortoggle = !$colortoggle;
	}
?>
</ul>
<?php
}else{
	echo 'Leeg';
}
}else{
	echo 'Geen geldige ID opgegeven.';
}
}else{ echo 'Sorry, deze actie is niet toegestaan!'; }
?>