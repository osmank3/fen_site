<?php
$dbSunucu = "localhost";
$dbKullanici = "fen";
$dbParola = "123321";
$dbTablo = "fen";

$db = mysql_connect($dbSunucu, $dbKullanici, $dbParola) or die("HATA : " . mysql_error());

mysql_select_db($dbTablo, $db) or die("HATA : " . mysql_error());
?>