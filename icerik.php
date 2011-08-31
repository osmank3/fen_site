<?php
if ($_POST)
{
    switch($_POST["formbicimi"])
    {
        case "yorum":
            $sorgu = "INSERT INTO {$dbOnek}yorum (k_id, i_id, yazi) VALUES
                      ('$_SESSION[kid]', '$_POST[id]', '$_POST[yazi]')";
            mysql_query($sorgu, $db);
            
            $sorgu = "SELECT max(id) FROM {$dbOnek}yorum";
            $sonuc = mysql_query($sorgu, $db);
            $bilgi = mysql_fetch_assoc($sonuc);
            
            iletiPostala("yorum", $bilgi["max(id)"]);

            break;
            
        case "icerik":
            if (!$_POST["baslik"]) {echo "Başlık girin!";}
            elseif(!$_POST["yazi"]) {echo "Yazı girin!";}
            else
            {
                $dosyalar = "";
                foreach ($_FILES["dosya"]["error"] as $sira => $hata)
                {
                    if ($hata == 0)
                    {
                        $dosyaAdresi = "$yuklemeYeri/" . dosyaAdiDuzelt($_FILES["dosya"]["name"][$sira]);
                        while (file_exists($dosyaAdresi))
                        {
                            $dosyaAdresi = "$yuklemeYeri/" . rand(100, 1000) . "_" . dosyaAdiDuzelt($_FILES["dosya"]["name"][$sira]);
                        }
                        
                        move_uploaded_file($_FILES["dosya"]["tmp_name"][$sira], $dosyaAdresi) or die("Dosya yüklenemiyor!");
                        $dosyalar = "{$dosyalar}{$dosyaAdresi},";
                    }
                }
                $sorgu = "INSERT INTO {$dbOnek}icerik (k_id, baslik, adres, yazi, kategori) VALUES
                          ('$_SESSION[kid]', '$_POST[baslik]', '$dosyalar', '$_POST[yazi]', '$_POST[kategori]')";
                mysql_query($sorgu, $db);
                
                $sorgu = "SELECT max(id) FROM {$dbOnek}icerik";
                $sonuc = mysql_query($sorgu, $db);
                $bilgi = mysql_fetch_assoc($sonuc);
                
                $sorgu = "INSERT INTO {$dbOnek}yorum (k_id, i_id, goster) VALUES
                          ('$_SESSION[kid]', '{$bilgi['max(id)']}', 'False')";
                mysql_query($sorgu, $db);
                
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
                $sorgu = "SELECT * FROM {$dbOnek}yorum WHERE i_id='{$_POST[i_id]}' and k_id='{$_POST[k_id]}'";
                $sonuc = mysql_query($sorgu, $db);
                if (mysql_num_rows($sonuc) > 0)
                {
                    $k_sorgu = "UPDATE {$dbOnek}yorum SET takip='True' WHERE i_id = '{$_POST[i_id]}' and k_id = '{$_POST[k_id]}'";
                    mysql_query($k_sorgu, $db);
                }
                else
                {
                    $k_sorgu = "INSERT INTO {$dbOnek}yorum (k_id, i_id, goster) VALUES
                                ('{$_POST[k_id]}', '{$_POST[i_id]}', 'False')";
                    mysql_query($k_sorgu, $db);
                }
            }
            elseif ($_POST["durum"] == "takipetme")
            {
                $k_sorgu = "UPDATE {$dbOnek}yorum SET takip='False' WHERE i_id = '{$_POST[i_id]}' and k_id = '{$_POST[k_id]}'";
                mysql_query($k_sorgu, $db);
            }
            
            break;
    }
}
if($_GET["kategori"])
{
    $kategori = $_GET["kategori"];
    $sorgu = "SELECT id FROM {$dbOnek}icerik WHERE kategori='$kategori' and goster='True' ORDER BY id DESC";
    $sonuc = mysql_query($sorgu, $db);
    
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
            $sorgu = "SELECT id FROM {$dbOnek}icerik WHERE goster='True' ORDER BY id DESC";
            $sonuc = mysql_query($sorgu, $db);
            
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
