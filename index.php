<?php
session_start();
include "mysql.php";
include "kkontrol.php";

if ($girilmis)
{
    include "temel.php";
}
else
{
    include "giris.php";
}
?>