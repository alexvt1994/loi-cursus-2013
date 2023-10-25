<?php 
session_start(); 
require_once('db.inc.php');
require_once('check.func.php');
if(check_login() != false) {
	if(($_SESSION['logged_in']==TRUE) && (is_numeric($_SESSION['logged_id']))){
		unset($_SESSION['logged_in']);
		unset($_SESSION['logged_id']);
		header('Location: ../');
	}
}else{ echo "<p>Je kunt niet uitloggen wanneer je niet bent ingelogd.</p><p>Log in door in bovenstaande velden je 'username' en 'password' in te vullen.</p>"; }
?>