<?php
if(isset($_GET['p'])){
	$page = $_GET['p'];
	$file = 'apps/'.$page.'.php';
	if(file_exists($file)){
		include($file);
	}else{
		echo 'Sorry, deze actie is niet toegestaan!';
	}
}else{
	include('apps/home.php');
}
?>