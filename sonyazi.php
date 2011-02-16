<?php
if ($_POST)
    {
    print_r($_POST);
    echo "yazı kaydediliyor";
    }
else { ?>
<form method="post">
Başlık: <input size="55" type="text" name="konu"/>
<textarea id="comment" name="yazi" cols="60" rows="4" aria-required="true"></textarea><br />
Kategori: <select name="kategori">
    <option value="">Kategori Seçin</option>
    <option value="xxx1">xxx1</option>
    <option value="xxx2">xxx2</option>
    <option value="xxx3">xxx3</option> 
</select>
<input type="submit" value="Yazı Gönder" />
</form>
<?php }
echo "<br /> yazılar gösterilecek";
?>