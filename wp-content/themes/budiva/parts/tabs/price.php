<?php
/**
 * @var $url string
 * @var $prices array
 */
?>

<a href="<?= $url; ?>" class="tab-price-btn view" target="_blank">Просмотреть прайс</a>
<a href="<?= $url; ?>" class="tab-price-btn download" download>Скачать прайс</a>
<?php /* <a href="#" class="tab-price-btn send">Переслать на почту</a> */ ?>
<!--<a href="#" class="tab-price-btn print">Распечатать</a>-->

<script>
    $(document).ready(function() {
        $("#tab_price").on('click', '.print', function() {
            window.open("<?= $url; ?>").print();
            return false;
        });
    });
</script>