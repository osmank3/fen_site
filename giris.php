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
<tr><td> Kullanıcı Adı:</td><td><input type="text" name="kullanici" /></td></tr>
<tr><td> Parola:</td><td><input type="password" name="parola" /></td></tr>
<tr><td><a href="kaydol.php" >Kaydol</a></td><td align="right">
<input type="submit" value="Giriş" /></td></tr>
</form>
</table>
<?php } ?> 
