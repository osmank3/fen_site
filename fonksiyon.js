//javascript fonksiyonlarının bulunduğu dosyadır.
function bilg_gor()
{
    var acma = document.getElementById('bilg_acma');
    var sade = document.getElementById('bilg_sade');
    
    if (document.bildir.bilg_check1.checked == true) acma.style.display='block';
    else acma.style.display='none';
    
    if (document.bildir.bilg_rad2s.checked == true)
    {
        if (document.bildir.bilg_check1.checked == true) sade.style.display='block';
    }
    else sade.style.display='none';
}

function takip(stat, id, k_id)
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open("POST","icerik.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    
    if (stat == 0)
    {//takibi bırakma
        xmlhttp.send("formbicimi=takip&durum=takipetme&i_id="+id+"&k_id="+k_id);
        document.getElementById('takip'+id).innerHTML = "<button class='yuvar r5' onClick='takip(1,"+id+","+k_id+")'>Takip Et</button>";
    }
    else if (stat == 1)
    {//takibe alma
        xmlhttp.send("formbicimi=takip&durum=takipet&i_id="+id+"&k_id="+k_id);
        document.getElementById('takip'+id).innerHTML = "<button class='yuvar r5' onClick='takip(0,"+id+","+k_id+")'>Takip Etme</button>";
    }
}