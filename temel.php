<table id="main">
<tr>
    <td>
        <table width="100%"><tr><td style="text-align: left">
            <?php echo "<a href='$anasayfa' title='Ana Sayfa'>";?>Ana Sayfa</a>
        </td>
        <td style="text-align: right">
            <?php echo $kullanici; ?>
            <!--<a href="#" title="Profil">Profil</a>-->
            <a href="?hesap=cıkıs" title="Çıkış">Çıkış</a>
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
            <h5>Kategoriler</h5>
                <!--<a href="#" title="xxx">xxx</a><br />
                <a href="#" title="xxx">xxx</a><br />-->
            </td>
            <td valign="top"><?php include "sayfa.php" ?></td>
        </tr>
    </table></td>
</tr>
<tr>
    <td style="text-align: center">Bu sitenin tüm içeriği CC by-nc-sa ile lisanslanmıştır. <b>Site test aşamasındadır.</b></td>
</tr>
</table>