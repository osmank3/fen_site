<?php
if ($_POST)
{
    switch($_POST["formbicimi"])
    {
        case "profil":
            if (!$_POST["isim"]) { $hata = "İsim girin!"; }
            elseif(!$_POST["soyisim"]) { $hata = "Soyisim girin!"; }
            elseif(!$_POST["email"]) { $hata = "E-posta adresi girin!"; }
            else
            {
                $sorgu = "UPDATE {$dbOnek}kullanici SET isim = '$_POST[isim]', soyisim = '$_POST[soyisim]',
                                  posta = '$_POST[email]' WHERE id = '$_SESSION[kid]'";
                mysql_query($sorgu,$db);
                echo   "<script>
                            alert('Ayarlarınız kaydedildi.');
                            window.top.location = './?hesap=goster';
                        </script>";
            }
            break;
            
        case "bildir":
            $icerik = "False";
            $yorum = "False";
            $sade = "False";
            if (isset($_POST["bilg_yeni_icerik"])) $icerik = $_POST["bilg_yeni_icerik"];
            if (isset($_POST["bilg_yeni_yorum"]) and $icerik == "True") $yorum = $_POST["bilg_yeni_yorum"];
            if (isset($_POST["bilg_sade_takip"]) and $yorum == "True") $sade = $_POST["bilg_sade_takip"];
            $sorgu = "UPDATE {$dbOnek}kullanici SET bilg_yeni_icerik = '$icerik',
                                    bilg_yeni_yorum = '$yorum', bilg_sade_takip = '$sade'
                                    WHERE id = '$_SESSION[kid]'";
            mysql_query($sorgu,$db);
            echo   "<script>
                        alert('Ayarlarınız kaydedildi.');
                        window.top.location = './?hesap=goster';
                    </script>";
            break;
            
        case "sifre":
            if(!$_POST["eskiparola"]) { $hata = "Eski parola girin!"; }
            elseif(!$_POST["parola"]) { $hata = "Yeni parola girin!"; }
            elseif(!$_POST["parolatekrar"]) { $hata = "Yeni parola tekrarını girin!"; }
            elseif($_POST["parola"] != $_POST["parolatekrar"]) { $hata = "Yeni parolalar uyuşmuyor!"; }
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
                        echo   "<script>
                                    alert('Ayarlarınız kaydedildi.');
                                    window.top.location = './?hesap=goster';
                                </script>";
                    }
                    else { $hata = "Eski parolanızı yanlış girdiniz!"; }
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
            echo   "<h4>Profil Düzenleme</h4>
                    <div class='yuvar r4'>";
            formgoster("profil",$hata,$profil);
            echo   "</div>";
        }
        break;
        
    case "bildir":
        $sorgu = "SELECT * FROM {$dbOnek}kullanici WHERE id='$_SESSION[kid]'";
        $sonuc = mysql_query($sorgu,$db);
        
        if( mysql_num_rows($sonuc) == 1 )
        {
            if (!$hata) $hata = "";
            $profil = mysql_fetch_assoc($sonuc);
            echo   "<h4>Bildirileri Düzenleme</h4>
                    <div class='yuvar r4'>";
            formgoster("bildir",$hata,$profil);
            echo   "</div>";
        }
        break;

    case "sifre":
        if (!$hata) $hata = "";
        echo   "<h4>Şifre Değiştirme</h4>
                <div class='yuvar r4'>";
        formgoster("sifre",$hata);
        echo   "</div>";
        break;
}
?>