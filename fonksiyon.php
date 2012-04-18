<?php
$epostaBaslik = "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: {$AYAR["Site Adı"]} <{$AYAR["Site E-Posta"]}>\r\n";

function girisyap($id)
{
    $_SESSION["giris"] = true;
    $_SESSION["kid"] = $id;
    if ($_GET["kod"] or $_GET["hesap"] == "cikis") echo "<script> window.top.location = './'; </script>";
    else echo "<script> window.top.location = '$_SERVER[HTTP_REFERER]'; </script>";
}

function aktifPosta($kod)
{
    global $AYAR;
    
    $metin =   "{$AYAR["Site Adı"]} sitesine üyeliğinizin gerçekleşmesi için aşağıdaki bağlantıya tıklayın
                \r<br />
                \r<br />
                \r<a href='{$AYAR["Anasayfa"]}?hesap=aktif&kod=$kod'>{$AYAR["Anasayfa"]}?hesap=aktif&kod=$kod</a>
                \r<br />
                \r<br />
                \rBağlantıya tıklanamıyorsa tarayıcınızın adres çubuğuna yapıştırınız." ;

    return $metin;
}

function kayipPosta($kod)
{
    global $AYAR;
    
    $metin =   "{$AYAR["Site Adı"]} sitesinde şifrenizi değiştirebilmeniz için oluşturulan bağlantı aşağıdadır
                \r<br />
                \r<br />
                \r<a href='{$AYAR["Anasayfa"]}?hesap=kayip&kod=$kod'>{$AYAR["Anasayfa"]}?hesap=kayip&kod=$kod</a>
                \r<br />
                \r<br />
                \rBağlantıya tıklanamıyorsa tarayıcınızın adres çubuğuna yapıştırınız.";
    
    return $metin;
}

function altsatir($yazi)
{
    $yazi = str_replace("\n","<br />",$yazi);
    return $yazi;
}

function dosyaAdiDuzelt($yazi)
{
    $orj = array("\\", "/", ":", ";", "~", "|", "(", ")", "\"", "#", "*", "$", "@", "%", "[", "]", "{", "}", "<", ">", "`", "'", ",", " ", "Â", "â", "ç", "Ç", "ğ", "Ğ", "ı", "İ", "î", "Î", "ö", "Ö", "ş", "Ş", "ü", "Ü");
    $yeni = array("_", "_", "_", "_", "_", "_", "",  "",  "_",  "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "_", "",  "_", "_", "A", "a", "c", "C", "g", "G", "i", "I", "i", "I", "o", "O", "s", "S", "u", "U");
    $yazi = str_replace($orj, $yeni, $yazi);
    
    return $yazi;
}

function kategoriUzun($kategori)
{
    global $DB;
    global $DBONEK;
    
    $sorgu = "SELECT isim FROM {$DBONEK}kategori WHERE id = '$kategori'";
    $sonuc = mysql_query($sorgu, $DB);
    if( mysql_num_rows($sonuc) == 1 )
    {
        $bilgi = mysql_fetch_assoc($sonuc);
        return $bilgi["isim"];
    }
    else { return ""; }
}

function kisiadi($id)
{
    //kişi adlarını "isim soyisim" şeklinde dönen fonksiyon
    global $DB;
    global $DBONEK;
    
    $sorgu = "SELECT isim FROM {$DBONEK}kullanici WHERE id = '$id'";
    $kisi = mysql_query($sorgu,$DB);
    if( mysql_num_rows($kisi) == 1 )
    {
        $bilgi = mysql_fetch_assoc($kisi);
        return $bilgi["isim"];
    }
    else { return ""; }
}

function takipciListe($id)
{
    //içeriği takip edenlerin listesini dönen fonksiyon.
    global $DB;
    global $DBONEK;
    
    $takipciler = array();
    
    $sorgu = "SELECT k_id FROM {$DBONEK}takip WHERE i_id='{$id}' and takip='True'";
    $sonuc = mysql_query($sorgu, $DB);
    
    while ( $bilgi = mysql_fetch_assoc($sonuc))
    {
        if (!in_array($bilgi["k_id"], $takipciler)) $takipciler[] = $bilgi["k_id"];
    }
    
    return $takipciler;
}

function formgoster($formbicimi, $hata = "", $ekicerik = NULL)
{
    /* veri gönderme için kullanılacak formları göstermek için fonksiyon
     *
     * form biçimi girilmek zorunda, hata girilmesi isteğe bağlı */
    global $DB;
    global $DBONEK;
    switch($formbicimi)
    {
        case "giris": //giriş bölümü için form
            echo   "<h4>Giriş</h4>
                    <p>$hata</p>
                    <form method='post'>
                        E-posta:<input type='text' name='giriskullanici' tabindex='1' ";
                            if ($_POST["giriskullanici"]) echo "value='$_POST[giriskullanici]'";
            echo   "        />
                        Parola:<input type='password' name='girisparola' tabindex='2' />
                        <input type='hidden' name='formbicimi' value='giris' />
                        <input type='submit' value='Giriş' tabindex='3' />
                    </form>";
            break;
        
        case "icerik":
            echo   "<div class='icerik yuvar r4'>
                    Aşağıdaki büyük beyaz alanın doldurulması <strong>zorunludur</strong>...<br />İlk 60 karakter başlık olarak alınacaktır.
                    <form method='post' action='' enctype='multipart/form-data'>
                        <div class='ibolum'><textarea class='yuvar rbk' style='width:99%;height:7em;' name='yazi' aria-required='true'></textarea></div>
                        <input type='hidden' name='MAX_FILE_SIZE' value='20000000' />
                        <input type='hidden' id='dosyaSayisi' value='1' />
                        <div class='ibolum' id='dosyalar'>
                            <button class='yuvar r5 sag' id='yenidosya' type='button' onClick='dosyaekle()'>Başka Dosyalar Ekle</button>
                            <input class='yuvar r5' style='width:75%' type='file' name='dosya[]' />
                        </div>
                        <div class='ibolum'>
                            Kategori:
                            <select name='kategori' class='yuvar r5'>
                                <option value='diger'>Kategori Seçin</option>";
                                
                                $sorgu = "SELECT * FROM {$DBONEK}kategori WHERE us_id IS NULL ORDER BY id DESC";
                                $sonuc = mysql_query($sorgu, $DB);
                                while($bilgi = mysql_fetch_assoc($sonuc))
                                {
                                    if ($bilgi["ustkategori"] == "False") echo "<option value='$bilgi[id]'>$bilgi[isim]</option>";
                                    else
                                    {
                                        echo "<optgroup label='{$bilgi[isim]}'>";
                                        $ic_sorgu = "SELECT * FROM {$DBONEK}kategori WHERE us_id = '{$bilgi[id]}' ORDER BY id";
                                        $ic_sonuc = mysql_query($ic_sorgu, $DB);
                                        while($ic_bilgi = mysql_fetch_assoc($ic_sonuc))
                                        {
                                            echo "<option value='$ic_bilgi[id]'>$ic_bilgi[isim]</option>";
                                        }
                                        echo "</optgroup>";
                                    }
                                }
                                
            echo   "        </select>
                            <input type='hidden' name='formbicimi' value='icerik' />
                            <input class='yuvar sag r5' type='submit' value='Gönder' />
                        </div>
                    </form>
                    </div>
                    ";
            break;
        
        case "kaydol": //kaydolmak için form
            echo   "<h4>Kaydol</h4>
                    <p>$hata</p>
                    <table align='center'>
                    <form method='post'>
                        <tr>
                            <td>İsim:</td>
                            <td><input type='text' name='isim' tabindex='4' ";
                                if ($_POST["isim"]) echo "value='$_POST[isim]' ";
            echo   "            /></td>
                            <td>Parola:</td>
                            <td><input type='password' name='parola' tabindex='8' /></td>
                        </tr>
                        <tr>
                            <td>E-posta:</td>
                            <td><input type='text' name='email' tabindex='6' ";
                                if ($_POST["email"]) echo "value='$_POST[email]' ";
            echo   "            /></td>
                            <td>Parola(tekrar):</td>
                            <td><input type='password' name='parolatekrar' tabindex='9' /></td>
                        </tr>
                        <tr>
                            <td colspan='4' align='right'>
                                <input type='hidden' name='formbicimi' value='kaydol' />
                                <input type='submit' value='Kaydol' tabindex='10' /></td>
                        </tr>
                    </form>
                    </table>";
            break;
            
        case "kayip": //kayıp parola talebi
            echo   "<h4>Kayıp Parola</h4>
                    <p>$hata</p>
                    <form method='post'>
                        E-posta:<input type='text' name='kayipkullanici' tabindex='11' ";
                            if ($_POST["kayipkullanici"]) echo "value='$_POST[kayipkullanici]'";
            echo   "        />
                        <input type='hidden' name='formbicimi' value='kayip' />
                        <input type='submit' value='Parola gönder' tabindex='12' />
                    </form>";
            break;
            
        case "profil": //profil düzenlemek için
            echo "<table>
                  <form method='post'>
                      <tr><td colspan='2'><p align='center'>$hata</p></td></tr>
                      <tr><td>İsim:</td><td><input type='text' name='isim' value='$ekicerik[isim]' /></td></tr>
                      <tr><td> E-posta:</td><td><input type='text' name='email' value='$ekicerik[posta]' /></td></tr>
                      <tr><td></td><td align='right'>
                          <input type='hidden' name='formbicimi' value='profil' />
                          <input class='yuvar r5' type='submit' value='Kaydet' />
                      </td></tr>
                  </form>
                  </table>";
            break;
            
        case "bildir": //bilgilendirme ayarlarını düzenlemek için
            echo   "<p>$hata</p>
                    <form method='post' name='bildir'>
                    <ul class='kat' style='list-style-type:none;'>
                        <li>
                            <input type='checkbox' name='bilg_yeni_icerik' onClick='bilg_gor()' id='bilg_check1' value='True' ";
                            if ($ekicerik["bilg_yeni_icerik"] == "True") echo "checked ";
            echo   "        />Bildirimleri aç
                            <span class='sag'>
                                <input type='hidden' name='formbicimi' value='bildir' />
                                <input class='yuvar r5' type='submit' value='Kaydet' />
                            </span>
                        </li><li>
                            <ul id='bilg_acma' class='kat' style='list-style-type:none;'>
                                <li>
                                    <input type='radio' name='bilg_yeni_yorum' onClick='bilg_gor()' value='False' ";
                                    if ($ekicerik["bilg_yeni_yorum"] != "True") echo "checked ";
            echo   "                />Sadece yeni içerikleri bildir.
                                </li><li>
                                    <input type='radio' name='bilg_yeni_yorum' onClick='bilg_gor()' id='bilg_rad2s' value='True' ";
                                    if ($ekicerik["bilg_yeni_yorum"] == "True") echo "checked ";
            echo   "                />Yeni içerikleri ve yorumları bildir.
                                </li><li>
                                    <ul id='bilg_sade' class='kat' style='list-style-type:none;'>
                                        <li><input type='checkbox' name='bilg_sade_takip' value='True' ";
                                            if ($ekicerik["bilg_sade_takip"] == "True") echo "checked ";
            echo   "                        />Sadece takip edilen yorumları bildir.
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    </form>
                    <script>bilg_gor()</script>";
            break;
            
        case "sifre": //Şifre değiştirmek için
            echo   "<table>
                    <form method='post'>
                    <tr><td colspan='2'><p align='center'>$hata</p></td></tr>
                    <tr><td> Eski parola:</td><td><input type='password' name='eskiparola' /></td></tr>
                    <tr><td><br /></td></tr>
                    <tr><td> Parola:</td><td><input type='password' name='parola' /></td></tr>
                    <tr><td> Parola(tekrar):</td><td><input type='password' name='parolatekrar' /></td></tr>
                    <tr><td></td><td align='right'>
                        <input type='hidden' name='formbicimi' value='sifre' />
                        <input class='yuvar r5' type='submit' value='Şifre Değiştir' />
                    </td></tr>
                    </form>
                    </table>";
            break;
            
        case "kayipsifre":
            echo   "<h4>Yeni Parolanızı Girin</h4>
                    <p>$hata</p>
                    <form method='post'>
                        Yeni Parola:<input type='password' name='parola' tabindex='1' />
                        Parola Tekrarı:<input type='password' name='parolatekrar' tabindex='2' />
                        <input type='hidden' name='kullaniciId' value='{$ekicerik["id"]}' />
                        <input type='hidden' name='formbicimi' value='kayipsifre' />
                        <input type='submit' value='Onayla' tabindex='3' />
                    </form>";
    }
}

function tablola($id)
{
    /* verileri tablolamak için fonksiyon
     *
     * tablodaki id'si verilmek zorunda. */
    global $DBONEK;
    global $DB;
    global $AYAR;
    
    $sorgu = "SELECT * FROM {$DBONEK}icerik WHERE id='$id'";
    $sonuc = mysql_query($sorgu,$DB);

    if( mysql_num_rows($sonuc) == 1 )
    {
        $bilgi = mysql_fetch_assoc($sonuc);
        if ($bilgi["goster"] == "False") return; //gizlenmiş öğeler için tablo oluşturmaz.
       
        $sorgu2 = "SELECT id, yazi, k_id, tarih, goster FROM {$DBONEK}yorum WHERE i_id='$id' ORDER BY id";
        $sonuc2 = mysql_query($sorgu2, $DB);
        
        $k_sorgu = "SELECT bilg_sade_takip FROM {$DBONEK}kullanici WHERE id = '{$_SESSION[kid]}'";
        $k_sonuc = mysql_query($k_sorgu, $DB);
        if (mysql_num_rows($k_sonuc) == 1)
        {
            $k_bilgi = mysql_fetch_assoc($k_sonuc);
            if ($k_bilgi["bilg_sade_takip"] == "True") $takip = True;
        }
        else $takip = False;
        
        $kisi = kisiadi($bilgi["k_id"]);
        $yazi = altsatir($bilgi["yazi"]);
        $adresler = explode(",", $bilgi["adres"]);
        
        $kategoriAdi = kategoriUzun($bilgi["kategori"]);
        
        echo   "<div class='icerik yuvar r4'>
                    <div class='ibolum'>
                        <div class='sol'>
                            <a href='?icerik=$id'><strong>$bilgi[baslik]</strong></a>
                        </div>
                        <div class='sag'>";
                            if ($takip and $AYAR["Kişi E-Posta Durum"] == 1)
                            {
                                if (in_array($_SESSION["kid"], takipciListe($id))) echo "<span id='takip$id'><button class='yuvar r5' onClick='takip(0, $id, $_SESSION[kid])'>Takip Etme</button></span>";
                                else echo "<span id='takip$id'><button class='yuvar r5' onClick='takip(1, $id, $_SESSION[kid])'>Takip Et</button></span>";
                            }
                            if ($_SESSION["kid"] == $bilgi["k_id"])  echo "<a href='?sil=icerik&sil_id=$id' title='Sil'>Sil</a>";
        echo   "        </div>
                    </div>
                    
                    <div class='ibolum'>
                        <span style='font-size:0.7em'>$bilgi[tarih] </span> 
                        <a style='font-style:italic;' href='?hesap=goster&id=$bilgi[k_id]'>$kisi</a>
                        <a class='sag' href='?kategori=$bilgi[kategori]'>$kategoriAdi</a>
                    </div>";
        foreach ($adresler as $adres)
        {
            $dosyaAdi = explode("/", $adres);
            if ($adres == "") continue;
            echo   "<div class='ibolum'>
                        * <a href='$adres'>$dosyaAdi[1] indir</a>
                    </div>";
        }
        echo   "    <div class='ibolum'>
                        <div class='yazi'>
                            $yazi
                        </div>
                    </div>
                    
                    <div class='ibolum'>
                        <div class='iyorum'>";
                            while ($satir2 = mysql_fetch_array($sonuc2))
                            {
                                if ($satir2["goster"] == "False") continue;
                                
                                $kisiyor = kisiadi($satir2["k_id"]);
                                
                                echo   "<div class='yorum yuvar r5'>
                                            <div class='sag' style='font-size:0.7em'>$satir2[tarih]</div>
                                            <div class='yyazan'><a href='?hesap=goster&id=$satir2[k_id]'>$kisiyor</a>:</div>";
                                            if ($_SESSION["kid"] == $satir2["k_id"]) echo "<div class='sag'><a href='?sil=yorum&sil_id={$satir2['id']}' title='Sil'>Sil</a></div>";
                                echo   "    
                                            <div class='yazi'>$satir2[yazi]</div>
                                        </div>";
                            }
                            echo   "<div class='yorum yuvar r5'>
                                        <form name='yorum' method='post' action=''>
                                            Yorum yap:<input class='yuvar' style='width:72%' type='text' name='yazi' size='55' />
                                            <input type='hidden' name='formbicimi' value='yorum' />
                                            <input type='hidden' name='id' value='$id' />
                                            <input class='yuvar r4 sag' type='submit' value='Gönder' />
                                        </form>
                                    </div>";
        echo   "        </div>
                    </div>
                </div>";
    }
}

function sayfala($sonuc, $sayfa=1)
{
    global $AYAR;
    
    $icerikSayisi = mysql_num_rows($sonuc);
    if ($icerikSayisi <= $AYAR["Sayfada İçerik Sayısı"])
    {
        while($satir = mysql_fetch_array($sonuc))
        {
            tablola($satir["id"]);
        }
    }
    else
    {
        $sayfaSayisi = intval($icerikSayisi / $AYAR["Sayfada İçerik Sayısı"]);
        if ($icerikSayisi%$AYAR["Sayfada İçerik Sayısı"] != 0) $sayfaSayisi += 1;
        
        $siradakiNo = ($sayfa - 1) * $AYAR["Sayfada İçerik Sayısı"];
        $donguSira = 1;
        
        while($satir = mysql_fetch_array($sonuc))
        {
            if ($donguSira > $siradakiNo and $donguSira <= ($siradakiNo + $AYAR["Sayfada İçerik Sayısı"]))
            {
                tablola($satir["id"]);
            }
            $donguSira += 1;
        }
        
        if ($_GET["kategori"]) $adres = "?kategori=$_GET[kategori]&sayfano=";
        else $adres = "?sayfano=";
        
        echo   "<div class='icerik yuvar r4'>
                    <center>";
        
        if ($sayfa == 1) echo "<< < ";
        else
        {
            echo "<a href='{$adres}1'><<</a> <a href='{$adres}";
            echo $sayfa - 1;
            echo "'><</a> ";
        }
        
        for ($i=1; $i<=$sayfaSayisi ; $i++)
        {
            if ($i == $sayfa) echo "<strong>$i</strong> ";
            else echo "<a href='{$adres}{$i}'>$i</a> ";
        }
        
        if ($sayfa == $sayfaSayisi) echo "> >>";
        else
        {
            echo "<a href='{$adres}";
            echo $sayfa + 1;
            echo "'>></a> <a href='{$adres}{$sayfaSayisi}'>>></a>";
        }
        
        echo   "    </center>
                </div>";
    }
}

function profilTablola($id)
{
    /* profilleri tablolamak için fonksiyon
     *
     * tablodaki id'si verilmek zorunda. */
    global $DBONEK;
    global $DB;
    global $AYAR;
    
    $sorgu = "SELECT * FROM {$DBONEK}kullanici WHERE id='$id'";
    $sonuc = mysql_query($sorgu,$DB);

    if( mysql_num_rows($sonuc) == 1 )
    {
        $bilgi = mysql_fetch_assoc($sonuc);
        
        echo   "<div class='icerik yuvar r4'>
                    <table width='100%'><tr>
                        <td>İsim:</td>
                        <td>$bilgi[isim]</td>";
                            if ($_SESSION["kid"] == $bilgi["id"]) echo "<td align='right'><a href='?hesap=ayarla&bicim=profil' title='Profil Düzenle'>Profil Düzenle</a></td>";
        echo   "    </tr><tr>
                        <td>E-posta:</td>
                        <td>$bilgi[posta]</td>";
                            if ($_SESSION["kid"] == $bilgi["id"]) echo "<td align='right'><a href='?hesap=ayarla&bicim=sifre' title='Şifre Değiştir'>Şifre Değiştir</a></td>";
        echo   "    </tr></table>
                </div>";
        if ($_SESSION["kid"] == $bilgi["id"] and $AYAR["Kişi E-Posta Durum"] == 1)
        {
            echo   "<div class='icerik yuvar r4'>
                        <table width='100%'><tr>
                            <td>Yeni içerikleri bildirme</td>
                            <td>";
                                if ($bilgi["bilg_yeni_icerik"] == "True") echo "<strong>Açık</strong>";
                                else echo "Kapalı";
            echo   "        </td>
                            <td align='right'><a href='?hesap=ayarla&bicim=bildir' title='Bildirileri Düzenle'>Bildirileri Düzenle</a></td>
                        </tr><tr>
                            <td>Yeni yorumlarda bilgilendirme</td>
                            <td colspan='2'>";
                                if ($bilgi["bilg_yeni_yorum"] == "True")
                                {
                                    if ($bilgi["bilg_sade_takip"] == "True") echo "Sadece takip edilenler";
                                    else echo "Bütün yorumlar";
                                }
                                else echo "Kapalı";
            echo   "        </td>
                        </tr></table>
                    </div>";
        }
        
        //Taha Doğan'ın yoğun isteği üzerine kişinin son 10 yazısını gösteren kısımdır
        
        $sorgu2 = "SELECT id, baslik, tarih FROM {$DBONEK}icerik WHERE k_id = '{$id}' AND goster = 'True' ORDER BY id DESC LIMIT 10";
        $sonuc2 = mysql_query($sorgu2,$DB);
        if( mysql_num_rows($sonuc2) > 0 )
        {
            echo   "<div class='icerik yuvar r4'>
                        Paylaştığı Son 10 İçerik:
                        <ul width='100%'>";
            while ($bilgi2 = mysql_fetch_array($sonuc2))
            {
                echo   "<li><a href='?icerik={$bilgi2[id]}'>{$bilgi2[baslik]}</a><span class='sag'>{$bilgi2[tarih]}</span></li>";
            }
            echo   "    </ul>
                    </div>";
        }
    }
}

function iletiPostala($tablo, $id)
{
    //içerik ve yorumları e-posta ile bildirmek üzere yazılmış fonksiyon.
    global $DB;
    global $DBONEK;
    global $AYAR;
    global $epostaBaslik;
    
    //e-posta içeriğinin hazırlandığı kısmın --başı--
    switch($tablo)
    {
        case "icerik":
            $sorgu = "SELECT * FROM {$DBONEK}icerik WHERE id='$id'";
            $sonuc = mysql_query($sorgu, $DB);
            if (mysql_num_rows($sonuc) == 1)
            {
                $bilgi = mysql_fetch_assoc($sonuc);
                $kisiadi = kisiadi($bilgi["k_id"]);
                $kategori = kategoriUzun($bilgi["kategori"]);
                $konu = $bilgi["baslik"];
                $adresler = explode(",", $bilgi["adres"]);
                $yazi = altsatir($bilgi[yazi]);
                
                $metin =   "Yazan: $kisiadi
                            \r<br />
                            \r<br />
                            \r$yazi
                            \r<br />
                            \r<br />\n";
                foreach ($adresler as $adres)
                {
                    if ($adres == "") continue;
                    $metin = $metin .  "Dosya: <a href='{$AYAR["Anasayfa"]}{$adres}'>{$AYAR["Anasayfa"]}{$adres}</a>
                                        \r<br />\n";
                }
                $metin = $metin .  "<br />
                                    \r$kategori
                                    \r<br />
                                    \r<br />
                                    \r--Bu e-posta <a href='{$AYAR["Anasayfa"]}'>{$AYAR["Anasayfa"]}</a> tarafından otomatik oluşturulmuştur.--";
            }
            break;
            
        case "yorum":
            $y_sorgu = "SELECT * FROM {$DBONEK}yorum WHERE id='$id'";
            $y_sonuc = mysql_query($y_sorgu, $DB);
            if (mysql_num_rows($y_sonuc) == 1)
            {
                $y_bilgi = mysql_fetch_assoc($y_sonuc);
                $kisiadi = kisiadi($y_bilgi["k_id"]);
                
                $i_sorgu = "SELECT baslik FROM {$DBONEK}icerik WHERE id='$y_bilgi[i_id]'";
                $i_sonuc = mysql_query($i_sorgu, $DB);
                $i_bilgi = mysql_fetch_assoc($i_sonuc);
                $konu = "Re: $i_bilgi[baslik]";
                
                $metin =   "Yorumlayan: $kisiadi
                            \r<br />
                            \r<br />
                            \r$y_bilgi[yazi]
                            \r<br />
                            \r<br />
                            \r--Bu e-posta <a href='{$AYAR["Anasayfa"]}'>{$AYAR["Anasayfa"]}</a> tarafından otomatik oluşturulmuştur.--";
                
                $takipciler = takipciListe($y_bilgi["i_id"]);
            }
            break;
    }
    //e-posta içeriğinin hazırlandığı kısmın --sonu--
    
    //gruba e-posta gönderim kısmı
    if ($AYAR["Grup E-Posta Durum"] == 1)
    {
        mail( $AYAR["Grup E-Posta"], $konu, $metin, $epostaBaslik );
    }
    
    //kişilere e-posta gönderen kısım
    if ($AYAR["Kişi E-Posta Durum"] == 1)
    {
        $postalanacaklar = "BCC: ";
        
        $k_sorgu = "SELECT id, posta, bilg_yeni_icerik, bilg_yeni_yorum, bilg_sade_takip FROM {$DBONEK}kullanici";
        $k_sonuc = mysql_query($k_sorgu, $DB);
        while($k_bilgi = mysql_fetch_assoc($k_sonuc))
        {
            if ($_SESSION["kid"] == $k_bilgi["id"]) continue;
            if ($k_bilgi["bilg_yeni_icerik"] == "True" and $tablo == "icerik")
            {
                $postalanacaklar .= "<{$k_bilgi[posta]}>,";
                //mail( $k_bilgi["posta"], $konu, $metin, $epostaBaslik );
            }
            if ($k_bilgi["bilg_yeni_yorum"] == "True" and $tablo == "yorum")
            {
                if ($k_bilgi["bilg_sade_takip"] == "True")
                {
                    if (in_array($k_bilgi["id"], $takipciler))
                    {
                        $postalanacaklar .= "<{$k_bilgi[posta]}>,";
                        //mail( $k_bilgi["posta"], $konu, $metin, $epostaBaslik );
                    }
                }
                else
                {
                    $postalanacaklar .= "<{$k_bilgi[posta]}>,";
                    //mail( $k_bilgi["posta"], $konu, $metin, $epostaBaslik );
                }
            }
        }
        $postalanacaklar .= "\r\n";
        mail( "", $konu, $metin, $epostaBaslik . $postalanacaklar);
    }
}
?>
