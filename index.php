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
<script type='text/javascript' src='jquery-1.3.2.min.js'></script>
<script>
$(document).ready(function()
    {
        $('#yenidosya').click(function ()
            {
                var sinir = parseInt($('#sinir').val());
                if (sinir <= 4)
                {
                    sinir += 1
                    $('#dosyalar').append(\"<div><input class='yuvar r5' style='width:75%' type='file' name='dosya[]' id='dosya' /></div>\");
                    $('#sinir').val(sinir);
                    if (parseInt($('#sinir').val()) == 5)
                    {
                        $('#yenidosya').remove();
                    }
                }
            }
        );
    }
);
</script>
</head>
<body>";

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