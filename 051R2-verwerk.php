<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Inzendopdracht 051R2</title>
</head>
<body>
<?php
echo "Welkom ".ucfirst(strtolower($_POST['voornaam']))." ".strtolower($_POST['tussenvoegsel'])." ".ucfirst(strtolower($_POST['achternaam']))." uit ".strtoupper($_POST['woonplaats'])."<br />";
?>
</body>
</html>