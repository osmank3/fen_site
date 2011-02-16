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
if (!$_GET["sayfa"] && !$_GET["kategori"])
    {
        echo "Ana Sayfa";
    }
?>