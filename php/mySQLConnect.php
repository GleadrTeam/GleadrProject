<?php
$host = "localhost";
$username = "root";
$password = "123456";
$db = "softunioverflow";

mysql_connect($host, $username, $password) or die(mysql_error());
mysql_select_db($db);
$connection = mysql_connect($host, $username, $password) or die(mysql_error());
?>