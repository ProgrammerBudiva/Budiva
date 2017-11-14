(function() {
    tinymce.PluginManager.add('my_mce_button', function(editor, url) {
        editor.addButton('my_mce_button', {
            text: 'Дополнительно',
            icon: false,
            type: 'menubutton',
            menu: [
                {
                    text: 'Видео',
                    menu: [
                        {
                            text: 'Одно видео',
                            onclick: function() {
                                win = editor.windowManager.open({
                                    title: 'Insert one video',
                                    data: {},
                                    body: [
                                        {
                                            label: 'Video link',
                                            type: "textbox",
                                            name: 'video'
                                        }
                                    ],
                                    onSubmit: function(o) {
                                        var video = o.data.video;
                                        video = "//www.youtube.com/embed/" + video.substr((video.lastIndexOf("/") + 1));

                                        var default_height = "350px";
                                        var default_width = "100%";

                                        var code = '<iframe src="' + video + '" width="' + default_width + '" height="' + default_height + '" allowfullscreen="allowfullscreen"></iframe>';

                                        var content = "<div class='clearfix'>";
                                        content += "<div class='video-wrap-center'>" + code + "</div>";
                                        content += "</div>";

                                        editor.insertContent(content);
                                    }
                                });

                            },
                        },
                        {
                            text: 'Два рядом',
                            onclick: function() {
                                win = editor.windowManager.open({
                                    title: 'Insert two videos',
                                    data: {},
                                    body: [
                                        {
                                            label: 'First video link',
                                            type: "textbox",
                                            name: 'video1'
                                        },
                                        /*{
                                         type: 'container',
                                         label: 'Dimensions',
                                         layout: 'flex',
                                         align: 'center',
                                         spacing: 5,
                                         items: [
                                         {
                                         name: 'width1',
                                         type: 'textbox',
                                         maxLength: 5,
                                         size: 5,
                                         //onchange: recalcSize,
                                         ariaLabel: 'Width'
                                         },
                                         {
                                         type: 'label',
                                         text: 'x'
                                         },
                                         {
                                         name: 'height1',
                                         type: 'textbox',
                                         maxLength: 5,
                                         size: 5,
                                         //onchange: recalcSize,
                                         ariaLabel: 'Height'
                                         }
                                         ]
                                         },*/
                                        {
                                            label: 'First video link',
                                            type: "textbox",
                                            name: 'video2'
                                        },
                                        /*{
                                         type: 'container',
                                         label: 'Dimensions',
                                         layout: 'flex',
                                         align: 'center',
                                         spacing: 5,
                                         items: [
                                         {
                                         name: 'width2',
                                         type: 'textbox',
                                         maxLength: 5,
                                         size: 5,
                                         //onchange: recalcSize,
                                         ariaLabel: 'Width'
                                         },
                                         {
                                         type: 'label',
                                         text: 'x'
                                         },
                                         {
                                         name: 'height2',
                                         type: 'textbox',
                                         maxLength: 5,
                                         size: 5,
                                         //onchange: recalcSize,
                                         ariaLabel: 'Height'
                                         }
                                         ]
                                         }*/
                                    ],
                                    onSubmit: function(o) {
                                        var video1 = o.data.video1;
                                        video1 = "//www.youtube.com/embed/" + video1.substr((video1.lastIndexOf("/") + 1));
                                        var video2 = o.data.video2;
                                        video2 = "//www.youtube.com/embed/" + video2.substr((video2.lastIndexOf("/") + 1));

                                        var default_height = "350px";
                                        var default_width = "100%";

                                        /*var height1 = o.data.height1.length ? o.data.height1 : default_height;
                                         var height2 = o.data.height2.length ? o.data.height2 : default_height;
                                         var width1 = o.data.width1.length ? o.data.width1 : default_width;
                                         var width2 = o.data.width2.length ? o.data.width2 : default_width;*/

                                        var code1 = '<iframe src="' + video1 + '" width="' + default_width + '" height="' + default_height + '" allowfullscreen="allowfullscreen"></iframe>';
                                        var code2 = '<iframe src="' + video2 + '" width="' + default_width + '" height="' + default_height + '" allowfullscreen="allowfullscreen"></iframe>';

                                        var content = "<div class='clearfix'>";
                                        content += "<div class='video-wrap'>" + code1 + "</div>";
                                        content += "<div class='video-wrap-r'>" + code2 + "</div>";
                                        content += "</div>";

                                        editor.insertContent(content);
                                    }
                                });

                            },
                        }
                    ]
                }
                /*{
                 text: 'Заголовки',
                 menu: [
                 {
                 text: 'Новые проекты',
                 onclick: function() {
                 var selected = editor.selection.getContent();
                 if(!selected)
                 selected = "Новые проекты";
                 var content = "[post_header type='speaker']" + selected + "[/post_header]";
                 editor.insertContent(content);
                 }
                 },
                 {
                 text: 'Новости',
                 onclick: function() {
                 var selected = editor.selection.getContent();
                 if(!selected)
                 selected = "Новости";
                 var content = "[post_header type='graph']" + selected + "[/post_header]";
                 editor.insertContent(content);
                 }
                 },
                 {
                 text: 'Техническая часть',
                 onclick: function() {
                 var selected = editor.selection.getContent();
                 if(!selected)
                 selected = "Техническая часть";
                 var content = "[post_header type='tech']" + selected + "[/post_header]";
                 editor.insertContent(content);
                 }
                 },
                 {
                 text: 'Легенда',
                 onclick: function() {
                 var selected = editor.selection.getContent();
                 if(!selected)
                 selected = "Легенда";
                 var content = "[post_header type='legend']" + selected + "[/post_header]";
                 editor.insertContent(content);
                 }
                 },
                 {
                 text: 'Тарифные планы',
                 onclick: function() {
                 var selected = editor.selection.getContent();
                 if(!selected)
                 selected = "Тарифные планы";
                 var content = "[post_header type='tPlan']" + selected + "[/post_header]";
                 editor.insertContent(content);
                 }
                 },
                 {
                 text: 'Платежные системы',
                 onclick: function() {
                 var selected = editor.selection.getContent();
                 if(!selected)
                 selected = "Платежные системы";
                 var content = "[post_header type='payments-method']" + selected + "[/post_header]";
                 editor.insertContent(content);
                 }
                 },
                 {
                 text: 'Начисление прибыли',
                 onclick: function() {
                 var selected = editor.selection.getContent();
                 if(!selected)
                 selected = "Начисление прибыли";
                 var content = "[post_header type='profit']" + selected + "[/post_header]";
                 editor.insertContent(content);
                 }
                 },
                 {
                 text: 'Тип выплаты',
                 onclick: function() {
                 var selected = editor.selection.getContent();
                 if(!selected)
                 selected = "Тип выплаты";
                 var content = "[post_header type='payments-type']" + selected + "[/post_header]";
                 editor.insertContent(content);
                 }
                 },
                 {
                 text: 'Поддержка',
                 onclick: function() {
                 var selected = editor.selection.getContent();
                 if(!selected)
                 selected = "Поддержка";
                 var content = "[post_header type='supports']" + selected + "[/post_header]";
                 editor.insertContent(content);
                 }
                 },
                 {
                 text: 'Партнерская программа',
                 onclick: function() {
                 var selected = editor.selection.getContent();
                 if(!selected)
                 selected = "Партнерская программа";
                 var content = "[post_header type='partner-programm']" + selected + "[/post_header]";
                 editor.insertContent(content);
                 }
                 },
                 {
                 text: 'Регистрация',
                 onclick: function() {
                 var selected = editor.selection.getContent();
                 if(!selected)
                 selected = "Регистрация";
                 var content = "[post_header type='reg']" + selected + "[/post_header]";
                 editor.insertContent(content);
                 }
                 },
                 {
                 text: 'Личный кабинет',
                 onclick: function() {
                 var selected = editor.selection.getContent();
                 if(!selected)
                 selected = "Личный кабинет";
                 var content = "[post_header type='lc']" + selected + "[/post_header]";
                 editor.insertContent(content);
                 }
                 },
                 {
                 text: 'Последние скамы',
                 onclick: function() {
                 var selected = editor.selection.getContent();
                 if(!selected)
                 selected = "Последние скамы";
                 var content = "[post_header type='last-scam']" + selected + "[/post_header]";
                 editor.insertContent(content);
                 }
                 }
                 ]
                 },
                 {
                 text: 'Цитата',
                 menu: [
                 {
                 text: 'Голубой фон',
                 onclick: function() {
                 var selected = editor.selection.getContent();
                 var content = "[fi_quote color='blue' header='Наше мнение']" + selected + "[/fi_quote]";
                 editor.insertContent(content);
                 }
                 },
                 {
                 text: 'Бежевый фон',
                 onclick: function() {
                 var selected = editor.selection.getContent();
                 var content = "[fi_quote color='beige']" + selected + "[/fi_quote]";
                 editor.insertContent(content);
                 }
                 }
                 ]
                 }*/
            ]
        });
    });
})();