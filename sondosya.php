<?php
if ($_POST)
    {
    print_r($_POST);
    echo "dosya yüklendi";
    }
else {
?>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    Özet: <input type="text" name="ozet" />
    <input type="file" name="dosya" id="dosya" /><br />
    Kategori: <select name="kategori">
        <option value="">Kategori Seçin</option>
        <option value="xxx1">xxx1</option>
        <option value="xxx2">xxx2</option>
        <option value="xxx3">xxx3</option>
    </select>
    <input type="submit" value="Dosyayı Gönder" />
</form>
<?php }
//buraya son eklenen üstte olacak şekilde tüm dosyalar listelenecek
echo "<br />dosyalar gösterilecek";
?>