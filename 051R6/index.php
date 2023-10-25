<?php
	session_start();
	require_once('secure/config.inc.php');
	require_once('secure/check.func.php');
	require_once('secure/class.templateparser.php');
	define('_TPL', 1);
	$tp=new templateParser('modules/template.tpl');
	$tp->set('title','Inzendopdracht 051R6');
	$tp->set('footer','Copyright &copy; '.date("Y").' <a href="http://lexoft.nl" target="_blank">Alex van Turenhout</a>. Alle rechten voorbehouden');
	$tags=array('component'			=> 'modules/component.php',
	);
	$tp->parseBlocks($tags);
	echo $tp->parse();

?>  