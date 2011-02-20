<?php
function formgoster($hata = "") { echo "
<table>
<form name='dosya' method='post' enctype='multipart/form-data'>
    <tr><td colspan='2' align='center'> $hata </td></tr>
    <tr><td align='center'><b>Özet: </b><input type='text' name='ozet' /></td><td align='center'>
        <input type='file' name='dosya' id='dosya' /></td></tr>
    <tr><td align='center'><b>Kategori: </b><select name='kategori'>
        <option value=''>Kategori Seçin</option>
        <option value='xxx1'>xxx1</option>
        <option value='xxx2'>xxx2</option>
        <option value='xxx3'>xxx3</option>
    </select></td><td align='center'>
        <input type='hidden' name='formbicimi' value='dosya' />
        <input type='submit' value='Dosyayı Gönder' /></td></tr>
</form>
</table>";
}
function kisiadi($id) {
    
    include "mysql.php";
    
    $sorgu = "SELECT isim, soyisim FROM kullanici WHERE id = '$id'";
    $sonuc = mysql_query($sorgu,$db);
    if( mysql_num_rows($sonuc) == 1 )
    {
        $bilgi = mysql_fetch_assoc($sonuc);
        $kisi = "$bilgi[isim] $bilgi[soyisim]";
        return $kisi;
    }
    else { return ""; }
}
function verial() {
    
    include "mysql.php";
    
    $sorgu = "SELECT id, k_id, isim, adres, ozet, kategori FROM dosya ORDER BY id DESC";
    $sonuc = mysql_query($sorgu, $db);
    while ($satir = mysql_fetch_array($sonuc))
    {
        $kisi = kisiadi($satir["k_id"]);
        
        echo "<p><table><tr><td colspan='2' align='left'><b>Dosya: </b><a href='$satir[adres]'>$satir[isim]</a></td>
              <td align='right'><i>$kisi</i></td></tr>";
        echo "<tr><td colspan='3'><b>Özet:</b> $satir[ozet]</td></tr>";
        
        $sorgu2 = "SELECT icerik, k_id FROM yorum WHERE yer='dosya' AND yer_id='$satir[id]' ORDER BY id";
        $sonuc2 = mysql_query($sorgu2, $db);
        
        $satirsay = mysql_num_rows($sonuc2) + 1;
        echo "<tr><td rowspan='$satirsay' valign='top'><a href='?kategori=$satir[kategori]'>$satir[kategori]</a></td>";
        if ($satirsay > 1)
        {
            while ($satir2 = mysql_fetch_array($sonuc2))
            {
                $kisiyor = kisiadi($satir2["k_id"]);
                echo "<td colspan='2'><i>$kisiyor</i>:<br/>$satir2[icerik]</td></tr><tr>";
            }
        }
        echo "<td colspan='2'><form name='yorum' method='post'>
              Yorum yap:<input type='text' name='icerik' />
              <input type='hidden' name='formbicimi' value='yorum' />
              <input type='hidden' name='id' value='$satir[id]' />
              <input type='submit' value='Gönder' /></form>";
        echo "</td></tr></table><p>";
    }
}
if ($_POST)
{
    switch($_POST["formbicimi"])
    {
        case "yorum":
            $sorgu = "INSERT INTO yorum (k_id, yer, yer_id, icerik) VALUES
                      ('$_SESSION[kid]', 'dosya', '$_POST[id]', '$_POST[icerik]')";
            mysql_query($sorgu, $db);
            break;
        case "dosya":
            if ($_FILES["dosya"]["error"] > 0)
            {
                echo "Hata Kodu: " . $_FILES["dosya"]["error"] . "<br />";
            }
            else
            {
                if (file_exists("dosya/" . $_FILES["dosya"]["name"]))
                {
                    echo $_FILES["dosya"]["name"] . " dosyası zaten var. Dosyanın ismin değiştirip tekrar deneyin.";
                }
                else
                {
                    move_uploaded_file($_FILES["dosya"]["tmp_name"],
                            "dosya/" . $_FILES["dosya"]["name"]);
                    echo "dosya yüklendi.";
                    $sorgu = "INSERT INTO dosya (k_id, isim, adres, ozet, kategori) VALUES
                            ('$_SESSION[kid]', '" . $_FILES[dosya][name] . "', 'dosya/" . $_FILES[dosya][name] . "', '$_POST[ozet]', '$_POST[kategori]')";
                    mysql_query($sorgu, $db);
                }
            }
            break;
    }
}
formgoster();
echo "<p><br /></p>";
verial();

?>