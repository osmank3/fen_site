<?php
//site ayarları

//siteyi bakıma alma durumu
$BAKIMDA = FALSE;

if (!$BAKIMDA)
{
    include "mysql.php";
    $AYAR = array();
    
    $sorgu = "SELECT * FROM {$DBONEK}ayar";
    $sonuc = mysql_query($sorgu, $DB);
    
    while ($bilgi = mysql_fetch_assoc($sonuc))
    {
        $AYAR[$bilgi["anahtar"]] = $bilgi["deger"];
    }
}
?>