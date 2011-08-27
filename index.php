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
                var dosyaSayisi = parseInt($('#dosyaSayisi').val());
                if (dosyaSayisi <= 4)
                {
                    dosyaSayisi += 1
                    $('#dosyalar').append(\"<div><input class='yuvar r5' style='width:75%' type='file' name='dosya[]' id='dosya' /></div>\");
                    $('#dosyaSayisi').val(dosyaSayisi);
                    if (parseInt($('#dosyaSayisi').val()) == 5)
                    {
                        $('#yenidosya').remove();
                    }
                }
            }
        );
    }
);
</script>
<script src='DD_roundies_0.0.2a.js'></script>
<script>
  /* IE only */
  DD_roundies.addRule('.yuvar', '10px');
</script>
<script>
function bilg_gor()
{
    var rad1 = document.getElementById('bilg_rad1');
    var rad2 = document.getElementById('bilg_rad2');
    var check2 = document.getElementById('bilg_check2');
    
    if (document.bildir.bilg_check1.checked == true)
    {
        rad1.style.display='block';
        rad2.style.display='block';
    }
    else
    {
        rad1.style.display='none';
        rad2.style.display='none';
        check2.style.display='none';
    }
    if (document.bildir.bilg_rad2s.checked == true)
    {
        if (document.bildir.bilg_check1.checked == true)
        {
            check2.style.display='block';
        }
    }
    else
    {
        check2.style.display='none';
    }
}
</script>
</head>
<body>";

if ($bakimda)
{
    echo "<h2 style='text-align:center;margin-top:240px;'>Site Bakıma Alınmıştır...<br />Kısa sürede kullanıma açılır</h2>";
}
elseif ($girilmis)
{
    include "temel.php";
}
else
{
    include "giris.php";
}
echo "</body></html>";
?>