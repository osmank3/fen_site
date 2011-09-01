<?php
session_start();
include "ayar.php";
include "kkontrol.php";
if($_GET["dosya"])
{
    $dosya = "{$AYAR["Dosya Yükleme Konumu"]}/".$_GET["dosya"];
    if(file_exists($dosya))
    {
        if ($AYAR["Anonim Dosya İndirme"] == 0 and !$GIRILMIS)
        {
            echo   "<script>
                    alert('Dosyayı sadece kayıtlı kullanıcılar indirebilir.');
                    window.history.back();
                    </script>";
        }
        else
        {
            $dosya_icerigi = file_get_contents($dosya);
            header("Content-type: application/octetstream");
            header("Content-Length: " . strlen($dosya_icerigi));
            header('Content-Disposition: attachment; filename="'.$_GET["dosya"].'"');
            
            echo $dosya_icerigi;
        }
    }
    else
    {
        echo   "<script>
                alert('Dosya Bulunamadı.');
                window.history.back();
                </script>";
    }
}
?>
