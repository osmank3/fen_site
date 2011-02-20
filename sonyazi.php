<?php
function formgoster($hata = "") { echo "
<table>
<form method='post'>
<tr><td colspan='3' align='center'>$hata</td></tr>
<tr><td>Başlık: </td><td colspan='2'><input size='55' type='text' name='baslik'/></td></tr>
<tr><td colspan='3'><textarea id='comment' name='yazi' cols='62' rows='4' aria-required='true'></textarea></td></tr>
<tr><td>Kategori: </td><td><select name='kategori'>
    <option value=''>Kategori Seçin</option>
    <option value='xxx1'>xxx1</option>
    <option value='xxx2'>xxx2</option>
    <option value='xxx3'>xxx3</option> 
</select></td>
<td align='right'>
    <input type='hidden' name='formbicimi' value='yazi' />
    <input type='submit' value='Yazı Gönder' /></td></tr>
</form></table>";
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
    
    $sorgu = "SELECT id, k_id, baslik, icerik, kategori FROM yazi ORDER BY id DESC";
    $sonuc = mysql_query($sorgu, $db);
    while ($satir = mysql_fetch_array($sonuc))
    {
        $kisi = kisiadi($satir["k_id"]);
        
        echo "<p><table><tr><td colspan='2' align='left'><b>Başlık: </b>$satir[baslik]</td>
              <td align='right'><i>$kisi</i></td></tr>";
        echo "<tr><td colspan='3'><b>İçerik:</b> $satir[icerik]</td></tr>";
        
        $sorgu2 = "SELECT icerik, k_id FROM yorum WHERE yer='yazi' AND yer_id='$satir[id]' ORDER BY id";
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
                      ('$_SESSION[kid]', 'yazi', '$_POST[id]', '$_POST[icerik]')";
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
    }
}
formgoster();
echo "<p><br /></p>";
verial();

?>