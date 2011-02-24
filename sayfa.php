<?php 
switch($_GET["sayfa"])
{
    case "sonyazilar":
        $sonbicimi = "yazi";
        include "son.php";
        break;
    case "sondosyalar":
        $sonbicimi = "dosya";
        include "son.php";
        break;
}
switch($_GET["kategori"])
{
    case "xxx":
        break;
}
switch ($_GET["oturum"])
{
    case "kapat":
        unset($_SESSION["giris"]);
        unset($_SESSION["kullanici"]);
        unset($_SESSION["kid"]);
        echo "<script> window.top.location = './'; </script>";
        break;
}
switch ($_GET["sil"])
{
    case "dosya":
        $sorgu = "UPDATE dosya SET goster='False' WHERE id=$_GET[sil_id]";
        mysql_query($sorgu, $db);
        echo "<script>window.history.back()</script>";
        break;
    case "yazi":
        $sorgu = "UPDATE yazi SET goster='False' WHERE id=$_GET[sil_id]";
        mysql_query($sorgu, $db);
        echo "<script>window.history.back()</script>";
        break;
    case "yorum":
        $sorgu = "UPDATE yorum SET goster='False' WHERE id=$_GET[sil_id]";
        mysql_query($sorgu, $db);
        echo "<script>window.history.back()</script>";
        break;
}
if (!$_GET)
{
    echo "Ana Sayfa";
}
?>