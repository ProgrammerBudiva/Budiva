<?php
	include('phpqrcode/qrlib.php');


    if($_GET['id']==1){
//    QRcode::png("https://yandex.ua/maps/?origin=jsapi&ll=".$_GET['y']."%2C".$_GET['x']."&z=16&whatshere%5Bpoint%5D=".$_GET['x']."%2C".$_GET['y']."&whatshere%5Bzoom%5D=16&mode=whatshere", false, "L", 5, 5);}

        switch ($_GET['y']){
            case 1:
                //Одесса
                QRcode::png("https://goo.gl/maps/8qpuMXREhEM2", false, "L", 5, 5);
                break;
            case 2:
                //Днепр
                QRcode::png("https://goo.gl/maps/iGyca9LQnpA2", false, "L", 5, 5);
                break;
            case 3:
                //Киев
                QRcode::png("https://goo.gl/maps/WhdBQHjgctQ2", false, "L", 5, 5);
                break;
            case 4:
                //Полтава
                QRcode::png("https://goo.gl/maps/v3XioCgzSe62", false, "L", 5, 5);
                break;
            case 5:
                //Херсон
                QRcode::png("https://goo.gl/maps/9JB88AxQf7v", false, "L", 5, 5);
                break;
            case 6:
                //Кривой Рог
                QRcode::png("https://goo.gl/maps/WhdBQHjgctQ2", false, "L", 5, 5);
                break;
            case 7:
                //Запорожье
                QRcode::png("https://goo.gl/maps/kYxpWet4RWN2", false, "L", 5, 5);
                break;
        }

    }
?>
