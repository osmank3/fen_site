<?php
if ($_POST)
{
    switch($_POST["formbicimi"])
    {
        case "yorum":
            $sorgu = "INSERT INTO {$dbOnek}yorum (k_id, i_id, yazi) VALUES
                      ('$_SESSION[kid]', '$_POST[id]', '$_POST[yazi]')";
            mysql_query($sorgu, $db);
            break;
        case "yazi":
            if (!$_POST["baslik"]) {echo "başlık giriniz";}
            elseif(!$_POST["yazi"]) {echo "yazı giriniz";}
            else
            {
                $sorgu = "INSERT INTO {$dbOnek}icerik (k_id, bicim, baslik, yazi, kategori) VALUES
                          ('$_SESSION[kid]', 'yazi', '$_POST[baslik]', '$_POST[yazi]', '$_POST[kategori]')";
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
                    $sorgu = "INSERT INTO {$dbOnek}icerik (k_id, bicim, baslik, adres, yazi, kategori) VALUES
                            ('$_SESSION[kid]', 'dosya', '{$_FILES["dosya"]["name"]}', 'dosya/{$_FILES["dosya"]["name"]}', '$_POST[yazi]', '$_POST[kategori]')";
                    mysql_query($sorgu, $db);
                }
            }
            break;
    }
}
switch ($bicim)
{
    case "dosya":
        $sorgu = "SELECT id, bicim FROM {$dbOnek}icerik WHERE bicim='$bicim' ORDER BY id DESC";
        formgoster("dosya");
        break;
    case "yazi":
        $sorgu = "SELECT id, bicim FROM {$dbOnek}icerik WHERE bicim='$bicim' ORDER BY id DESC";
        formgoster("yazi");
        break;
    default:
        $sorgu = "SELECT id, bicim FROM {$dbOnek}icerik ORDER BY id DESC";
        break;
}
$sonuc = mysql_query($sorgu, $db);

while($satir = mysql_fetch_array($sonuc))
{
    tablola($satir["id"], $satir["bicim"]);
}
?>