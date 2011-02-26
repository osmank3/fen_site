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

function formgoster($formbicimi, $hata = "")
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
                <tr>
                    <td colspan='2' align='left'>
                        <a href='?icerik=$id'><b>$bilgi[baslik]</b></a> ";
                        if ($bicim == "dosya") echo "<a href='$bilgi[adres]'>İndir</a>";
        echo   "</td><td colspan='2' align='right'><i>$kisi</i></td>
                </tr>
                <tr>
                     <td colspan='3' width='100%'>$bilgi[yazi]</td>";
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
                echo "<td colspan='2'><i>$kisiyor</i>:<br />$satir2[yazi]</td>";
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
?>