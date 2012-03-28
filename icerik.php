<?php
if ($_POST)
{
    switch($_POST["formbicimi"])
    {
        case "yorum":
            if (mb_strlen($_POST["yazi"], "utf-8") > 0)
            {
                $sorgu = "INSERT INTO {$DBONEK}yorum (k_id, i_id, yazi) VALUES
                          ('$_SESSION[kid]', '$_POST[id]', '$_POST[yazi]')";
                mysql_query($sorgu, $DB);
                
                $sorgu = "SELECT max(id) FROM {$DBONEK}yorum";
                $sonuc = mysql_query($sorgu, $DB);
                $bilgi = mysql_fetch_assoc($sonuc);
                
                iletiPostala("yorum", $bilgi["max(id)"]);
            }

            break;
            
        case "icerik":
            if (!$_POST["yazi"]) {echo "Yazı girilmeli!";}
            else
            {
                $dosyalar = "";
                foreach ($_FILES["dosya"]["error"] as $sira => $hata)
                {
                    if ($hata == 0)
                    {
                        $dosyaAdresi = "{$AYAR["Dosya Yükleme Konumu"]}/" . dosyaAdiDuzelt($_FILES["dosya"]["name"][$sira]);
                        while (file_exists($dosyaAdresi))
                        {
                            $dosyaAdresi = "{$AYAR["Dosya Yükleme Konumu"]}/" . rand(100, 1000) . "_" . dosyaAdiDuzelt($_FILES["dosya"]["name"][$sira]);
                        }
                        
                        move_uploaded_file($_FILES["dosya"]["tmp_name"][$sira], $dosyaAdresi) or die("Dosya yüklenemiyor!");
                        $dosyalar = "{$dosyalar}{$dosyaAdresi},";
                    }
                }
                
                if (mb_strlen($_POST["yazi"], "utf-8") > 60) $baslik = mb_substr($_POST["yazi"], 0, 60, "utf-8") . "...";
                else $baslik = $_POST["yazi"];
                
                
                $sorgu = "INSERT INTO {$DBONEK}icerik (k_id, baslik, adres, yazi, kategori) VALUES
                          ('$_SESSION[kid]', '$baslik', '$dosyalar', '$_POST[yazi]', '$_POST[kategori]')";
                mysql_query($sorgu, $DB);
                
                $sorgu = "SELECT max(id) FROM {$DBONEK}icerik";
                $sonuc = mysql_query($sorgu, $DB);
                $bilgi = mysql_fetch_assoc($sonuc);
                
                $sorgu = "INSERT INTO {$DBONEK}yorum (k_id, i_id, goster) VALUES
                          ('$_SESSION[kid]', '{$bilgi['max(id)']}', 'False')";
                mysql_query($sorgu, $DB);
                
                iletiPostala("icerik", $bilgi["max(id)"]);
                
                echo "<script>window.top.location = '?icerik={$bilgi['max(id)']}';</script>";
            }
            
            break;
        
        case "takip":
            include "mysql.php";
            include "ayar.php";
            include "fonksiyon.php";
            if ($_POST["durum"] == "takipet")
            {
                $sorgu = "SELECT * FROM {$DBONEK}yorum WHERE i_id='{$_POST[i_id]}' and k_id='{$_POST[k_id]}'";
                $sonuc = mysql_query($sorgu, $DB);
                if (mysql_num_rows($sonuc) > 0)
                {
                    $k_sorgu = "UPDATE {$DBONEK}yorum SET takip='True' WHERE i_id = '{$_POST[i_id]}' and k_id = '{$_POST[k_id]}'";
                    mysql_query($k_sorgu, $DB);
                }
                else
                {
                    $k_sorgu = "INSERT INTO {$DBONEK}yorum (k_id, i_id, goster) VALUES
                                ('{$_POST[k_id]}', '{$_POST[i_id]}', 'False')";
                    mysql_query($k_sorgu, $DB);
                }
            }
            elseif ($_POST["durum"] == "takipetme")
            {
                $k_sorgu = "UPDATE {$DBONEK}yorum SET takip='False' WHERE i_id = '{$_POST[i_id]}' and k_id = '{$_POST[k_id]}'";
                mysql_query($k_sorgu, $DB);
            }
            
            break;
    }
}
if($_GET["kategori"])
{
    $kategori = $_GET["kategori"];
    $sorgu = "SELECT id FROM {$DBONEK}icerik WHERE kategori='$kategori' and goster='True' ORDER BY id DESC";
    $sonuc = mysql_query($sorgu, $DB);
    
    $kategoriAdi = kategoriUzun($kategori);
    echo "<h3>$kategoriAdi</h3>";
    
    if ($_GET["sayfano"]) sayfala($sonuc, $_GET["sayfano"]);
    else sayfala($sonuc);
}
elseif($_GET["icerik"])
{
    tablola($_GET["icerik"]);
}
else
{
    switch ($_GET["sayfa"])
    {
        case "yeniicerik":
            formgoster("icerik");
            break;
        default:
            $sorgu = "SELECT id FROM {$DBONEK}icerik WHERE goster='True' ORDER BY id DESC";
            $sonuc = mysql_query($sorgu, $DB);
            
            if ($_GET["sayfano"] and count($_GET) == 1)
            {
                echo   "<h3>Ana Sayfa</h3>";
                sayfala($sonuc, $_GET["sayfano"]);
            }
            elseif ($_GET["sayfano"]) sayfala($sonuc, $_GET["sayfano"]);
            else sayfala($sonuc);
            break;
    }
}
?>
