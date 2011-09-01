<?php
include "mysql_ayar.php";

//veritabanına bağlan
$DB = mysql_connect(DBSUNUCU, DBKULLANICI, DBPAROLA) or die("HATA : " . mysql_error());

//veritabanı tablosu seç
mysql_select_db(DBTABLO, $DB) or die("HATA : " . mysql_error());

//veritabanı dil kodlaması seç
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION = 'utf8_general_ci'");
?>