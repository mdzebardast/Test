<?php

$dbserver="localhost";
$dbname="jaajoor";
$dbun="root";
$dbpw="";
//-----------
$link=mysql_pconnect($dbserver,$dbun,$dbpw);// or die("Invalid query: " . mysql_error());
if (!$link)
	{exit;}
mysql_select_db($dbname,$link);// or die("Invalid query: " . mysql_error());
//-----------
mysql_set_charset("utf-8");
mysql_query('SET NAMES UTF8');

?>