<?php 
session_start();
require_once('../config.inc.php');
require_once('check.func.php');
if(!check_login()){
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$username = htmlentities($_POST['user']);
		$password = md5($_POST['pass']);
		$sql = "SELECT * FROM `login` WHERE `user`='".$username."'";
		$res = mysql_query($sql) or die(mysql_error());
		if(mysql_num_rows($res)==1){
			$row = mysql_fetch_assoc($res);
			if($row['pass']==$password){
				$logged_id=$row['id'];
				$_SESSION['logged_id']=$logged_id;
				$_SESSION['logged_in']=TRUE;
				header('Location: ../');
			}else{ echo 'De combinatie van gebruikersnaam en wachtwoord bestaat niet in de database'; }
		}else{ echo 'De combinatie van gebruikersnaam en wachtwoord bestaat niet in de database'; }
	}else{ header('Location: login/'); }
}elseif(isset($_GET['action']) && $_GET['action']=="logout"){
	if(check_login()){
		if(($_SESSION['logged_in']==TRUE) && (is_numeric($_SESSION['logged_id']))){
			unset($_SESSION['logged_in']);
			unset($_SESSION['logged_id']);
			header('Location: ../');
		}
	}else{ echo "<p>Je kunt niet uitloggen wanneer je niet bent ingelogd.</p><p>Log in door in bovenstaande velden je 'username' en 'password' in te vullen.</p>"; }
}else{ header('Location: ../'); }
?>