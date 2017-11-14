<?php
	include('phpqrcode/qrlib.php');


    if($_GET['id']==1){
    QRcode::png("https://yandex.ua/maps/?origin=jsapi&ll=".$_GET['y']."%2C".$_GET['x']."&z=16&whatshere%5Bpoint%5D=".$_GET['x']."%2C".$_GET['y']."&whatshere%5Bzoom%5D=16&mode=whatshere", false, "L", 5, 5);}
?>
