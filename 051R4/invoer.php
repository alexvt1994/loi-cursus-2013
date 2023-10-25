<?php require("config.php");?>
<!DOCTYPE html>
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
			<input type="text" name="naam" value="" /><br />
			<strong>Boodschap:</strong><br />
			<textarea name="boodschap" value=""></textarea><br />
			<br />
			<strong>Kies een sport:</strong><br />
			<select name="sports">
<?php
foreach($array['sports'] as $sport){
	echo '<option value="'.$sport.'">'.ucfirst($sport).'</option>'.PHP_EOL;
}
?>
			</select><br />
			<strong>Beoefenaar:</strong> <input type="radio" name="beoefenaar" value="0" /> nee <input type="radio" name="beoefenaar" value="1" /> ja<br />
			<br />
			<input type="submit" value=" Verzenden " /> <input type="reset" value=" Wissen " />
		</form>
	</body>
</html>