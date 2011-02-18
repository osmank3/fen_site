<?php
function formgoster($hata = "") { echo '
<table style="width:270px; margin:7em auto;">
<tr><td colspan="2" ><p align="center">' . $hata . '</p></td></tr>
<form method="post">
<tr><td> İsim:</td><td><input type="text" name="isim" /></td></tr>
<tr><td> Soyisim:</td><td><input type="text" name="soyisim" /></td></tr>
<tr><td> E-posta:</td><td><input type="text" name="email" /></td></tr>
<tr><td><br /></td><td></td></tr>
<tr><td> Kullanıcı Adı:</td><td><input type="text" name="kullanici" /></td></tr>
<tr><td> Parola:</td><td><input type="password" name="parola" /></td></tr>
<tr><td> Parola(tekrar):</td><td><input type="password" name="parolatekrar" /></td></tr>
<tr><td></td><td align="right"><input type="submit" value="Kaydol" /></td></tr>
</form>
</table>';
}
function postaMetin($kod) {
$metin = "Fen Bilgisi sitesine üyeliğinizin gerçekleşmesi için aşağıdaki bağlantıya tıklayın

http://localhost/~osmank3/kaydol.php?kod=$kod

Bağlantıya tıklanamıyorsa tarayıcınızın adres çubuğuna yapıştırınız." ;
return $metin;
}
if($_GET)
{
    if($_GET["kod"])
    {
        $db = mysql_connect("localhost","fen","123321");
        if (!$db)
        {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db("fen", $db);
        $sorgu = "SELECT kullanici FROM kullanici";
        $sonuc = mysql_query($sorgu,$db);
        while ($satir = mysql_fetch_array($sonuc))
        {
            if($_GET["kod"] == md5($satir["kullanici"], $raw_output = null))
            {
                $sorgu = "UPDATE kullanici SET aktif='True'
                    WHERE kullanici = '$satir[kullanici]'";
                mysql_query($sorgu,$db);
                echo "<script> window.top.location = './'; </script>";
            }
        }
    }
}
elseif ($_POST)
{
    if (!$_POST["isim"]) {formgoster("isim girin");}
    elseif(!$_POST["soyisim"]) {formgoster("soyisim girin");}
    elseif(!$_POST["email"]) {formgoster("email girin");}
    elseif(!$_POST["kullanici"]) {formgoster("kullanıcı adı girin");}
    elseif(!$_POST["parola"]) {formgoster("parolanızı girin");}
    elseif(!$_POST["parolatekrar"]) {formgoster("parola tekrarını girin");}
    elseif($_POST["parola"] != $_POST["parolatekrar"]) {formgoster("parolalar uyuşmuyor");}
    else
    {
        $aktifKod = md5($_POST["kullanici"], $raw_output = null);
        echo $aktifKod;
        $parola = md5($_POST["parola"], $raw_output = null);
        $db = mysql_connect("localhost","fen","123321");
        if (!$db)
        {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db("fen", $db);
        $sorgu = "INSERT INTO kullanici(kullanici, isim, soyisim, posta, parola, aktif, yonaktif)
            VALUES
            ('$_POST[kullanici]', '$_POST[isim]', '$_POST[soyisim]', '$_POST[email]', '$parola', 'False', 'False')";
        mysql_query($sorgu,$db);
        
        $posta_metin = postaMetin($aktifKod);
                
        $mail = mail( $_POST["email"], "Subject: Fen bilgisi aktivasyon.",
        $posta_metin, "From: osmank3@gmail.com" );
        if ($mail)
        {
            echo "Fen Bilgisi sitesine üyeliğinizin tamamlanması için e-posta adresinize gönderilen aktivasyon bağlantısına tıklamanız gerekmektedir.";
            echo "<br /><a href='./'>Ana sayfa</a>";
        }
        else { echo "mail gönderilemiyi!"; }

    }
}
else
{ formgoster(); } ?> 