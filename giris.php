<?php
function formgoster($hata = "")
{
    echo "<table style='width:270px; margin:7em auto;'>
<form method='post'>
<tr><td colspan='2'><p align='center'> $hata </p></td></tr>
<tr><td> Kullanıcı Adı:</td><td><input type='text' name='kullanici' ";
if ($_POST["kullanici"]) echo "value='$_POST[kullanici]'";
echo "/></td></tr>
<tr><td> Parola:</td><td><input type='password' name='parola' /></td></tr>
<tr><td><a href='kaydol.php' >Kaydol</a></td><td align='right'>
<input type='submit' value='Giriş' /></td></tr>
</form>
</table>
";
}
function girisyap($id, $kullanici)
{
    $_SESSION["giris"] = true;
    $_SESSION["kid"] = $id;
    $_SESSION["kullanici"] = $kullanici;
    echo "<script> window.top.location = './'; </script>";
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
if ($_POST)
{
    if (!$_POST["kullanici"])
    { formgoster("kullanıcı adı girin"); }
    elseif(!$_POST["parola"])
    { formgoster("parolanızı girin"); }
    else
    {
        $sorgu = "SELECT id, parola, aktif FROM kullanici WHERE kullanici = '$_POST[kullanici]'";
        $sonuc = mysql_query($sorgu,$db);

        if( mysql_num_rows($sonuc) == 1 )
        {
            $bilgi = mysql_fetch_assoc($sonuc);
            if ($bilgi["parola"] == md5($_POST["parola"]))
            {
                if ($bilgi["aktif"] == "True")
                { girisyap($bilgi["id"], $_POST["kullanici"]); }
                else
                { formgoster("kullanıcı henüz aktifleştirilmemiş"); }
            }
            else
            { formgoster("kullanıcı adı veya şifre hatalı"); }
        }
        else
        { formgoster("kullanıcı kayıtlı değil"); }
    }
}
else
{ formgoster(); }
echo "</body></html>";
?> 