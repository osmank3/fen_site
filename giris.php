<?php
if ($_POST)
{
    switch($_POST["formbicimi"])
    {
        case "giris":
            if (!$_POST["giriskullanici"])
                { $hata = "Kullanıcı adı girin!"; }
            elseif(!$_POST["girisparola"])
                { $hata = "Parola girin!"; }
            else
            {
                $sorgu = "SELECT id, parola, aktif FROM {$DBONEK}kullanici WHERE kullanici = '$_POST[giriskullanici]'";
                $sonuc = mysql_query($sorgu,$DB);

                if( mysql_num_rows($sonuc) == 1 )
                {
                    $bilgi = mysql_fetch_assoc($sonuc);
                    if ($bilgi["parola"] == md5($_POST["girisparola"]))
                    {
                        if ($bilgi["aktif"] == "True")
                        { girisyap($bilgi["id"], $_POST["giriskullanici"]); }
                        else
                        { $hata = "Kullanıcı henüz aktifleştirilmemiş!"; }
                    }
                    else
                    { $hata = "Kullanıcı adı veya şifre hatalı!"; }
                }
                else
                { $hata = "Kullanıcı kayıtlı değil!"; }
            }
            break;
        
        case "kaydol":
            if (!$_POST["isim"]) { $hata = "İsim girin!"; }
            elseif(!$_POST["soyisim"]) { $hata = "Soyisim girin!"; }
            elseif(!$_POST["email"]) { $hata = "E-posta adresi girin!"; }
            elseif(!$_POST["kullanici"]) { $hata = "Kullanıcı adı girin!"; }
            elseif(!$_POST["parola"]) { $hata = "Parola girin!"; }
            elseif(!$_POST["parolatekrar"]) { $hata = "Parola tekrarını girin"; }
            elseif($_POST["parola"] != $_POST["parolatekrar"]) { $hata = "Parolalar uyuşmuyor"; }
            else
            {
                $sorgu = "SELECT * FROM {$DBONEK}kullanici WHERE kullanici = '$_POST[kullanici]'";
                
                if( mysql_num_rows(mysql_query($sorgu, $DB)) != 1 )
                {
                    $aktifKod = md5($_POST["kullanici"], $raw_output = null);
                    $parola = md5($_POST["parola"], $raw_output = null);
                    
                    $sorgu = "INSERT INTO {$DBONEK}kullanici (kullanici, isim, soyisim, posta, parola)
                        VALUES
                        ('$_POST[kullanici]', '$_POST[isim]', '$_POST[soyisim]', '$_POST[email]', '$parola')";
                    mysql_query($sorgu,$DB);
                    
                    $posta_metin = aktifPosta($aktifKod);
                    
                    $mail = mail( $_POST["email"], "$siteAdi aktivasyon",
                                  $posta_metin, $epostaBaslik );
                    if ($mail)
                    {
                        $hata = "$siteAdi sitesine üyeliğinizin tamamlanması için e-posta adresinize gönderilen aktivasyon bağlantısına tıklamanız gerekmektedir.";
                    }
                    else { $hata = "E-posta gönderilemiyor!"; }
                }
                else
                {
                    unset($_POST["kullanici"]);
                    $hata = "Kullanıcı adı zaten kayıtlı farklı bir kullanıcı adı deneyin.";
                }
        
            }
            break;
            
        case "kayip":
            if (!$_POST["kayipkullanici"])
                { $hata = "Kullanıcı adı girin!"; }
            else
            {
                $sorgu = "SELECT * FROM {$DBONEK}kullanici WHERE kullanici = '$_POST[kayipkullanici]'";
                $sonuc = mysql_query($sorgu,$DB);
                
                if( mysql_num_rows($sonuc) == 1 )
                {
                    $bilgi = mysql_fetch_assoc($sonuc);
                    $kayipKod = md5($bilgi["kullanici"] . $bilgi["parola"], $raw_output = null);
                    
                    $posta_metin = kayipPosta($kayipKod);
                    
                    $mail = mail( $bilgi["posta"], "$siteAdi şifre sıfılama",
                                  $posta_metin, $epostaBaslik );
                    if ($mail)
                    {
                        $hata = "E-posta adresinize şifre sıfırlama bağlantısı gönderilmiştir.";
                    }
                    else { $hata = "E-posta gönderilemiyor!"; }
                }
                else { $hata = "Kullanıcı adı kayıtlı değil!"; }
            }
            break;
            
        case "kayipsifre":
            if(!$_POST["parola"]) { $hata = "Yeni parola girin!"; }
            elseif(!$_POST["parolatekrar"]) { $hata = "Parola tekrarını girin!"; }
            elseif($_POST["parola"] != $_POST["parolatekrar"]) { $hata = "Parolalar uyuşmuyor!"; }
            else
            {
                $yeniParola = md5($_POST["parola"]);
                $sorgu = "UPDATE {$DBONEK}kullanici SET parola = '$yeniParola' WHERE id = '$_POST[kullaniciId]'";
                mysql_query($sorgu,$DB);
                
                echo   "<script> alert('Parolanız değiştirildi.'); </script>";

                $sorgu = "SELECT * FROM {$DBONEK}kullanici WHERE id = '$_POST[kullaniciId]'";
                $sonuc = mysql_query($sorgu,$DB);

                $bilgi = mysql_fetch_assoc($sonuc);
                
                girisyap($bilgi["id"], $bilgi["kullanici"]);
            }
            break;
    }
}

echo   "<div class='sayfa yuvar'>
            <div class='sustresim'>
                <a href='$anasayfa'><img src='fen.png' width='100%' height='150px' border='0' alt='' /></a>
            </div>";

if($_GET["kod"])
{
    if ($_GET["hesap"] == "aktif")
    {
        $sorgu = "SELECT kullanici FROM {$DBONEK}kullanici";
        $sonuc = mysql_query($sorgu,$DB);
        while ($satir = mysql_fetch_array($sonuc))
        {
            if($_GET["kod"] == md5($satir["kullanici"], $raw_output = null))
            {
                $sorgu = "UPDATE {$DBONEK}kullanici SET aktif='True'
                    WHERE kullanici = '$satir[kullanici]'";
                mysql_query($sorgu,$DB);
                echo "<script> 
                          alert('Hesabınız aktifleştirildi.');
                          window.top.location = './';
                      </script>";
                break;
            }
        }
    }
    elseif ($_GET["hesap"] == "kayip")
    {
        $sorgu = "SELECT * FROM {$DBONEK}kullanici";
        $sonuc = mysql_query($sorgu,$DB);
        $durum = TRUE;
        while ($profil = mysql_fetch_array($sonuc))
        {
            $kodnormal = $profil["kullanici"] . $profil["parola"];
            if($_GET["kod"] == md5($kodnormal, $raw_output = null))
            {
                
                echo   "    <div class='sgiris yuvar'>";
                
                formgoster("kayipsifre", $hata, $profil);
                
                echo   "    </div>";

                $durum = FALSE;
                break;
            }
        }
        if ($durum) echo "<h2>Kontrol kodu hatalı. Bağlantıyı kontrol edin.</h2>";
    }
}
else
{
    echo   "    <div class='sgiris yuvar'>";
                    if ($_POST["formbicimi"] == "giris") formgoster("giris", $hata);
                    else formgoster("giris");
    echo   "    </div>
                
                <div class='sgiris yuvar'>";
                    if ($_POST["formbicimi"] == "kaydol") formgoster("kaydol", $hata);
                    else formgoster("kaydol");
    echo   "    </div>
                
                <div class='sgiris yuvar'>";
                    if ($_POST["formbicimi"] == "kayip") formgoster("kayip", $hata);
                    else formgoster("kayip");
    echo   "    </div>";
}

echo   "    <div class='salt'>
                Bu sitenin tüm içeriği CC by-nc-sa ile lisanslanmıştır. <strong>Site test aşamasındadır.</strong>
            </div>
        </div>";
?> 
