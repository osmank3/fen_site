<?php
$girilmis = false;
$kullanici = null;

if ( !empty($_SESSION["giris"]) && !empty($_SESSION["kullanici"]) )
{
    $girilmis = true;
    $kullanici = $_SESSION["kullanici"];
}
?>