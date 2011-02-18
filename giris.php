<?php
function formgoster($hata = "")
{
    echo "<table style='width:270px; margin:7em auto;'>
<form method='post'>
<tr><td colspan='2'><p align='center'> $hata </p></td></tr>
<tr><td> Kullanıcı Adı:</td><td><input type='text' name='kullanici' /></td></tr>
<tr><td> Parola:</td><td><input type='password' name='parola' /></td></tr>
<tr><td><a href='kaydol.php' >Kaydol</a></td><td align='right'>
<input type='submit' value='Giriş' /></td></tr>
</form>
</table>
";
}
function girisyap($kullanici)
{
    $_SESSION["giris"] = true;
    $_SESSION["kullanici"] = $kullanici;
    echo "<script> window.top.location = './'; </script>";
}
if ($_POST)
{
    if (!$_POST["kullanici"])
    { formgoster("kullanıcı adı girin"); }
    elseif(!$_POST["parola"])
    { formgoster("parolanızı girin"); }
    else
    {
        $sorgu = "SELECT parola FROM kullanici Where kullanici = '$_POST[kullanici]'";
        $sonuc = mysql_query($sorgu,$db);
        
        while($satir = mysql_fetch_array($sonuc))
        {
            if ($satir["parola"] == md5($_POST["parola"]))
            { girisyap($_POST["kullanici"]); }
            else
            { formgoster("kullanıcı adı veya şifre hatalı"); }
        }
    }
}
else
{ formgoster(); }
?> 