<?php
	session_start();
	require_once('config.inc.php');
	require_once('secure/check.func.php');
	require_once('secure/secure.inc.php');
	require_once('secure/class.templateparser.php');
	define('_TPL', 1);
	$tp=new templateParser('modules/template.tpl');
	$tp->set('title','Inzendopdracht 051R7');
	$tp->set('footer','Copyright &copy; '.date("Y").' <a href="http://lexoft.nl" target="_blank">Alex van Turenhout</a>. Alle rechten voorbehouden.');
	$tags=array(
		'left'				=> 'modules/left.php',
		'right'				=> 'modules/right.php',
		'login'				=> 'modules/login.php',
		'component'			=> 'modules/component.php',
	);
	$tp->parseBlocks($tags);
	echo $tp->parse();
?>  