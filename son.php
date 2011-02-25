<?php
//global $sonbicimi;
function formgoster($hata = "") {
    global $sonbicimi;
if ($sonbicimi == "dosya"){
    echo "<table>
<form name='dosya' method='post' enctype='multipart/form-data'>
    <tr><td colspan='2' align='center'> $hata </td></tr>
    <tr><td align='center'><b>Özet: </b><input type='text' name='ozet' /></td><td align='center'>
        <input type='hidden' name='MAX_FILE_SIZE' value='30000000' />
        <input type='file' name='dosya' id='dosya' /></td></tr>
    <tr><td align='center'><b>Kategori: </b><select name='kategori'>
        <option value='diğer'>Kategori Seçin</option>
        <option value='xxx1'>xxx1</option>
        <option value='xxx2'>xxx2</option>
        <option value='xxx3'>xxx3</option>
    </select></td><td align='center'>
        <input type='hidden' name='formbicimi' value='dosya' />
        <input type='submit' value='Dosyayı Gönder' /></td></tr>
</form>
</table>";
}
elseif($sonbicimi == "yazi") {
    echo "
<table>
<form method='post'>
<tr><td colspan='3' align='center'>$hata</td></tr>
<tr><td>Başlık: </td><td colspan='2'><input size='55' type='text' name='baslik'/></td></tr>
<tr><td colspan='3'><textarea id='comment' name='yazi' cols='62' rows='4' aria-required='true'></textarea></td></tr>
<tr><td>Kategori: </td><td><select name='kategori'>
    <option value='diğer'>Kategori Seçin</option>
    <option value='xxx1'>xxx1</option>
    <option value='xxx2'>xxx2</option>
    <option value='xxx3'>xxx3</option> 
</select></td>
<td align='right'>
    <input type='hidden' name='formbicimi' value='yazi' />
    <input type='submit' value='Yazı Gönder' /></td></tr>
</form></table>";
}
}
function kisiadi($id) {
    
    global $db;
    
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
    
    global $db;
    global $sonbicimi;    
    
    if ($sonbicimi == "dosya")
        { $sorgu = "SELECT id, k_id, isim, adres, ozet, kategori, goster FROM dosya ORDER BY id DESC"; }
    elseif($sonbicimi == "yazi")
        { $sorgu = "SELECT id, k_id, baslik, icerik, kategori, goster FROM yazi ORDER BY id DESC"; }
    $sonuc = mysql_query($sorgu, $db) or die(mysql_error());
    while ($satir = mysql_fetch_array($sonuc))
    {
        if ($satir["goster"] == "False")
        {
            continue;
        }

        $kisi = kisiadi($satir["k_id"]);
        
        if ($sonbicimi == "dosya")
        {
            echo "<p><table><tr><td colspan='2' align='left'><b><a href='$satir[adres]'>$satir[isim]</a></b></td>
                  <td align='right'><i>$kisi</i></td></tr>
                  <tr><td colspan='3'>$satir[ozet] ";
            if ($_SESSION["kid"] == $satir["k_id"])
            {
                echo "<a href='?sil=dosya&sil_id={$satir["id"]}'>sil</a>";
            }
            echo "</td></tr>";
        }
        elseif($sonbicimi == "yazi")
        {
            echo "<p><table><tr><td colspan='2' align='left'><b>$satir[baslik]</b></td>
                  <td align='right'><i>$kisi</i></td></tr>
                  <tr><td colspan='3'>$satir[icerik] ";
            if ($_SESSION["kid"] == $satir["k_id"])
            {
                echo "<a href='?sil=yazi&sil_id={$satir["id"]}'>sil</a>";
            }
            echo "</td></tr>";
        }
        
        $sorgu2 = "SELECT id, icerik, k_id, goster FROM yorum WHERE yer='$sonbicimi' AND yer_id='$satir[id]' ORDER BY id";
        $sonuc2 = mysql_query($sorgu2, $db);
        
        $satirsay = mysql_num_rows($sonuc2) + 1;
        echo "<tr><td rowspan='$satirsay' valign='top'><a href='?kategori=$satir[kategori]'>$satir[kategori]</a></td>";
        if ($satirsay > 1)
        {
            while ($satir2 = mysql_fetch_array($sonuc2))
            {
                if ($satir2["goster"] == "False")
                {
                    continue;
                }
                $kisiyor = kisiadi($satir2["k_id"]);
                echo "<td colspan='2'><i>$kisiyor</i>:<br/>$satir2[icerik] ";
                if ($_SESSION["kid"] == $satir2["k_id"])
                {
                    echo "<a href='?sil=yorum&sil_id={$satir2["id"]}'>sil</a>";
                }
                echo "</td></tr><tr>";
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
                      ('$_SESSION[kid]', '$sonbicimi', '$_POST[id]', '$_POST[icerik]')";
            mysql_query($sorgu, $db);
            break;
        case "yazi":
            if (!$_POST["baslik"]) {echo "başlık giriniz";}
            elseif(!$_POST["yazi"]) {echo "yazı giriniz";}
            else
            {
                $sorgu = "INSERT INTO yazi (k_id, baslik, icerik, kategori) VALUES
                          ('$_SESSION[kid]', '$_POST[baslik]', '$_POST[yazi]', '$_POST[kategori]')";
                mysql_query($sorgu, $db);
            }
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