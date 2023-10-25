<?php
if(check_login()){ ?>
Welkom <?php echo db_element('login',myID(),'schermnaam'); ?>,<br />
<br />
<a href="./newpoule">Nieuwe wedstrijd toevoegen</a><br />
<a href="./newteam">Nieuwe team toevoegen</a><br />
<a href="./newuser">Nieuwe gebruiker toevoegen</a><br />
<a href="./usersmanagement">Gebruikersonderhoud</a><br />
<br />
<a href="./secure/logout.php">Uitloggen</a>
<?php
}else{
?>
<strong>Inloggen</strong><br />
Inloggen kan alleen als u daar bevoegd toe bent!<br />
<form action="./secure/" method="post">
    <ul>
	<li>
		Gebruikersnaam:<br />
		Wachtwoord:
	</li>
	<li>
		<input type="text" name="user" value="" /><br />
		<input type="password" name="pass" value="" />
	</li>
	<li>
		<input type="submit" value="Login" />
	</li>
    </ul>
</form>
<?php
}
?>