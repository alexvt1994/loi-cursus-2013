<?php
if(check_login()){ ?>
Welkom <?php echo db_element('login',myID(),'schermnaam'); ?>,<br />
<br />
<?php if(isUserAuthorized(addBlog)){ ?><a href="./addblog">Blog toevoegen</a><br /><br /><?php } ?>
<a href="./secure/?action=logout">Uitloggen</a>
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
<a href="./register">Registreren</a>
<?php
}
?>