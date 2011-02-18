<?php 
switch($_GET["sayfa"])
{
    case "sonyazilar":
        include "sonyazi.php";
        break;
    case "sondosyalar":
        include "sondosya.php";
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
        echo "<script> window.top.location = './'; </script>";
        break;
}
if (!$_GET["sayfa"] && !$_GET["kategori"] && !$_GET["oturum"])
{
    echo "Ana Sayfa";
}
?>