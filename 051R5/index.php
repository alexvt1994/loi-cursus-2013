<?php
	session_start();
	require_once('secure/db.inc.php');
	require_once('secure/check.func.php');
	require_once('secure/class.templateparser.php');
	define('_TPL', 1);
	$tp=new templateParser('modules/template.tpl');
	$tp->set('title','Voetbalcompetitie 2013');
	$tp->set('footer','Copyright &copy; '.date("Y").' <a href="http://lexoft.nl" target="_blank">Alex van Turenhout</a>. Alle rechten voorbehouden');
	$tags=array('login'			=> 'modules/login.php',
		    'component'			=> 'modules/component.php',
	);
	$tp->parseBlocks($tags);
	echo $tp->parse();

?>  