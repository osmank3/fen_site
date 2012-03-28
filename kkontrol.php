<?php
$GIRILMIS = false;
$KULLANICI = null;

if ( !empty($_SESSION["giris"]) && !empty($_SESSION["kid"]) )
{
    $GIRILMIS = true;
    $KULLANICI = $_SESSION["kid"];
}
?>
