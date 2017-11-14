<div class="underhead-img">
    <img data-src="<?= $default_img; ?>" src="<?= $img; ?>" style="max-width: 100%; height: auto;"/>

    <div>
        <input type="hidden" name="underhead" id="underhead" value="<?= $img_id; ?>"/>
        <button type="submit" class="upload_image_button button">Загрузить</button>
        <button type="submit" class="remove_image_button button">&times;</button>
    </div>
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