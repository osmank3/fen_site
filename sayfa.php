<?php 
switch($_GET["sayfa"])
{
    case "yazilar":
        $bicim = "yazi";
        include "icerik.php";
        break;
    case "dosyalar":
        $bicim = "dosya";
        include "icerik.php";
        break;
    case "yeniyazi":
        $bicim = "yeniyazi";
        include "icerik.php";
        break;
    case "yenidosya":
        $bicim = "yenidosya";
        include "icerik.php";
        break;
}
if($_GET["kategori"])
{
    $kategori = $_GET["kategori"];
    include "kategori.php";
}
if($_GET["icerik"])
{
    tablola($_GET["icerik"]);
}
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
switch ($_GET["sil"])
{
    case "dosya":
        $sorgu = "UPDATE {$dbOnek}icerik SET goster='False' WHERE id=$_GET[sil_id]";
        mysql_query($sorgu, $db);
        unset($_POST);
        echo "<script> document.location.href = '$_SERVER[HTTP_REFERER]' </script>";
        break;
    case "yazi":
        unset($_POST);
        $sorgu = "UPDATE {$dbOnek}icerik SET goster='False' WHERE id=$_GET[sil_id]";
        mysql_query($sorgu, $db);
        echo "<script> document.location.href = '$_SERVER[HTTP_REFERER]' </script>";
        break;
    case "yorum":
        unset($_POST);
        $sorgu = "UPDATE {$dbOnek}yorum SET goster='False' WHERE id=$_GET[sil_id]";
        mysql_query($sorgu, $db);
        echo "<script> document.location.href = '$_SERVER[HTTP_REFERER]' </script>";
        break;
}
if (!$_GET)
{
    echo "<h3>Ana Sayfa</h3>";
    include "icerik.php";
}
?>