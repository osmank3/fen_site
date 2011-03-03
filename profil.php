<?php
if ($_POST)
{
    switch($_POST["formbicimi"])
    {
        case "profil":
            if (!$_POST["isim"]) { $hata = "isim girin"; }
            elseif(!$_POST["soyisim"]) { $hata = "soyisim girin"; }
            elseif(!$_POST["email"]) { $hata = "email girin"; }
            else
            {
                $sorgu = "UPDATE {$dbOnek}kullanici SET isim = '$_POST[isim]', soyisim = '$_POST[soyisim]',
                                  posta = '$_POST[email]' WHERE id = '$_SESSION[kid]'";
                mysql_query($sorgu,$db);
                echo "<script> alert('Profiliniz değiştirildi.');</script>";
            }
            break;
        case "sifre":
            if(!$_POST["eskiparola"]) { $hata = "eski parolanızı girin"; }
            elseif(!$_POST["parola"]) { $hata = "yeni parolanızı girin"; }
            elseif(!$_POST["parolatekrar"]) { $hata = "yeni parola tekrarını girin"; }
            elseif($_POST["parola"] != $_POST["parolatekrar"]) { $hata = "yeni parolalar uyuşmuyor"; }
            else
            {
                $sorgu = "SELECT parola FROM {$dbOnek}kullanici WHERE id = '$_SESSION[kid]'";
                $sonuc = mysql_query($sorgu,$db);

                if( mysql_num_rows($sonuc) == 1 )
                {
                    $bilgi = mysql_fetch_assoc($sonuc);
                    if ($bilgi["parola"] == md5($_POST["eskiparola"]))
                    {
                        $yeniParola = md5($_POST["parola"]);
                        $sorgu = "UPDATE {$dbOnek}kullanici SET parola = '$yeniParola' WHERE id = '$_SESSION[kid]'";
                        mysql_query($sorgu,$db);
                        echo "<script> alert('Parolanız değiştirildi.');</script>";
                    }
                    else { $hata = "eski parolanızı yanlış girdiniz"; }
                }
            }
            break;
    }
}
switch ($bicim)
{
    case "profil":
        $sorgu = "SELECT * FROM {$dbOnek}kullanici WHERE id='$_SESSION[kid]'";
        $sonuc = mysql_query($sorgu,$db);
        
        if( mysql_num_rows($sonuc) == 1 )
        {
            if (!$hata) $hata = "";
            $profil = mysql_fetch_assoc($sonuc);
            formgoster("profil",$hata,$profil);
        }
        break;
    case "sifre":
        if (!$hata) $hata = "";
        formgoster("sifre",$hata);
        break;
}
?>