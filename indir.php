<?php
if($_GET["dosya"])
{
    $dosya = "dosya/".$_GET["dosya"];
    if(file_exists($dosya))
    {
        $dosya_icerigi = file_get_contents($dosya);
        header("Content-type: application/octetstream");
        header("Content-Length: " . strlen($dosya_icerigi));
        header('Content-Disposition: attachment; filename="'.$_GET["dosya"].'"');
        
        echo $dosya_icerigi;
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
