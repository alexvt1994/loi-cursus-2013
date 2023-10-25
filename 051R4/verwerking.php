<?php
require("config.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$naam = trim($_POST['naam']);
	$boodschap = trim($_POST['boodschap']);
	$sport = trim($_POST['sports']);
	$beoefenaar = (!empty($beoefenaar))?trim($_POST['beoefenaar']):'';
	if(empty($naam)){
		echo 'U bent vergeten een naam in te vullen!<br />';
		$fout['naam'] = true;
		$terug = true;
	}
	if(empty($boodschap)){
		echo 'U bent vergeten een boodschap in te vullen!<br />';
		$fout['boodschap'] = true;
		$terug = true;
	}
	if(!in_array($_POST['sports'], $array['sports'])){
		echo 'U heeft geen geldige sport ingevuld!<br />';
		$fout['sports'] = true;
		$terug = true;
	}
	if(!isset($_POST['beoefenaar']) OR !is_numeric($_POST['beoefenaar']) AND ($_POST['beoefenaar']!=0) AND ($_POST['beoefenaar']!=1)){
		echo 'Er is een fout opgetreden met het kiezen of u een beoefenaar bent!<br />';
		$terug = true;
	}
	if(isset($terug)){ /* TRUE */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Reageren - Opdracht 051R4</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
	<body>
		<h3>Reageren:</h3>
		<form action="verwerking.php" method="post">
			<strong>Naam:</strong><br />
			<input type="text" name="naam" <?php if(isset($fout['naam'])) { echo 'class="fout"'; } ?> value="<?php if (!empty($naam)) { echo stripslashes($naam); } ?>" /><br />
			<strong>Boodschap:</strong><br />
			<textarea name="boodschap"<?php if(isset($fout['boodschap'])) { echo ' class="fout"'; } ?>><?php if (!empty($boodschap)) { echo stripslashes($boodschap); } ?></textarea><br />
			<br />
			<strong>Kies een sport:</strong>
			<select name="sports">
<?php
foreach($array['sports'] as $value){
	echo '<option value="'.$value.'"'.(($value==$sport)?' selected':'').'>'.ucfirst($value).'</option>'.PHP_EOL;
}
?>
			</select><br />
			<strong>Beoefenaar:</strong> <?php if(empty($beoefenaar)){echo '<label class="fout">(U bent dit ook vergeten aan te kruisen.)</label>';}?><br />
			<input type="radio" name="beoefenaar" value="0"<?php if(!empty($beoefenaar) && $beoefenaar==false){echo ' checked';}?> /> nee
			<input type="radio" name="beoefenaar" value="1"<?php if(!empty($beoefenaar) && $beoefenaar==true){echo ' checked';}?> /> ja<br />
			<br />
			<input type="submit" value=" Verzenden " /> <input type="reset" value=" Wissen " />
		</form>
	</body>
</html>
<?php
	}else { /* FALSE */
		$naam = mysql_real_escape_string($_POST['naam']);
		$boodschap = mysql_real_escape_string($_POST['boodschap']);
		$sports = $_POST['sports'];
		$beoefenaar = $_POST['beoefenaar'];

		$sql = "INSERT INTO `gastenboek` (`naam`,`boodschap`,`datum`,`sport`,`beoefenaar`) VALUES ('".$naam."','".$boodschap."',now(), '".$sports."', '".$beoefenaar."')";
		//als de query succesvol wordt uitgevoerd
		if(mysql_query($sql)){
			header("Location: verwerking.php");
		}else{
			echo 'Er is een fout opgetreden!<br />MySQL Error: '.mysql_error();
		}
	}
}else{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Opdracht 051R4</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style>
		td{ padding:4px 6px; }
		a{ color:#000; }
	</style>
</head>
<body>
	<h3>Gastenboek</h3>
	<a href="invoer.php">Reageren</a><br />
	<br />
<?php
$query = "SELECT * FROM `gastenboek` ORDER BY `id` DESC";
$result = mysql_query($query);
 
if($result){
	$count = mysql_num_rows($result);
}else{
	$count = 0;
}
		
if($count!=0){
	while($row = mysql_fetch_array($result)){
		echo '<table bordercolor="#000" border="1" style="border-style:solid;border-collapse:collapse;">'.PHP_EOL;
		echo '<tr><td width=100><strong>Naam:</strong></td><td width=250>'.stripslashes($row['naam']).'</td></tr>'.PHP_EOL;
		echo '<tr><td><strong>Datum:</strong></td><td>'.date("d-m-Y H:i", strtotime($row['datum'])).'</td></tr>'.PHP_EOL;
		echo '<tr><td><strong>Sport:</strong></td><td>'.$row['sport'].'</td></tr>'.PHP_EOL;
		echo '<tr><td><strong>Beoefenaar:</strong></td><td>'.(($row['beoefenaar']==1)?'ja':'nee').'</td></tr>'.PHP_EOL;
		echo '<tr><td colspan=2>'.stripslashes($row['boodschap']).'</td></tr>'.PHP_EOL;
		echo '</table><br />'.PHP_EOL;
	}
}else{
	echo 'Er is nog geen bericht in het gastenboek geplaatst.<br />'.PHP_EOL;
}
?>
</body>
</html>
<?php
}
?>