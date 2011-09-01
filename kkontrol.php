<?php
$GIRILMIS = false;
$KULLANICI = null;

if ( !empty($_SESSION["giris"]) && !empty($_SESSION["kullanici"]) )
{
    $GIRILMIS = true;
    $KULLANICI = $_SESSION["kullanici"];
}
?>