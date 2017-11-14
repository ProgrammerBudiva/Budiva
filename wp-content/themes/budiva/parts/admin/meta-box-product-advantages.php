<div class="product-advantages">
    <input type="hidden" name="product-advantages" value="1"/>
    <?php foreach( $values as $key => $value ) : ?>
        <h3><?= $value['h3']; ?></h3>
        <p>
            <label for="adv-<?= $key; ?>-title">Заголовок</label>
            <input type="text" name="adv-<?= $key; ?>-title" id="adv-<?= $key; ?>-title" value="<?= $value['title']; ?>" placeholder=""/>
        </p>
        <p>
            <label for="adv-<?= $key; ?>-desc">Текст</label>
            <textarea name="adv-<?= $key; ?>-desc" id="adv-<?= $key; ?>-desc" placeholder=""><?= $value['desc']; ?></textarea>
        </p>
        <div>
            <img data-src="<?= $default_img; ?>" src="<?= $value['img']; ?>" width="115px" height="90px" />
            <div>
                <input type="hidden" name="adv-<?= $key; ?>-img" id="adv-<?= $key; ?>-img" value="<?= $value['img_id']; ?>" />
                <button type="submit" class="upload_image_button button">Загрузить</button>
                <button type="submit" class="remove_image_button button">&times;</button>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script type="text/javascript">
    jQuery(function($) {
        /*
         * действие при нажатии на кнопку загрузки изображения
         * вы также можете привязать это действие к клику по самому изображению
         */
        $('.upload_image_button').click(function() {
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(this);
            wp.media.editor.send.attachment = function(props, attachment) {
                $(button).parent().prev().attr('src', attachment.url);
                $(button).prev().val(attachment.id);
                wp.media.editor.send.attachment = send_attachment_bkp;
            }
            wp.media.editor.open(button);
            return false;
        });
        /*
         * удаляем значение произвольного поля
         * если быть точным, то мы просто удаляем value у input type="hidden"
         */
        $('.remove_image_button').click(function() {
            var r = confirm("Уверены?");
            if(r == true) {
                var src = $(this).parent().prev().attr('data-src');
                $(this).parent().prev().attr('src', src);
                $(this).prev().prev().val('');
            }
            return false;
        });
    });
</script>