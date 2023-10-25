<h3>Lijst gebruikers:</h2>
<?php
$sql = mysql_query("SELECT * FROM `login` WHERE `rank` = '1' ORDER BY `id` DESC");
if(mysql_num_rows($sql) != 0){
	while($res = mysql_fetch_assoc($sql)){
		echo '<a href="./showblogs&userid='.$res['id'].'">'.$res['schermnaam'].'</a><br />';
	}
}else{ echo 'Er zijn nog geen gebruikers aangemeld. :(';}
?>