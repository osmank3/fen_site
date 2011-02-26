<?php
$sorgu = "SELECT id, bicim FROM {$dbOnek}icerik WHERE kategori='$kategori' ORDER BY id DESC";
$sonuc = mysql_query($sorgu, $db);

$kategoriAdi = kategoriUzun($kategori);
echo "<h3>$kategoriAdi</h3>";
while($satir = mysql_fetch_array($sonuc))
{
    tablola($satir["id"], $satir["bicim"]);
}
?>