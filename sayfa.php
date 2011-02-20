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
if (!$_GET["sayfa"] && !$_GET["kategori"] && !$_GET["oturum"])
{
    echo "Ana Sayfa";
}
?>