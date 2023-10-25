<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'usbw';
$dbname = 'dbLOI';

mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());

$array['sports'] = array('tennis', 'voetbal', 'running', 'tafeltennis', 'squash', 'wielrennen','boksen');
?>