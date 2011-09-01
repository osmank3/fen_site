<div class="sayfa yuvar">
<div class="sust">
    <div class="sol"><?php echo "<a href='{$AYAR["Anasayfa"]}' title='Ana Sayfa'>";?>Ana Sayfa</a></div>
    <div class="sag">
        <?php echo $KULLANICI; ?>
        <a href="?hesap=goster" title="Profil">Profil</a>
        <a href="?hesap=cikis" title="Çıkış">Çıkış</a>
    </div>
</div>

<div class="sustresim">
    <?php echo "<a href='{$AYAR["Anasayfa"]}' title='Ana Sayfa'>";?><img src="fen.png" width="100%" height="150px" border="0" alt="" /></a>
</div>

<div class="sanahat yuvar">
    <h4><a href="?sayfa=yeniicerik" title="İçerik ekle">+ Yeni İçerik</a></h4>
    <h5>Kategoriler</h5>
    <ul class='kat'>
        <?php
            $sorgu = "SELECT * FROM {$DBONEK}kategori WHERE us_id IS NULL ORDER BY id DESC";
            $sonuc = mysql_query($sorgu, $DB);
            while($bilgi = mysql_fetch_assoc($sonuc))
            {
                if ($bilgi["ustkategori"] == "False") echo "<li><a href='?kategori={$bilgi[id]}' title='{$bilgi[isim]}'>{$bilgi[isim]}</a></li>";
                else
                {
                    echo "<li>$bilgi[isim] <ul class='kat'>";
                    $ic_sorgu = "SELECT * FROM {$DBONEK}kategori WHERE us_id = '{$bilgi[id]}' ORDER BY id";
                    $ic_sonuc = mysql_query($ic_sorgu, $DB);
                    while($ic_bilgi = mysql_fetch_assoc($ic_sonuc))
                    {
                        echo "<li><a href='?kategori={$ic_bilgi[id]}' title='{$ic_bilgi[isim]}'>{$ic_bilgi[isim]}</a></li>";
                    }
                    echo "</ul></li>";
                }
            }
        ?>
    </ul>
</div>

<div class="sicerik yuvar">
    <?php include "sayfa.php" ?>
</div>

<div class="salt">
    Bu sitenin tüm içeriği CC by-nc-sa ile lisanslanmıştır. <strong>Site test aşamasındadır.</strong>
</div>
</div>
