<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Fen Bilgisi</title>
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8">
<meta http-equiv="content-style-type" content="text/css">
<link href="index.css" rel="stylesheet" type="text/css">
</head>
<body>
<table id="main">
<tr>
    <td>
        <table width="100%"><tr><td style="text-align: left">
            <?php echo "<a href='$anasayfa' title='Ana Sayfa'>";?>Ana Sayfa</a>
        </td>
        <td style="text-align: right">
            <?php echo $kullanici; ?>
            <a href="#" title="Profil">Profil</a>
            <a href="?oturum=kapat" title="Çıkış">Çıkış</a>
        </td></tr></table>
    </td>
</tr>
<tr>
    <td><img src="xxx.png" width="100%" height="150px" alt="" /></td>
</tr>
<tr>
    <td><table width="100%">
        <tr>
            <td width="95px" valign="top"><br />
                <?php echo "<a href='$anasayfa' title='Ana Sayfa'>";?>Ana Sayfa</a><br />
                <a href="?sayfa=sonyazilar" title="Son Yazılar">Son Yazılar</a><br />
                <a href="?sayfa=sondosyalar" title="Son Dosyalar">Son Dosyalar</a><br />
            <h5>Kategoriler</h5>
                <a href="#" title="xxx">xxx</a><br />
                <a href="#" title="xxx">xxx</a><br />
            </td>
            <td valign="top"><?php include "sayfa.php" ?></td>
        </tr>
    </table></td>
</tr>
<tr>
    <td style="text-align: center">Bu sitenin tüm içeriği CC by-nc-sa ile lisanslanmıştır.</td>
</tr>
</table>
</body>