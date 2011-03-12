<?php
if ($_POST)
{
    switch($_POST["formbicimi"])
    {
        case "giris":
            if (!$_POST["giriskullanici"])
                { $hata = "kullanıcı adı girin"; }
            elseif(!$_POST["girisparola"])
                { $hata = "parolanızı girin"; }
            else
            {
                $sorgu = "SELECT id, parola, aktif FROM {$dbOnek}kullanici WHERE kullanici = '$_POST[giriskullanici]'";
                $sonuc = mysql_query($sorgu,$db);

                if( mysql_num_rows($sonuc) == 1 )
                {
                 $bilgi = mysql_fetch_assoc($sonuc);
                    if ($bilgi["parola"] == md5($_POST["girisparola"]))
                    {
                        if ($bilgi["aktif"] == "True")
                        { girisyap($bilgi["id"], $_POST["giriskullanici"]); }
                        else
                        { $hata = "kullanıcı henüz aktifleştirilmemiş"; }
                    }
                    else
                    { $hata = "kullanıcı adı veya şifre hatalı"; }
                }
                else
                { $hata = "kullanıcı kayıtlı değil"; }
            }
            break;
        
        case "kaydol":
            if (!$_POST["isim"]) { $hata = "isim girin"; }
            elseif(!$_POST["soyisim"]) { $hata = "soyisim girin"; }
            elseif(!$_POST["email"]) { $hata = "email girin"; }
            elseif(!$_POST["kullanici"]) { $hata = "kullanıcı adı girin"; }
            elseif(!$_POST["parola"]) { $hata = "parolanızı girin"; }
            elseif(!$_POST["parolatekrar"]) { $hata = "parola tekrarını girin"; }
            elseif($_POST["parola"] != $_POST["parolatekrar"]) { $hata = "parolalar uyuşmuyor"; }
            else
            {
                $sorgu = "SELECT * FROM {$dbOnek}kullanici WHERE kullanici = '$_POST[kullanici]'";
                
                if( mysql_num_rows(mysql_query($sorgu, $db)) != 1 )
                {
                    $aktifKod = md5($_POST["kullanici"], $raw_output = null);
                    $parola = md5($_POST["parola"], $raw_output = null);
                    
                    $sorgu = "INSERT INTO {$dbOnek}kullanici (kullanici, isim, soyisim, posta, parola)
                        VALUES
                        ('$_POST[kullanici]', '$_POST[isim]', '$_POST[soyisim]', '$_POST[email]', '$parola')";
                    mysql_query($sorgu,$db);
                    
                    $posta_metin = aktifPosta($aktifKod);
                            
                    $mail = mail( $_POST["email"], "Subject: Fen bilgisi aktivasyon.",
                                  $posta_metin, "From: $eposta" );
                    if ($mail)
                    {
                        $hata = "Fen Bilgisi sitesine üyeliğinizin tamamlanması için e-posta adresinize gönderilen aktivasyon bağlantısına tıklamanız gerekmektedir.";
                    }
                    else { $hata = "e-posta gönderilemiyor!"; }
                }
                else
                {
                    unset($_POST["kullanici"]);
                    $hata = "kullanıcı zaten kayıtlı farklı bir kullanıcı adı deneyin.";
                }
        
            }
            break;
    }
}
echo   "<div class='sayfa yuvar'>
            <div class='sustresim'>
                <a href='$anasayfa'><img src='fen.png' width='100%' height='150px' alt='' /></a>
            </div>
            
            <div class='sgiris yuvar'>";
                if ($_POST["formbicimi"] == "giris") formgoster("giris", $hata);
                else formgoster("giris");
echo   "    </div>
            
            <div class='sgiris yuvar'>";
                if ($_POST["formbicimi"] == "kaydol") formgoster("kaydol", $hata);
                else formgoster("kaydol");
echo   "    </div>
            <div class='salt'>
                Bu sitenin tüm içeriği CC by-nc-sa ile lisanslanmıştır. <b>Site test aşamasındadır.</b>
            </div>
        </div>";
?> 