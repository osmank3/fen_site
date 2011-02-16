<?php
if ($_POST)
    {
        $kullanici = $_POST["kullanici"];
        $parola = $_POST["parola"];
        echo $kullanici . $parola;
    }
else
    { 
?>
<table style="width:270px; margin:7em auto;">
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
</table>
<?php } ?> 