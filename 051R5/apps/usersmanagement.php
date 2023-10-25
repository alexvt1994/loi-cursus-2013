<?php if(check_login()){ ?>
<h2>Gebruikersonderhoud</h2>
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	if(!empty($_POST['delete']))
	{
		$i = 0;
		$ii = 0;
		
		foreach($_POST['delete'] as $id)
		{
			$query = "DELETE FROM `login` WHERE `id`=".addslashes($id)."";
			$resultaat = mysql_query($query);
						
			if($resultaat && (mysql_affected_rows() == 1))
			{
				$i++;
			}else{
				$ii++;
			}
		}
		
		echo '<p>The database is updated, '.$i.' records deleted and '.$ii.' failed</p>';
	}
}
$sql = mysql_query("SELECT * FROM `login` ORDER BY `id` ASC");
$count = mysql_num_rows($sql);
if($count!=0){
?>
<form method="post" action="">
<table bordercolor="#000" border="1">
<tr>
<td></td>
<td><strong>Gebruikersnaam:</strong></td>
<td><strong>Schermnaam:</strong></td>
</tr>
<?php
	while($row = mysql_fetch_array($sql)){
			echo '<tr>'.PHP_EOL;
			echo(($row['id']!=myID())?'<td><input type="checkbox" name="delete[]" value="'.$row['id'].'"></td>':'<td></td>').PHP_EOL;
			echo '<td>'.$row['user'].'</td>';
			echo '<td>'.$row['schermnaam'].'</td>';
			echo '</tr>'.PHP_EOL;
	}
?>
<tr><td>&nbsp;</td><td colspan="1"><input type="submit" value=" Verwijderen "> <input type="reset" value=" Reset "></td></tr>
</table>
</form>
<br />
<?php
}else{
	echo 'Geen gebruikers.';
}
}else{ echo 'Sorry, deze actie is niet toegestaan!'; }
?>