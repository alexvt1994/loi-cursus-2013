<?php
$dbhost = 'localhost'; // Je MySQL hostname
$dbname = 'dbloi';    // Je MySQL database
$dbuser = 'root';    // Je MySQL username
$dbpass = 'usbw';   // Je MySQL password

mysql_connect($dbhost, $dbuser, $dbpass)or die(mysql_error());
mysql_select_db($dbname)or die(mysql_error());
?>