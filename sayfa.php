<?php
if ($_GET)
{
    if ($_GET["hesap"])
    {
        switch ($_GET["hesap"])
        {
            case "cikis":
                unset($_SESSION["giris"]);
                unset($_SESSION["kullanici"]);
                unset($_SESSION["kid"]);
                echo "<script> window.top.location = './'; </script>";
                break;
                
            case "goster":
                echo "<h3>Profil</h3>";
                if ($_GET["id"]) profilTablola($_GET["id"]);
                else profilTablola($_SESSION["kid"]);
                break;
            case "ayarla":
                $bicim = $_GET["bicim"];
                include "profil.php";
        }
    }
    elseif ($_GET["sil"])
    {
        switch ($_GET["sil"])
        {
            case "icerik":
                $sorgu = "UPDATE {$dbOnek}icerik SET goster='False' WHERE id=$_GET[sil_id]";
                mysql_query($sorgu, $db);
                unset($_POST);
                echo "<script> document.location.href = '$_SERVER[HTTP_REFERER]' </script>";
                break;
            case "yorum":
                unset($_POST);
                $sorgu = "UPDATE {$dbOnek}yorum SET goster='False' WHERE id=$_GET[sil_id]";
                mysql_query($sorgu, $db);
                echo "<script> document.location.href = '$_SERVER[HTTP_REFERER]' </script>";
                break;
        }
    }
    else
    {
        include "icerik.php";
    }
}
else
{
    echo "<h3>Ana Sayfa</h3>";
    include "icerik.php";
}
?>
