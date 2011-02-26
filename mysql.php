<?php
include "ayar.php";

//veritabanına bağlan
$db = mysql_connect($dbSunucu, $dbKullanici, $dbParola) or die("HATA : " . mysql_error());

//veritabanı tablosu seç
mysql_select_db($dbTablo, $db) or die("HATA : " . mysql_error());

//veritabanı dil kodlaması seç
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION = 'utf8_general_ci'");
?>