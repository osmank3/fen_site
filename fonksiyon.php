<?php
$epostaBaslik = "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: $eposta";

function girisyap($id, $kullanici)
{
    $_SESSION["giris"] = true;
    $_SESSION["kid"] = $id;
    $_SESSION["kullanici"] = $kullanici;
    echo "<script> window.top.location = './'; </script>";
}

function aktifPosta($kod)
{
    global $anasayfa;
    
    $metin =   "Fen Bilgisi sitesine üyeliğinizin gerçekleşmesi için aşağıdaki bağlantıya tıklayın
                \r<br />
                \r<br />
                \r<a href='{$anasayfa}?hesap=aktif&kod=$kod'>{$anasayfa}?hesap=aktif&kod=$kod</a>
                \r<br />
                \r<br />
                \rBağlantıya tıklanamıyorsa tarayıcınızın adres çubuğuna yapıştırınız." ;

    return $metin;
}

function kayipPosta($kod)
{
    global $anasayfa;
    
    $metin =   "Fen Bilgisi sitesinde şifrenizi değiştirebilmeniz için oluşturulan bağlantı aşağıdadır
                \r<br />
                \r<br />
                \r<a href='{$anasayfa}?hesap=kayip&kod=$kod'>{$anasayfa}?hesap=kayip&kod=$kod</a>
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
    $kategoriler = array();
    $kategoriler["bilimindogasi"] = "Bilimin Doğası";
    $kategoriler["cevre"] = "Çevre Bilimi";
    $kategoriler["fenlab"] = "Fen Laboratuvarı";
    $kategoriler["genetik"] = "Genetik";
    $kategoriler["olcme"] = "Ölçme Değerlendirme";
    $kategoriler["ozelogretim"] = "Özel Öğretim";
    $kategoriler["toplum"] = "Topluma Hizmet";
    $kategoriler["yer"] = "Yer Bilimi";
    $kategoriler["diger"] = "Diğer";
    
    return $kategoriler[$kategori];
}

function kisiadi($id)
{
    //kişi adlarını "isim soyisim" şeklinde dönen fonksiyon
    global $db;
    global $dbOnek;
    
    $sorgu = "SELECT isim, soyisim FROM {$dbOnek}kullanici WHERE id = '$id'";
    $kisi = mysql_query($sorgu,$db);
    if( mysql_num_rows($kisi) == 1 )
    {
        $bilgi = mysql_fetch_assoc($kisi);
        $kisi = "$bilgi[isim] $bilgi[soyisim]";
        return $kisi;
    }
    else { return ""; }
}

function formgoster($formbicimi, $hata = "", $profil = NULL)
{
    /* veri gönderme için kullanılacak formları göstermek için fonksiyon
     *
     * form biçimi girilmek zorunda, hata girilmesi isteğe bağlı */
    switch($formbicimi)
    {
        case "giris": //giriş bölümü için form
            echo   "<h4>Giriş</h4>
                    <p>$hata</p>
                    <form method='post'>
                        Kullanıcı Adı:<input type='text' name='giriskullanici' tabindex='1' ";
                            if ($_POST["giriskullanici"]) echo "value='$_POST[giriskullanici]'";
            echo   "        />
                        Parola:<input type='password' name='girisparola' tabindex='2' />
                        <input type='hidden' name='formbicimi' value='giris' />
                        <input type='submit' value='Giriş' tabindex='3' />
                    </form>";
            break;
        
        case "dosya": //dosya yüklemek için form
            echo "<table>
                  <form name='dosya' method='post' enctype='multipart/form-data' action=''>
                      <tr><td colspan='2' align='center'> $hata </td></tr>
                      <tr><td align='center'><b>Özet: </b><input type='text' name='yazi' /></td><td align='center'>
                          <input type='hidden' name='MAX_FILE_SIZE' value='30000000' />
                          <input type='file' name='dosya' id='dosya' /></td></tr>
                      <tr><td align='center'><b>Kategori: </b><select name='kategori'>
                          <option value='diger'>Kategori Seçin</option>
                          <option value='bilimindogasi'>Bilimin Doğası</option>
                          <option value='cevre'>Çevre Bilimi</option>
                          <option value='fenlab'>Fen Laboratuvarı</option>
                          <option value='genetik'>Genetik</option>
                          <option value='olcme'>Ölçme Değerlendirme</option>
                          <option value='ozelogretim'>Özel Öğretim</option>
                          <option value='toplum'>Topluma Hizmet</option>
                          <option value='yer'>Yer Bilimi</option>
                          <option value='diger'>Diğer</option>
                      </select></td><td align='center'>
                          <input type='hidden' name='formbicimi' value='dosya' />
                          <input type='submit' value='Dosyayı Gönder' /></td></tr>
                  </form>
                  </table>";
            break;
        
        case "yazi": //yazı göndermek için form
            echo "<table>
                  <form method='post' action=''>
                  <tr><td colspan='3' align='center'>$hata</td></tr>
                  <tr><td>Başlık: </td><td colspan='2'><input size='55' type='text' name='baslik'/></td></tr>
                  <tr><td colspan='3'><textarea id='comment' name='yazi' cols='62' rows='4' aria-required='true'></textarea></td></tr>
                  <tr><td>Kategori: </td><td><select name='kategori'>
                      <option value='diger'>Kategori Seçin</option>
                      <option value='bilimindogasi'>Bilimin Doğası</option>
                      <option value='cevre'>Çevre Bilimi</option>
                      <option value='fenlab'>Fen Laboratuvarı</option>
                      <option value='genetik'>Genetik</option>
                      <option value='olcme'>Ölçme Değerlendirme</option>
                      <option value='ozelogretim'>Özel Öğretim</option>
                      <option value='toplum'>Topluma Hizmet</option>
                      <option value='yer'>Yer Bilimi</option>
                      <option value='diger'>Diğer</option>
                  </select></td>
                  <td align='right'>
                      <input type='hidden' name='formbicimi' value='yazi' />
                      <input type='submit' value='Yazı Gönder' /></td></tr>
                  </form>
                  </table>";
            break;
        
        case "kaydol": //kaydolmak için form
            echo   "<h4>Kaldol</h4>
                    <p>$hata</p>
                    <table align='center'>
                    <form method='post'>
                        <tr>
                            <td>İsim:</td>
                            <td><input type='text' name='isim' tabindex='4' ";
                                if ($_POST["isim"]) echo "value='$_POST[isim]' ";
            echo   "            /></td>
                            <td>Kullanıcı Adı:</td>
                            <td><input type='text' name='kullanici' tabindex='7' ";
                                if ($_POST["kullanici"]) echo "value='$_POST[kullanici]' ";
            echo   "            /></td>
                        </tr>
                        <tr>
                            <td>Soyisim:</td>
                            <td><input type='text' name='soyisim' tabindex='5' ";
                                if ($_POST["soyisim"]) echo "value='$_POST[soyisim]' ";
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
                        Kullanıcı Adı:<input type='text' name='kayipkullanici' tabindex='11' ";
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
                      <tr><td>İsim:</td><td><input type='text' name='isim' value='$profil[isim]' /></td></tr>
                      <tr><td> Soyisim:</td><td><input type='text' name='soyisim' value='$profil[soyisim]' /></td></tr>
                      <tr><td> E-posta:</td><td><input type='text' name='email' value='$profil[posta]' /></td></tr>
                      <tr><td></td><td align='right'>
                          <input type='hidden' name='formbicimi' value='profil' />
                          <input type='submit' value='Kaydet' />
                      </td></tr>
                  </form>
                  </table>";
            break;
            
        case "sifre": //Şifre değiştirmek için
            echo "<table>
                  <form method='post'>
                  <tr><td colspan='2'><p align='center'>$hata</p></td></tr>
                  <tr><td> Eski parola:</td><td><input type='password' name='eskiparola' ";
                  if ($profil) {echo "disabled ";}
            echo "/></td></tr>
                  <tr><td><br /></td></tr>
                  <tr><td> Parola:</td><td><input type='password' name='parola' /></td></tr>
                  <tr><td> Parola(tekrar):</td><td><input type='password' name='parolatekrar' /></td></tr>
                  <tr><td></td><td align='right'>";
                      if ($profil) { echo "<input type='hidden' name='formbicimi' value='sifre0' />";}
                      else { echo "<input type='hidden' name='formbicimi' value='sifre' />";}
            echo "    <input type='submit' value='Şifre Değiştir' /></td></tr>
                  </form>
                  </table>";
            break;
    }
}

function tablola($id)
{
    /* verileri tablolamak için fonksiyon
     *
     * tablodaki id'si verilmek zorunda. */
    global $dbOnek;
    global $db;
    
    $sorgu = "SELECT k_id, baslik, bicim, adres, yazi, kategori, goster FROM {$dbOnek}icerik WHERE id='$id'";
    $sonuc = mysql_query($sorgu,$db);

    if( mysql_num_rows($sonuc) == 1 )
    {
        $bilgi = mysql_fetch_assoc($sonuc);
        if ($bilgi["goster"] == "False") return; //gizlenmiş öğeler için tablo oluşturmaz.
       
        $sorgu2 = "SELECT id, yazi, k_id, goster FROM {$dbOnek}yorum WHERE i_id='$id' ORDER BY id";
        $sonuc2 = mysql_query($sorgu2, $db);
        
        $kisi = kisiadi($bilgi["k_id"]);
        $yazi = altsatir($bilgi["yazi"]);
        $adres = $bilgi[adres];
        
        $kategoriAdi = kategoriUzun($bilgi["kategori"]);
        
        echo   "<div class='icerik yuvar'>
                    <div class='ibolum'>
                        <div class='iyazan'>
                            <a href='?hesap=goster&id=$bilgi[k_id]'>$kisi</a>
                        </div>
                        
                        <div class='ibaslik'>
                            <a href='?icerik=$id'><b>$bilgi[baslik]</b></a> ";
                            if ($bilgi["bicim"] == "dosya") echo "<a href='$adres'>İndir</a>";
        echo   "        </div>
                    </div>
                    
                    <div class='ibolum'>
                        <div class='iislem'>";
                            if ($_SESSION["kid"] == $bilgi["k_id"])  echo "<a href='?sil=dosya&sil_id=$id' title='Sil'>Sil</a>";
        echo   "        </div>
                        <div class='yazi'>
                            $yazi
                        </div>
                        
                    </div>
                    
                    <div class='ibolum'>
                        <div class='ikatalog'>
                            <a href='?kategori=$bilgi[kategori]'>$kategoriAdi</a>
                        </div>
                        
                        <div class='iyorum'>";
                            while ($satir2 = mysql_fetch_array($sonuc2))
                            {
                                if ($satir2["goster"] == "False") continue;
                                
                                $kisiyor = kisiadi($satir2["k_id"]);
                                
                                echo   "<div class='yorum yuvar'>";
                                            if ($_SESSION["kid"] == $satir2["k_id"]) echo "<div class='yislem'><a href='?sil=yorum&sil_id={$satir2['id']}' title='Sil'>Sil</a></div>";
                                echo   "    <div class='yyazan'><a href='?hesap=goster&id=$satir2[k_id]'>$kisiyor</a>:</div>
                                            <div class='yazi'>$satir2[yazi]</div>
                                        </div>";
                            }
                            echo   "<div class='yorum yuvar'>
                                        <form name='yorum' method='post' action=''>
                                            Yorum yap:<input type='text' name='yazi' size='55' />
                                            <input type='hidden' name='formbicimi' value='yorum' />
                                            <input type='hidden' name='id' value='$id' />
                                            <input type='submit' value='Gönder' />
                                        </form>
                                    </div>";
        echo   "        </div>
                    </div>
                </div>";
    }
}

function profilTablola($id)
{
    /* profilleri tablolamak için fonksiyon
     *
     * tablodaki id'si verilmek zorunda. */
    global $dbOnek;
    global $db;
    
    $sorgu = "SELECT * FROM {$dbOnek}kullanici WHERE id='$id'";
    $sonuc = mysql_query($sorgu,$db);

    if( mysql_num_rows($sonuc) == 1 )
    {
        $bilgi = mysql_fetch_assoc($sonuc);
        
        echo   "<p><table width='100%'>
                <tr>
                    <td>Kullanıcı Adı:</td><td>$bilgi[kullanici]</td>
                </tr><tr>
                    <td>İsim:</td><td>$bilgi[isim]</td>
                </tr><tr>
                    <td>Soyisim:</td><td>$bilgi[soyisim]</td>
                </tr><tr>
                    <td>E-posta:</td><td>$bilgi[posta]</td>
                </tr>";
        if ($_SESSION["kid"] == $bilgi["id"])
        {
            echo   "<tr><td><br /></td></tr>
                    <tr>
                        <td><a href='?hesap=ayarla&bicim=sifre' title='Şifre Değiştir'>Şifre Değiştir</a></td>
                        <td><a href='?hesap=ayarla&bicim=profil' title='Profil Düzenle'>Profil Düzenle</a></td>
                    </tr>";
        }
        echo   "</table></p>";
    }
}

function grubaPosta($tablo, $id)
{
    //yeni içeriği google gruba postalayan fonksiyon 
    global $db;
    global $dbOnek;
    global $anasayfa;
    global $eposta;
    global $epostaBaslik;
    global $grupEposta;
    global $grupEpostaDurum;
    
    if (!$grupEpostaDurum) return;
    
    switch($tablo)
    {
        case "icerik":
            $sorgu = "SELECT * FROM {$dbOnek}icerik WHERE id='$id'";
            $sonuc = mysql_query($sorgu, $db);
            if (mysql_num_rows($sonuc) == 1)
            {
                $bilgi = mysql_fetch_assoc($sonuc);
                $kisiadi = kisiadi($bilgi["k_id"]);
                $kategori = kategoriUzun($bilgi["kategori"]);
                $konu = $bilgi["baslik"];
                if ($bilgi["bicim"] == "yazi")
                {
                    $metin =   "Yazan: $kisiadi
                                \r<br />
                                \r<br />
                                \r$bilgi[yazi]
                                \r<br />
                                \r<br />
                                \r$kategori
                                \r<br />
                                \r<br />
                                \r--Bu e-posta <a href='$anasayfa'>$anasayfa</a> tarafından otomatik oluşturulmuştur.--";
                }
                elseif ($bilgi["bicim"] == "dosya")
                {
                    if (substr($bilgi["adres"], 0, 4) == "http")
                    {
                        $adres = $bilgi["adres"];
                    }
                    else
                    {
                        $adres = "{$anasayfa}{$bilgi["adres"]}";
                    }
                    $metin =   "Yükleyen: $kisiadi
                                \r<br />
                                \r<br />
                                \r$bilgi[yazi]
                                \r<br />
                                \r<br />
                                \rİndir: <a href='$adres'>$adres</a>
                                \r<br />
                                \r<br />
                                \r$kategori
                                \r<br />
                                \r<br />
                                \r--Bu e-posta <a href='$anasayfa'>$anasayfa</a> tarafından otomatik oluşturulmuştur.--";
                }
                
                mail( $grupEposta, $konu, $metin, $epostaBaslik );
            }
            break;
            
        case "yorum":
            $sorgu = "SELECT * FROM {$dbOnek}yorum WHERE id='$id'";
            $sonuc = mysql_query($sorgu, $db);
            if (mysql_num_rows($sonuc) == 1)
            {
                $bilgi = mysql_fetch_assoc($sonuc);
                $kisiadi = kisiadi($bilgi["k_id"]);
                
                $sorgu2 = "SELECT baslik FROM {$dbOnek}icerik WHERE id='$bilgi[i_id]'";
                $sonuc2 = mysql_query($sorgu2, $db);
                $bilgi2 = mysql_fetch_assoc($sonuc2);
                $konu = $bilgi2["baslik"];
                
                $metin =   "Yorumlayan: $kisiadi
                            \r<br />
                            \r<br />
                            \r$bilgi[yazi]
                            \r<br />
                            \r<br />
                            \r--Bu e-posta <a href='$anasayfa'>$anasayfa</a> tarafından otomatik oluşturulmuştur.--";
                
                mail( $grupEposta, "Re: $konu", $metin, $epostaBaslik );
            }
            break;
    }
}
?>
