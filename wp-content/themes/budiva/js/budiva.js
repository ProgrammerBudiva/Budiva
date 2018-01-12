(function($) {
    Budiva = {
        init: function() {
            this.loginRegisterPopup.init();
            this.links.toggle._false();
            this.vacancies.init();
            this.ajax.init();
            this.print.init();
            this.forms.init();
            this.tabs.init();
            this.tiles.init();
        },
        tiles: {
            init: function() {
                if($('body').hasClass('tax-product_cat') && ($(window).width() < 581))
                    this.resize();
            },
            resize: function() {
                $('.tile img').each(function() {
                    $this = $(this);
                    $this.attr('src', $this.data('small'));
                    $this.attr('srcset', '');
                });
            }
        },
        forms: {
            init: function() {
                $("input[name=your-phone], input[name=tel-167]").val(reg_vars.phone);
                $("input[name=your-name]").val(reg_vars.name);
                $("input[name=your-email]").val(reg_vars.email);
            }
        },
        print: {
            init: function() {
                $('.print-map').click(function() {
                    var num = $("#google_map").data('map');
                    var marker = map_markers[num][0];

                    var lat = parseFloat(marker['lat']);
                    var lng = parseFloat(marker['lng']);
                    var zoom = 17;

                    var url = "https://maps.googleapis.com/maps/api/staticmap?";
                    url += "center=" + lat + "," + lng + "&zoom=" + zoom;
                    url += "&size=1000x400&scale=2&region=UA&key=AIzaSyD40OPh0-uq1PXrYjUzkQvZAAmmqB-5jUc";
                    url += "&markers=icon:" + reg_vars.theme_uri + "/img/map-label-small.png|" + parseFloat(marker.lat) + "," + parseFloat(marker.lng);

                    $("#google_map_print").attr('src', url);

                    $(".map-print").removeClass('active');
                    $(".map-print-" + num).addClass('active');

                    window.setTimeout(Budiva.print.pageCleaner, 600);

                    return false;
                });
            },
            pageCleaner: function() {
                window.print();
            }
        },
        ajax: {
            init: function() {
                $('#bad-link').on('click', function() {
                    var data = {
                        action: 'gen_bad_link',
                        nonce: $('#budiva_bad_link_nonce').val(),
                        link: window.location.href,
                    };
                    var response = function(resp) {
                        if(resp) {
                            $('#badLink').modal();
                        }
                    };
                    Budiva.ajax.send(data, response);
                });
            },
            send: function($data, $response) {
                $.post(reg_vars.ajax_url, $data, $response);
            }
        },
        loginRegisterPopup: {
            init: function() {
                if($("*").is(".login-register-form")) {
                    $(".login-register-form .tab").click(function() {
                        Budiva.loginRegisterPopup.tab.click($(this));
                        var formId = $(this).data('form');
                        if(formId == "popup-register-form")
                            $("#popup-register-form").find('input')[0].focus();
                        return false;
                    });
                }
                if($("#recover-link").length) {
                    $("body").on('click', '#recover-link', function() {
                        $('.block-recovery-pwd').slideToggle('slow');
                        return false;
                    });
                }
                if($('#lostpwd-submit').length) {
                    $('body').on('click', '#lostpwd-submit',  function() {
                        var err_container = $(this).parents('.block-recovery-pwd').find('.error');
                        err_container.hide();
                        var data = {
                            action: 'lost_pwd',
                            nonce: $('#budiva_lost_pwd_nonce').val(),
                            // email: $('#lostpwd_email').val(),
                            email: $(this).parent().parent().find('#lostpwd_email').val(),
                        };
                        var response = function(resp) {
                            resp = JSON.parse(resp);
                            console.log(resp);
                            if(resp) {
                                if(resp.code == '1')
                                    err_container.css("color", "green");
                                err_container.html(resp.text);
                                err_container.show();
                            }
                        };
                        console.log(data);
                        Budiva.ajax.send(data, response);
                        return false;
                    })
                }
            },
            tab: {
                click: function($this) {
                    if(!this.isActive($this))
                        this.clickAction($this);
                },
                isActive: function($this) {
                    return ($this.hasClass('tab-active'));
                },
                clickAction: function($this) {
                    $(".login-register-form .tab").removeClass('tab-active');
                    $this.addClass('tab-active');
                    $(".login-register-form form").css('display', 'none');
                    var $class = $this.data('form');
                    $('#' + $class).css('display', 'block');
                }
            }
        },
        links: {
            toggle: {
                _false: function() {
                    $('.look-vacancy').click(function() {
                        var t = $(this).data('target');
                        $('.vacancies-wrap [data-toggle="collapse"]:not(.collapsed)').each(function() {
                            if(t != $(this).data('target'))
                                $($(this).data('target')).collapse('toggle');
                        });
                        $(t).collapse('toggle');
                        return false;
                    });
                }
            }
        },
        vacancies: {
            init: function() {
                $('.vacancy .send-resume a').click(function() {
                    $("#vacancy-name").val($(this).data('vacancy'));
                });
            },
            send: function() {

            }
        },
        tabs: {
            init: function() {
                $(".product-tabs").on('click', 'li:not(.active)', function() {
                    $(".product-tabs").find('li').removeClass('active');
                    $(".product-tab-content").find(".product-tab").removeClass('active');
                    $(this).addClass('active');
                    var target = $($(this).data('target'));
                    if(!target.html().trim().length) {
                        target.parent().find(".tab-loader").removeClass('hide');
                        var type = target.data('type');
                        var product_id = target.parent().data('product');
                        var post_type = target.parent().data('type');
                        var custom_id = ((type == 'custom') ? target.data('id') : false);
                        var data = {
                            action: 'get_tab',
                            type: type,
                            custom_id: custom_id,
                            product_id: product_id,
                            post_type: post_type
                        };
                        var response = function(resp) {
                            target.html(resp);
                            $("a[data-rel^='prettyPhoto']").prettyPhoto({
                                hook: 'data-rel',
                                social_tools: false,
                                theme: 'pp_woocommerce',
                                horizontal_padding: 20,
                                opacity: 0.8,
                                deeplinking: false
                            });
                            target.parent().find(".tab-loader").addClass('hide');
                        };
                        Budiva.ajax.send(data, response);
                    }
                    target.addClass('active');
                });
            }
        }
    };


    $(document).ready(function() {
        Budiva.init();
    });

    $(document).ready(function() {
        $(window).on('resize', function() {
            $(".chosen-container").each(function() {
                $(this).attr('style', 'width: 100%');
            });
        });

        $('.toogle-filter').on('click', function(e) {
            var $this = $(this);

            e.preventDefault();

            $this.toggleClass('visible-filter').next('.wrapper').slideToggle(function() {
                if($(this).is(':visible')) {
                    $this.text('Скрыть фильтр');
                } else {
                    $this.text('Открыть фильтр');
                }
            });
        });

        $('#search').focus(function() {
            this.value = '';
        });

        $(".mobile-search-toggle").click(function() {
            $(".mobile-header .mobile-search").toggle('medium');
        });
    });
})(jQuery);

/**
 * Contact Form 7
 *
 * Подписка на новости
 *
 * Overide functions
 */
(function($) {
    $.fn.original_wpcf7NotValidTip = $.fn.wpcf7NotValidTip;

    $.fn.wpcf7NotValidTip = function(message) {
        if(!$(this).closest('.footer').length) {
            return this.original_wpcf7NotValidTip(message);
        }

        return this.each(function() {
            var $into = $(this);

            $into.closest('form').find('span.wpcf7-not-valid-tip').remove();
            $into.closest('form').find('.wpcf7-response-output').before('<span role="alert" class="wpcf7-not-valid-tip">' + message + '</span>');

            if($into.is('.use-floating-validation-tip *')) {
                $('.wpcf7-not-valid-tip', $into).mouseover(function() {
                    $(this).wpcf7FadeOut();
                });

                $(':input', $into).focus(function() {
                    $('.wpcf7-not-valid-tip', $into).not(':hidden').wpcf7FadeOut();
                });
            }
        });
    };
})(jQuery);

$('#1click').click(function(){
    console.log('123');
     $('.product-title form ').toggle();
    $("input[name='tel-167']").focus();
});

//Contact form 7 DOM events
document.addEventListener( 'wpcf7mailsent', function( event ) {
    if ( '2200' == event.detail.contactFormId ) {
        $('.product-title form ').hide();
        $('#1click').append('<div class="mini-popup-1click"><p>Ваша заявка отправлена!</p></div>')
        setTimeout(function(){$('.mini-popup-1click').fadeOut('fast')},5000);

        ga('send', 'event', 'Buy', '1click');

    }else if ('343' == event.detail.contactFormId){
        ga('send', 'event', 'Subscribe', 'footer');
    }else if ('124' == event.detail.contactFormId){
        ga('send', 'event', 'CallMe', 'header');
    }else if ('125' == event.detail.contactFormId){
        ga('send', 'event', 'CallMe', '404');
    }else if ('1086' == event.detail.contactFormId){
        ga('send', 'event', 'GetAnswer', 'click');
    }else if ('197' == event.detail.contactFormId){
        ga('send', 'event', 'BecomeProvider', 'click');
    }else if ('198' == event.detail.contactFormId){
        ga('send', 'event', 'GetPrice', 'click');
    }else if ('196' == event.detail.contactFormId){
        ga('send', 'event', 'GetJob', 'click');
    }else if ('228' == event.detail.contactFormId){
        ga('send', 'event', 'Buy', 'order');
    }


}, false );

$('#tab_price .view').click(function(){
    ga('send', 'event', 'Price', 'view');
});
$('#tab_price .download').click(function(){
    ga('send', 'event', 'Price', 'download');
});
$('#tab_price .print').click(function(){
    ga('send', 'event', 'Price', 'print');
});