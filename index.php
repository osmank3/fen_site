<?php
session_start();
include "mysql.php";
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
</head>
<body>";
if ($_GET["hesap"] == "aktif")
{
    if($_GET["kod"])
    {
        $sorgu = "SELECT kullanici FROM {$dbOnek}kullanici";
        echo $sorgu;
        $sonuc = mysql_query($sorgu,$db);
        while ($satir = mysql_fetch_array($sonuc))
        {
            if($_GET["kod"] == md5($satir["kullanici"], $raw_output = null))
            {
                $sorgu = "UPDATE {$dbOnek}kullanici SET aktif='True'
                    WHERE kullanici = '$satir[kullanici]'";
                mysql_query($sorgu,$db);
                echo "<script> 
                          alert('Hesabınız aktifleştirildi.');
                          window.top.location = './';
                      </script>";
            }
        }
    }
}

if ($girilmis)
{
    include "temel.php";
}
else
{
    include "giris.php";
}
echo "</body></html>";
?>