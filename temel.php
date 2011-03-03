<table id="main">
<tr>
    <td>
        <table width="100%"><tr><td style="text-align: left">
            <?php echo "<a href='$anasayfa' title='Ana Sayfa'>";?>Ana Sayfa</a>
        </td>
        <td style="text-align: right">
            <?php echo $kullanici; ?>
            <a href="?hesap=goster" title="Profil">Profil</a>
            <a href="?hesap=cikis" title="Çıkış">Çıkış</a>
        </td></tr></table>
    </td>
</tr>
<tr>
    <td><img src="fen.png" width="100%" height="150px" alt="" /></td>
</tr>
<tr>
    <td><table width="100%">
        <tr>
            <td width="125px" valign="top"><br />
                <?php echo "<a href='$anasayfa' title='Ana Sayfa'>";?>Ana Sayfa</a><br />
                <a href="?sayfa=yazilar" title="Sadece Yazılar">Sadece Yazılar</a><br />
                <a href="?sayfa=dosyalar" title="Sadece Dosyalar">Sadece Dosyalar</a><br />
            <h5>Yeni</h5>
                <a href="?sayfa=yeniyazi" title="Yazı ekle">Yazı</a><br />
                <a href="?sayfa=yenidosya" title="Dosya ekle">Dosya</a><br />
            <h5>Kategoriler</h5>
                <a href="?kategori=bilimindogasi" title="Bilimin Doğası">Bilimin Doğası</a><br />
                <a href="?kategori=cevre" title="Çevre Bilimi">Çevre Bilimi</a><br />
                <a href="?kategori=fenlab" title="Fen Laboratuvarı">Fen Laboratuvarı</a><br />
                <a href="?kategori=genetik" title="Genetik">Genetik</a><br />
                <a href="?kategori=olcme" title="Ölçme Değerlendirme">Ölçme Değerlendirme</a><br />
                <a href="?kategori=ozelogretim" title="Özel Öğretim">Özel Öğretim</a><br />
                <a href="?kategori=toplum" title="Topluma Hizmet">Topluma Hizmet</a><br />
                <a href="?kategori=yer" title="Yer Bilimi">Yer Bilimi</a><br />
                <a href="?kategori=diger" title="Diğer">Diğer</a><br />
            </td>
            <td valign="top"><?php include "sayfa.php" ?></td>
        </tr>
    </table></td>
</tr>
<tr>
    <td style="text-align: center">Bu sitenin tüm içeriği CC by-nc-sa ile lisanslanmıştır. <b>Site test aşamasındadır.</b></td>
</tr>
</table>