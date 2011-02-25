<?php
include "ayar.php";
include "mysql.php";

function formgoster($hata = "") { echo '
<table style="width:270px; margin:7em auto;">
<tr><td colspan="2" ><p align="center">' . $hata . '</p></td></tr>
<form method="post">
<tr><td> İsim:</td><td><input type="text" name="isim" ';
if ($_POST["isim"]) echo "value='$_POST[isim]'";
echo '/></td></tr>
<tr><td> Soyisim:</td><td><input type="text" name="soyisim" ';
if ($_POST["soyisim"]) echo "value='$_POST[soyisim]'";
echo '/></td></tr>
<tr><td> E-posta:</td><td><input type="text" name="email" ';
if ($_POST["email"]) echo "value='$_POST[email]'";
echo '/></td></tr>
<tr><td><br /></td><td></td></tr>
<tr><td> Kullanıcı Adı:</td><td><input type="text" name="kullanici" ';
if ($_POST["kullanici"]) echo "value='$_POST[kullanici]'";
echo '/></td></tr>
<tr><td> Parola:</td><td><input type="password" name="parola" /></td></tr>
<tr><td> Parola(tekrar):</td><td><input type="password" name="parolatekrar" /></td></tr>
<tr><td></td><td align="right"><input type="submit" value="Kaydol" /></td></tr>
</form>
</table>';
}
function postaMetin($kod) {
    global $anasayfa;
$metin = "Fen Bilgisi sitesine üyeliğinizin gerçekleşmesi için aşağıdaki bağlantıya tıklayın

{$anasayfa}kaydol.php?kod=$kod

Bağlantıya tıklanamıyorsa tarayıcınızın adres çubuğuna yapıştırınız." ;
return $metin;
}

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Fen Bilgisi</title>
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8">
<meta http-equiv="content-style-type" content="text/css">
</head>
<body>';

if($_GET)
{
    if($_GET["kod"])
    {
        $sorgu = "SELECT kullanici FROM kullanici";
        $sonuc = mysql_query($sorgu,$db);
        while ($satir = mysql_fetch_array($sonuc))
        {
            if($_GET["kod"] == md5($satir["kullanici"], $raw_output = null))
            {
                $sorgu = "UPDATE kullanici SET aktif='True'
                    WHERE kullanici = '$satir[kullanici]'";
                mysql_query($sorgu,$db);
                echo "<script> window.top.location = './'; </script>";
            }
        }
    }
}
elseif ($_POST)
{
    if (!$_POST["isim"]) {formgoster("isim girin");}
    elseif(!$_POST["soyisim"]) {formgoster("soyisim girin");}
    elseif(!$_POST["email"]) {formgoster("email girin");}
    elseif(!$_POST["kullanici"]) {formgoster("kullanıcı adı girin");}
    elseif(!$_POST["parola"]) {formgoster("parolanızı girin");}
    elseif(!$_POST["parolatekrar"]) {formgoster("parola tekrarını girin");}
    elseif($_POST["parola"] != $_POST["parolatekrar"]) {formgoster("parolalar uyuşmuyor");}
    else
    {
        $sorgu = "SELECT * FROM kullanici WHERE kullanici = '$_POST[kullanici]'";
        
        if( mysql_num_rows(mysql_query($sorgu, $db)) != 1 )
        {
            $aktifKod = md5($_POST["kullanici"], $raw_output = null);
            //echo $aktifKod;
            $parola = md5($_POST["parola"], $raw_output = null);
            
            $sorgu = "INSERT INTO kullanici(kullanici, isim, soyisim, posta, parola)
                VALUES
                ('$_POST[kullanici]', '$_POST[isim]', '$_POST[soyisim]', '$_POST[email]', '$parola')";
            mysql_query($sorgu,$db);
            
            $posta_metin = postaMetin($aktifKod);
                    
            $mail = mail( $_POST["email"], "Subject: Fen bilgisi aktivasyon.",
            $posta_metin, "From: $eposta" );
            if ($mail)
            {
                echo "Fen Bilgisi sitesine üyeliğinizin tamamlanması için e-posta adresinize gönderilen aktivasyon bağlantısına tıklamanız gerekmektedir.";
                echo "<br /><a href='./'>Ana sayfa</a>";
            }
            else { echo "mail gönderilemiyi!"; }
        }
        else
        {
            unset($_POST["kullanici"]);
            formgoster("kullanıcı zaten kayıtlı farklı bir kullanıcı adı deneyin.");
        }

    }
}
else
{ formgoster(); }
echo "</body></html>";
?> 