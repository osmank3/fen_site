<?php
session_start();
include "ayar.php";
include "kkontrol.php";
include "fonksiyon.php";

echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
<html>
<head>
<title>Fen Bilgisi</title>
<meta name='ROBOTS' content='NOINDEX, NOFOLLOW'>
<meta http-equiv='content-type' content='text/html; charset=UTF-8'>
<meta http-equiv='content-type' content='application/xhtml+xml; charset=UTF-8'>
<meta http-equiv='content-style-type' content='text/css'>
<link href='index.css' rel='stylesheet' type='text/css'>
<script type='text/javascript' src='fonksiyon.js'></script>
<script src='DD_roundies_0.0.2a.js'></script>
<script>
  /* IE only */
  DD_roundies.addRule('.yuvar', '10px');
</script>
</head>
<body>";

if ($BAKIMDA)
{
    echo "<h2 style='text-align:center;margin-top:240px;'>Site Bakıma Alınmıştır...<br />Kısa sürede kullanıma açılır</h2>";
}
elseif ($GIRILMIS)
{
    include "temel.php";
}
else
{
    include "giris.php";
}
echo "</body></html>";
?>