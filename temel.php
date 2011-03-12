<div class="sayfa yuvar">
<div class="sust">
    <div class="sustsol"><?php echo "<a href='$anasayfa' title='Ana Sayfa'>";?>Ana Sayfa</a></div>
    <div class="sustsag">
        <?php echo $kullanici; ?>
        <a href="?hesap=goster" title="Profil">Profil</a>
        <a href="?hesap=cikis" title="Çıkış">Çıkış</a>
    </div>
</div>

<div class="ustresiml">
    <img src="fen.png" width="100%" height="150px" alt="" />
</div>

<div class="sanahat yuvar">
    <?php echo "<a href='$anasayfa' title='Ana Sayfa'>";?>Ana Sayfa</a><br />
    <a href="?sayfa=yazilar" title="Sadece Yazılar">Sadece Yazılar</a><br />
    <a href="?sayfa=dosyalar" title="Sadece Dosyalar">Sadece Dosyalar</a><br />
    <h5>Yeni</h5><ul>
        <li><a href="?sayfa=yeniyazi" title="Yazı ekle">Yazı</a></li>
        <li><a href="?sayfa=yenidosya" title="Dosya ekle">Dosya</a></li></ul>
    <h5>Kategoriler</h5><ul>
        <li><a href="?kategori=bilimindogasi" title="Bilimin Doğası">Bilimin Doğası</a></li>
        <li><a href="?kategori=cevre" title="Çevre Bilimi">Çevre Bilimi</a></li>
        <li><a href="?kategori=fenlab" title="Fen Laboratuvarı">Fen Laboratuvarı</a></li>
        <li><a href="?kategori=genetik" title="Genetik">Genetik</a></li>
        <li><a href="?kategori=olcme" title="Ölçme Değerlendirme">Ölçme Değerlendirme</a></li>
        <li><a href="?kategori=ozelogretim" title="Özel Öğretim">Özel Öğretim</a></li>
        <li><a href="?kategori=toplum" title="Topluma Hizmet">Topluma Hizmet</a></li>
        <li><a href="?kategori=yer" title="Yer Bilimi">Yer Bilimi</a></li>
        <li><a href="?kategori=diger" title="Diğer">Diğer</a></li></ul>
</div>


<div class="sicerik yuvar">
    <?php include "sayfa.php" ?>
</div>

<div class="salt">
    Bu sitenin tüm içeriği CC by-nc-sa ile lisanslanmıştır. <b>Site test aşamasındadır.</b>
</div>
</div>
