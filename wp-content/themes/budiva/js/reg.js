jQuery(document).ready(function($) {
    $('#login-submit').click(function(event) {
        var form = $(this).parents("#popup-login-form");
        var err_container = form.find(".error-login");

        if(event.preventDefault) {
            event.preventDefault();
        } else {
            event.returnValue = false;
        }

        err_container.hide();

        var data = {
            action: 'budiva_login_user',
            nonce: $('#budiva_login_nonce').val(),
            log: $('#user_login').val(),
            pwd: $('#user_pass').val(),
            rememberme: $('#rememberme').is(':checked')
        };

        $.post(reg_vars.ajax_url, data, function(response) {
            if(response) {
                response = JSON.parse(response);

                if(response.code == '1') {
                    location.reload();
                } else {
                    err_container.html(response.text);
                    err_container.show();
                }
            }
        });

        return false;
    });

    $('#register-submit').click(function(event) {
        var form = $(this).parents("#popup-register-form");
        var err_container = form.find(".error");

        if(event.preventDefault) {
            event.preventDefault();
        } else {
            event.returnValue = false;
        }

        err_container.hide();
        err_container.html("");
        form.find("#recover-link").remove();
        form.find(".block-recovery-pwd").remove();

        var reg_nonce = $('#budiva_new_user_nonce').val();
        var reg_user = $('#com_username').val();
        var reg_mail = $('#com_email').val();
        var reg_phone = $('#account_telephone').val();
        var recaptcha = $('#g-recaptcha-response').val();
        // var delivery = $('#receive_delivery').is(":checked");
        if($('#receive_delivery').is(":checked") == true){
            var delivery = $('#receive_delivery').val();
        }

        data = {
            action: 'budiva_register_user',
            nonce: reg_nonce,
            user: reg_user,
            mail: reg_mail,
            phone: reg_phone,
            recaptcha: recaptcha,
            delivery: delivery
        };

        $.post(reg_vars.ajax_url, data, function(response) {
            grecaptcha.reset();
            if(response) {
                response = JSON.parse(response);

                if(response.code == '1') {
                    err_container.css("color", "green");

                    $('#com_username').val('');
                    $('#com_email').val('');
                    $('#account_telephone').val('');

                    var par = form.parent();
                    par.find("div, form").remove();
                    par.addClass('response-css')
                    par.append('<div class="wpcf7-response-output wpcf7-mail-sent-ok"></div>');
                    par.find("div").append(response.text);
                } else {
                    err_container.html(response.text);
                    err_container.show();
                }
                if(response.code == '2') {
                    //form.find('.fbtn').append($("#recover-link").clone());
                    form.find('.fbtn').after($(".block-recovery-pwd").clone());
                }

                //err_container.html(response.text);
                //err_container.show();
            }
        });
        return false;
    });

    $("#popup-register-form").on('submit', function() {
        return false;
    });
});