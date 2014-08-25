<?php
$host = "localhost";
$username = "root";
$password = "123456";
$db = "softunioverflow";

mysql_connect($host, $username, $password) or die(mysql_error());
mysql_select_db($db);
$connection = mysql_connect($host, $username, $password) or die(mysql_error());

$core_path = dirname(__FILE__);
include_once("{$core_path}/Includes/functions.php");
include_once("{$core_path}/Includes/form_functions.php");
?>