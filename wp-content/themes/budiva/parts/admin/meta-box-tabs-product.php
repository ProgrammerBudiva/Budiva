<ul class="tabs">
    <li data-target="#tab_price" class="current">Прайс</li>
    <li data-target="#tab_characteristics">Характеристики</li>
    <li data-target="#tab_sertificates">Сертификаты</li>
    <li data-target="#tab_instructions">Инструкции</li>
    <li data-target="#tab_video">Видео</li>

    <?php if( !empty( $customs ) && is_array( $customs ) ) : $i = 0; ?>
        <?php foreach( $customs as $custom ) : $i++; ?>
            <li data-target="#tab_custom_<?= $i; ?>"><?= $custom['name']; ?></li>
        <?php endforeach; ?>
    <?php endif; ?>

    <li class="add">+</li>
</ul>

<div class="tabs-content">

    <?php /* * * * * * PRICE * * * * * */ ?>

    <div id="tab_price" class="tab current">
        <ul class="sortable">
            <li>
                <div class="col50">
                    <h4>Выберите файл с прайсом</h4>

                    <div class="file_data" <?php if( !empty( $download_title ) )
                        echo " style='display:block;'"; ?>>
                        <input type="hidden" name="tabs[price][download]" value="<?= $prices['download_id']; ?>"/>
                        <img src="<?= $download_icon; ?>"/>

                        <p><?= $download_title; ?></p>
                    </div>
                    <button class="button upload_file_btn">Загрузить</button>
                </div>
                <?php /* <div class="col50">
                    <h4>Файл для просмотра</h4>

                    <div class="file_data" <?php if( !empty( $download_title ) )
                        echo " style='display:block;'"; ?>>
                        <input type="hidden" name="tabs[price][view]" value="<?= $prices['view_id']; ?>"/>
                        <img src="<?= $view_icon; ?>"/>

                        <p><?= $view_title; ?></p>
                    </div>
                    <button class="button upload_file_btn">Загрузить</button>
                </div> */ ?>
            </li>
        </ul>
    </div>

    <?php /* * * * * * PRICE * * * * * */ ?>

    <div id="tab_characteristics" class="tab">
        <p><label for="tab_characteristics_content"><b>Таблицы характеристик</b></label></p>

        <div class="custom_editor">
            <textarea name="tabs[characteristics][content]" id="tab_characteristics_content"><?= $charasteristics['content']; ?></textarea>
        </div>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                tinymce.init({
                    selector: '#tab_characteristics_content',
                    height: 300,
                    plugins: [
                        'advlist lists image charmap print hr anchor',
                        'searchreplace visualblocks visualchars code fullscreen',
                        'insertdatetime media nonbreaking table directionality',
                        'emoticons paste textcolor colorpicker'
                    ],
                    toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                    toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
                    image_advtab: true,
                });
            });
        </script>
    </div>

    <?php /* * * * * * VIDEO * * * * * */ ?>

    <div id="tab_video" class="tab">
        <ul class="sortable">
            <?php if( !empty( $videos ) && is_array( $videos ) ) : ?>
                <?php foreach( $videos as $video ) : ?>
                    <li>
                        <input type="hidden" name="tabs[video][id][]" value="<?= $video['id']; ?>">

                        <div class="col45">
                            <h4>Название</h4>
                            <input type="text" name="tabs[video][name][]" value="<?= $video['name']; ?>" maxlength="90" required/>
                        </div>
                        <div class="col45">
                            <h4>Ссылка на видео</h4>
                            <input type="text" name="tabs[video][link][]" value="<?= $video['link']; ?>" maxlength="120" required/>
                        </div>
                        <div class="col10">
                            <button class="button delete_file_btn">Удалить</button>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <button id="add_video" class="button button-primary button-large">Добавить ещё одно видео</button>
    </div>

    <?php /* * * * * * INSTRUCTIONS * * * * * */ ?>

    <div id="tab_instructions" class="tab">
        <ul class="sortable">
            <?php if( !empty( $instructions ) && is_array( $instructions ) ) : ?>
                <?php foreach( $instructions as $instruction ) : ?>
                    <li>
                        <input type="hidden" name="tabs[instructions][id][]" value="<?= $instruction['id']; ?>">

                        <div class="col45">
                            <h4>Файл для просмотра</h4>

                            <div class="file_data" <?php if( !empty( $instruction['file_id'] ) )
                                echo " style='display:block;'"; ?>>
                                <input type="hidden" name="tabs[instructions][file_id][]" value="<?= $instruction['file_id']; ?>"/>
                                <img src="<?= $instruction['icon']; ?>"/>

                                <p><?= $instruction['file_name']; ?></p>
                            </div>
                            <button class="button upload_file_btn">Загрузить</button>
                        </div>
                        <div class="col45">
                            <h4>Название</h4>
                            <input type="text" name="tabs[instructions][name][]" value="<?= $instruction['name']; ?>" maxlength="120" required/>
                        </div>
                        <div class="col10">
                            <button class="button delete_file_btn">Удалить</button>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <button id="add_instruction" class="button button-primary button-large">Добавить ещё одну инструкцию</button>
    </div>

    <?php /* * * * * * SERTIFICATES * * * * * */ ?>

    <div id="tab_sertificates" class="tab">
        <ul class="sortable">
            <?php if( !empty( $sertificates ) && is_array( $sertificates ) ) : ?>
                <?php foreach( $sertificates as $sertificate ) : ?>
                    <li>
                        <input type="hidden" name="tabs[sertificates][id][]" value="<?= $sertificate['id']; ?>">

                        <div class="col45">
                            <h4>Файл для просмотра</h4>

                            <div class="file_data" <?php if( !empty( $sertificate['file_id'] ) )
                                echo " style='display:block;'"; ?>>
                                <input type="hidden" name="tabs[sertificates][file_id][]" value="<?= $sertificate['file_id']; ?>"/>
                                <img class="full_img" src="<?= $sertificate['icon']; ?>"/>
                            </div>
                            <button class="button upload_file_btn">Загрузить</button>
                        </div>
                        <div class="col45">
                            <h4>Название</h4>
                            <input type="text" name="tabs[sertificates][name][]" value="<?= $sertificate['name']; ?>" maxlength="120" required/>
                        </div>
                        <div class="col10">
                            <button class="button delete_file_btn">Удалить</button>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <button id="add_sertificate" class="button button-primary button-large">Добавить ещё один сертификат</button>
    </div>

    <?php if( !empty( $customs ) && is_array( $customs ) ) : $i = 0; ?>
        <?php foreach( $customs as $custom ) : $i++; ?>
            <div id="tab_custom_<?= $i; ?>" class="tab custom-tab">
                <input type="hidden" name="tabs[custom][<?= $i; ?>][id]" value="<?= $custom['id']; ?>">

                <p><label for="tabs_custom_name_<?= $i; ?>"><b>Название вкладки</b></label></p>
                <input type="text" name="tabs[custom][<?= $i; ?>][name]" id="tabs_custom_name_<?= $i; ?>" value="<?= $custom['name']; ?>" maxlength="30" required/>

                <p><label for="tabs_custom_content_<?= $i; ?>"><b>Содержимое вкладки</b></label></p>

                <div class="custom_editor">
                    <textarea name="tabs[custom][<?= $i; ?>][content]" id="tabs_custom_content_<?= $i; ?>"><?= $custom['content']; ?></textarea>
                </div>
                <br>

                <button class="button button-primary button-large remove_tab">Удалить вкладку</button>

                <script type="text/javascript">
                    jQuery(document).ready(function($) {
                        tinymce.init({
                            selector: '#tabs_custom_content_<?= $i; ?>',
                            height: 300,
                            plugins: [
                                'advlist lists image charmap print hr anchor',
                                'searchreplace visualblocks visualchars code fullscreen',
                                'insertdatetime media nonbreaking table directionality',
                                'emoticons paste textcolor colorpicker'
                            ],
                            toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                            toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
                        });
                    });
                </script>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        var tab_container = $("#tabs"),
            custom_frame;

        tab_container.find("ul.tabs").on('click', 'li:not(.add)', function() {
            tab_container.find("div.tab").removeClass('current');
            tab_container.find("ul.tabs li").removeClass('current');
            $(this).addClass('current');
            $($(this).data('target')).addClass('current');
        });

        $("ul.sortable").sortable();

        <?php /* * * * * * CUSTOM TABS * * * * * */ ?>

        tab_container.find("ul.tabs").on('click', 'li.add', function() {
            var i = 1;
            while($(".tabs-content #tab_custom_" + i).length)
                i++;
            var id = 'tab_custom_' + i;

            $('<li data-target="#' + id + '">Новая вкладка</li>').insertBefore("ul.tabs li.add");

            $(".tabs-content").append('<div id="' + id + '" class="tab custom-tab"><input type="hidden" name="tabs[custom][' + i + '][id]" value="0"><p><label for="tabs_custom_name_' + i + '"><b>Название вкладки</b></label></p><input type="text" name="tabs[custom][' + i + '][name]" id="tabs_custom_name_' + i + '" value="Новая вкладка" maxlength="30" required/><p><label for="tabs_custom_content_' + i + '"><b>Содержимое вкладки</b></label></p><div class="custom_editor"><textarea name="tabs[custom][' + i + '][content]" id="tabs_custom_content_' + i + '"></textarea></div><br><button class="button button-primary button-large remove_tab">Удалить вкладку</button></div>');

            tinymce.init({
                selector: '#' + id + ' textarea',
                height: 300,
                plugins: [
                    'advlist lists image charmap print hr anchor',
                    'searchreplace visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking table directionality',
                    'emoticons paste textcolor colorpicker'
                ],
                toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
            });
        });

        tab_container.on('click', '.remove_tab', function() {
            var tab = $(this).parents('.tab');
            var id = tab.attr("id");
            $('ul.tabs').find("li[data-target='#" + id + "']").remove();
            tab.remove();
            tab_container.find("ul.tabs li").first().click();
            return false;
        });

        tab_container.on('input', '.custom-tab input[type="text"]', function() {
            var id = $(this).parents(".custom-tab").attr("id");
            tab_container.find(".tabs li[data-target='#" + id + "']").html($(this).val());
        });

        <?php /* * * * * * SERTIFICATES * * * * * */ ?>

        tab_container.on('click', '#add_sertificate', function(event) {
            event.preventDefault();
            tab_container.find("#tab_sertificates ul").append('<li><input type="hidden" name="tabs[sertificates][id][]" value="0"><div class="col45"><h4>Файл для просмотра</h4><div class="file_data"><input type="hidden" name="tabs[sertificates][file_id][]" value=""/><img src="" class="full_img"/></div><button class="button upload_file_btn">Загрузить</button></div><div class="col45"><h4>Название</h4><input type="text" name="tabs[sertificates][name][]" value="" maxlength="120" required/></div><div class="col10"><button class="button delete_file_btn">Удалить</button></div></li>');
            return false;
        });

        $('#tab_sertificates .sortable').on('click', '.delete_file_btn', function(event) {
            event.preventDefault();
            $(this).parent().parent().remove();
            return false;
        });

        $('#tab_sertificates .sortable').on('click', '.upload_file_btn', function(event) {
            event.preventDefault();

            var file_data = $(this).parent().find('.file_data');

            custom_frame = wp.media({
                title: 'Выберите файл',
                button: {
                    text: 'Готово'
                },
                multiple: false
            });

            custom_frame.on('select', function() {
                var attachment = custom_frame.state().get('selection').first().toJSON();
                var url = '';
                if(attachment['mime'] == 'application/pdf')
                    url = attachment['sizes']['thumbnail']['url'];
                else
                    url = attachment['url']
                file_data.css('display', 'block');
                file_data.find('img').attr('src', url);
                file_data.find('p').html(attachment['filename']);
                file_data.find('input').val(attachment['id']);
            });

            custom_frame.open();

            return false;
        });

        <?php /* * * * * * INSTRUCTIONS * * * * * */ ?>

        tab_container.on('click', '#add_instruction', function(event) {
            event.preventDefault();
            tab_container.find("#tab_instructions ul").append('<li><input type="hidden" name="tabs[instructions][id][]" value=""><div class="col45"><h4>Файл для просмотра</h4><div class="file_data"><input type="hidden" name="tabs[instructions][file_id][]" value=""/><img src=""/><p></p></div><button class="button upload_file_btn">Загрузить</button></div><div class="col45"><h4>Название</h4><input type="text" name="tabs[instructions][name][]" maxlength="120" value="" required/></div><div class="col10"><button class="button delete_file_btn">Удалить</button></div></li>');
            return false;
        });

        $('#tab_instructions .sortable').on('click', '.delete_file_btn', function(event) {
            event.preventDefault();
            $(this).parent().parent().remove();
            return false;
        });

        $('#tab_instructions .sortable').on('click', '.upload_file_btn', function(event) {
            event.preventDefault();

            var file_data = $(this).parent().find('.file_data');

            custom_frame = wp.media({
                title: 'Выберите файл',
                library: {
                    // .pdf, .txt, .xls, .xlsx
                    //type: ['application/pdf', 'text/plain', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
                    type: ['image', 'application/pdf', 'text/plain']
                },
                button: {
                    text: 'Готово'
                },
                multiple: false
            });

            custom_frame.on('select', function() {
                var attachment = custom_frame.state().get('selection').first().toJSON();
                file_data.css('display', 'block');
                file_data.find('img').attr('src', attachment['icon']);
                file_data.find('p').html(attachment['filename']);
                file_data.find('input').val(attachment['id']);
            });

            custom_frame.open();

            return false;
        });

        <?php /* * * * * * VIDEO * * * * * */ ?>

        tab_container.on('click', '#add_video', function(event) {
            event.preventDefault();
            tab_container.find("#tab_video ul").append('<li><input type="hidden" name="tabs[video][id][]" value="0"><div class="col45"><h4>Название</h4><input type="text" name="tabs[video][name][]" value="" maxlength="90" required /></div><div class="col45"><h4>Ссылка на видео</h4><input type="text" name="tabs[video][link][]" value="" maxlength="120" required /></div><div class="10"><button class="button delete_file_btn">Удалить</button></div></li>');
            return false;
        });

        $('#tab_video .sortable').on('click', '.delete_file_btn', function(event) {
            event.preventDefault();
            $(this).parent().parent().remove();
            return false;
        });

        <?php /* * * * * * PRICE * * * * * */ ?>

        /*tab_container.on('click', '#add_price', function(event) {
         event.preventDefault();
         tab_container.find("#tab_price ul").append('<li><div class="col45"><h4>Файл для скачивания</h4><div class="file_data"><input type="hidden" name="tabs[price][download][]" value=""/><img src=""/><p></p></div><button class="button upload_file_btn">Загрузить</button></div><div class="col45"><h4>Файл для просмотра</h4><div class="file_data"><input type="hidden" name="tabs[price][view][]" value=""/><img src=""/><p></p></div><button class="button upload_file_btn">Загрузить</button></div><div class="10"><button class="button delete_file_btn">Удалить</button></div></li>');
         return false;
         });*/

        $('#tab_price .sortable').on('click', '.delete_file_btn', function(event) {
            event.preventDefault();
            $(this).parent().parent().remove();
            return false;
        });

        $('#tab_price .sortable').on('click', '.upload_file_btn', function(event) {
            event.preventDefault();

            var file_data = $(this).parent().find('.file_data');

            custom_frame = wp.media({
                title: 'Выберите файл',
                library: {
                    // .pdf, .txt, .xls, .xlsx
                    type: ['application/pdf', 'text/plain', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
                },
                button: {
                    text: 'Готово'
                },
                multiple: false
            });

            custom_frame.on('select', function() {
                var attachment = custom_frame.state().get('selection').first().toJSON();
                file_data.css('display', 'block');
                file_data.find('img').attr('src', attachment['icon']);
                file_data.find('p').html(attachment['filename']);
                file_data.find('input').val(attachment['id']);
            });

            custom_frame.open();

            return false;
        });
    });
</script>
