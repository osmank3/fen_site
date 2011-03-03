<?php
function girisyap($id, $kullanici)
{
    $_SESSION["giris"] = true;
    $_SESSION["kid"] = $id;
    $_SESSION["kullanici"] = $kullanici;
    echo "<script> window.top.location = './'; </script>";
}

function aktifPosta($kod) {
    global $anasayfa;
    
    $metin = "Fen Bilgisi sitesine üyeliğinizin gerçekleşmesi için aşağıdaki bağlantıya tıklayın

{$anasayfa}?hesap=aktif&kod=$kod

Bağlantıya tıklanamıyorsa tarayıcınızın adres çubuğuna yapıştırınız." ;

    return $metin;
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
            echo "<table style='width:270px; margin:7em auto; background-color: #FFFFFF;'>
                  <form method='post'>
                      <tr><td colspan='2'><p align='center'> $hata </p></td></tr>
                      <tr><td> Kullanıcı Adı:</td><td><input type='text' name='giriskullanici' ";
            if ($_POST["giriskullanici"]) echo "value='$_POST[giriskullanici]'";
            echo "        /></td></tr>
                      <tr><td> Parola:</td><td><input type='password' name='girisparola' /></td></tr>
                      <tr><td></td><td align='right'>
                          <input type='hidden' name='formbicimi' value='giris' />
                          <input type='submit' value='Giriş' /></td></tr>
                  </form>
                  </table>";
            break;
        
        case "dosya": //dosya yğklemek için form
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
            echo "<table style='width:270px; margin:7em auto; background-color: #FFFFFF;'>
                  <tr><td colspan='2'><p align='center'>$hata</p></td></tr>
                  <form method='post'>
                  <tr><td> İsim:</td><td><input type='text' name='isim' ";
            if ($_POST["isim"]) echo "value='$_POST[isim]'";
            echo "/></td></tr>
                  <tr><td> Soyisim:</td><td><input type='text' name='soyisim' ";
            if ($_POST["soyisim"]) echo "value='$_POST[soyisim]'";
            echo "/></td></tr>
                  <tr><td> E-posta:</td><td><input type='text' name='email' ";
            if ($_POST["email"]) echo "value='$_POST[email]'";
            echo "/></td></tr>
                  <tr><td><br /></td></tr>
                  <tr><td> Kullanıcı Adı:</td><td><input type='text' name='kullanici' ";
            if ($_POST["kullanici"]) echo "value='$_POST[kullanici]'";
            echo "/></td></tr>
                  <tr><td> Parola:</td><td><input type='password' name='parola' /></td></tr>
                  <tr><td> Parola(tekrar):</td><td><input type='password' name='parolatekrar' /></td></tr>
                  <tr><td></td><td align='right'>
                      <input type='hidden' name='formbicimi' value='kaydol' />
                      <input type='submit' value='Kaydol' /></td></tr>
                  </form>
                  </table>";
            break;
        case "profil":
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
        case "sifre":
            echo "<table>
                  <form method='post'>
                  <tr><td colspan='2'><p align='center'>$hata</p></td></tr>                  
                  <tr><td> Eski parola:</td><td><input type='password' name='eskiparola' /></td></tr>
                  <tr><td><br /></td></tr>
                  <tr><td> Parola:</td><td><input type='password' name='parola' /></td></tr>
                  <tr><td> Parola(tekrar):</td><td><input type='password' name='parolatekrar' /></td></tr>
                  <tr><td></td><td align='right'>
                      <input type='hidden' name='formbicimi' value='sifre' />
                      <input type='submit' value='Şifre Değiştir' /></td></tr>
                  </form>
                  </table>";
            break;
    }
}

function tablola($id, $bicim = NULL)
{
    /* verileri tablolamak için fonksiyon
     *
     * tablo biçimi("dosya"/"yazi") ve tablodaki id'si verilmek zorunda. */
    global $dbOnek;
    global $db;
    
    $sorgu = "SELECT k_id, baslik, adres, yazi, kategori, goster FROM {$dbOnek}icerik WHERE id='$id'";
    $sonuc = mysql_query($sorgu,$db);

    if( mysql_num_rows($sonuc) == 1 )
    {
        $bilgi = mysql_fetch_assoc($sonuc);
        if ($bilgi["goster"] == "False") return; //gizlenmiş öğeler için tablo oluşturmaz.
        
        $kisi = kisiadi($bilgi["k_id"]);
        echo   "<p><table width='100%'>
                <tr><td width='25%'></td colspan='3'><td width='75%'></td></tr>
                <tr>
                    <td colspan='2' align='left'>
                        <a href='?icerik=$id'><b>$bilgi[baslik]</b></a> ";
                        if ($bicim == "dosya") echo "<a href='$bilgi[adres]'>İndir</a>";
        echo   "</td><td colspan='2' align='right'><i><a href='?hesap=goster&id=$bilgi[k_id]'>$kisi</a></i></td>
                </tr>
                <tr>
                     <td colspan='3'>$bilgi[yazi]</td>";
                     if ($_SESSION["kid"] == $bilgi["k_id"])
                     {
                         echo "<td align='center'><a href='?sil=dosya&sil_id=$id'>sil</a></td>";
                     }
        echo   "</tr>";
        
        $sorgu2 = "SELECT id, yazi, k_id, goster FROM {$dbOnek}yorum WHERE i_id='$id' ORDER BY id";
        $sonuc2 = mysql_query($sorgu2, $db);
        
        $satirsay = mysql_num_rows($sonuc2) + 1;
        $kategoriAdi = kategoriUzun($bilgi[kategori]);
        echo   "<tr><td rowspan='$satirsay' valign='top'><a href='?kategori=$bilgi[kategori]'>$kategoriAdi</a></td>";
        
        if ($satirsay > 1)
        {
            while ($satir2 = mysql_fetch_array($sonuc2))
            {
                if ($satir2["goster"] == "False") continue;
                
                $kisiyor = kisiadi($satir2["k_id"]);
                echo "<td colspan='2'><i><a href='?hesap=goster&id=$satir2[k_id]'>$kisiyor</a></i>:<br />$satir2[yazi]</td>";
                if ($_SESSION["kid"] == $satir2["k_id"])
                {
                    echo "<td align='center'><a href='?sil=yorum&sil_id={$satir2['id']}'>sil</a></td>";
                }
                echo "</tr>";
            }
         }
         echo   "<td colspan='2'>
                     <form name='yorum' method='post' action=''>
                     Yorum yap:<input type='text' name='yazi' size='55' />
                 </td>
                 <td>
                     <input type='hidden' name='formbicimi' value='yorum' />
                     <input type='hidden' name='id' value='$id' />
                     <input type='submit' value='Gönder' /></form>
                 </td></tr></table></p>";
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
    global $grupEposta;
    
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
                    $metin = "Yazan: $kisiadi\n\n$bilgi[yazi]\n\n$kategori\n\n
                              \r--Bu e-posta otomatik oluşturulmuştur.--";
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
                    $metin = "Yükleyen: $kisiadi\n\n$bilgi[yazi]\n\nİndir: $adres\n\n$kategori\n
                              \r--Bu e-posta $anasayfa tarafından otomatik oluşturulmuştur.--";
                }
                mail( $grupEposta, $konu, $metin, "From: $eposta" );
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
                
                $metin = "Yorumlayan: $kisiadi\n\n$bilgi[yazi]\n
                          \r--Bu e-posta $anasayfa tarafından otomatik oluşturulmuştur.--";
                
                mail( $grupEposta, "Re: $konu", $metin, "From: $eposta" );
            }
            break;
    }
}
?>