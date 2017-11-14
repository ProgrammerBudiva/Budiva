<div class="underhead-img" id="gallery_form">
    <ul class="imgContainer clearfix">
        <?php foreach( $img as $i ) : ?>
            <li style="float:left;" data-id="<?= $i['id']; ?>">
                <img src="<?= $i['src']; ?>" alt="" style="width:115px; height:90px;"/>
                <button style="left:-30px; position:relative;" class="remove_image_button_custom button">&times;</button>
            </li>
        <?php endforeach; ?>
    </ul>

    <div>
        <input type="hidden" name="gallery_images" id="gallery_images" value="<?= $img_id; ?>"/>
        <input type="hidden" name="gallery_images_add" id="gallery_images_add" value=""/>
        <button class="upload_image_button_custom button">Загрузить</button>
    </div>
</div>

<script type="text/javascript">
    jQuery(function($) {
        var frame,
            cont = $('#gallery_form'),
            addLink_custom = cont.find('.upload_image_button_custom'),
            delLink_custom = cont.find('.remove_image_button_custom'),
            imgContainer_custom = cont.find('.imgContainer'),
            input_custom = cont.find('#gallery_images');

        addLink_custom.on('click', function(event) {
            event.preventDefault();

            if(frame) {
                frame.open();
                return;
            }

            frame = wp.media({
                title: 'Выберите изображения для галереи',
                button: {
                    text: 'Готово'
                },
                multiple: true
            });

            frame.on('open', function() {
                var values = JSON.parse(input_custom.val());

                if(!Array.isArray(values) || !values.length)
                    values = [];

                var selection = frame.state().get('selection');

                $.each(values, function(i, val) {
                    var attachment = wp.media.attachment(val);
                    attachment.fetch();
                    selection.add(attachment ? [attachment] : []);
                });
            });

            frame.on('select', function() {

                var attachments = frame.state().get('selection').toJSON();

                var values = JSON.parse(input_custom.val());
                if(!Array.isArray(values) || !values.length)
                    values = [];

                $.each(attachments, function(i, val) {
                    if(values.indexOf(val.id) == -1) {
                        imgContainer_custom.append('<li style="float:left;" data-id="' + val.id + '"><img src="' + val.url + '" alt="" style="width:115px; height:90px;"/><button style="left:-30px; position:relative;" class="remove_image_button_custom button">&times;</button></li>');
                        values.push(val.id);
                    }
                });

                input_custom.val(JSON.stringify(values));
            });

            frame.open();
        });

        cont.on('click', '.remove_image_button_custom', function() {
            event.preventDefault();

            var li = $(this).parent(),
                id = li.data("id");

            var values = JSON.parse(input_custom.val());
            if(!Array.isArray(values) || !values.length)
                values = [];
            values.splice(values.indexOf(id), 1);
            input_custom.val(JSON.stringify(values));

            li.remove();
        });
    });
</script>