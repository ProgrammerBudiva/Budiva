<?php

class Mail
{
    public static function add_top_and_bottom( $args ) {
        $message = "<!doctype html>
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<title></title><style>@media screen and (max-width:600px) {
    .hide {
        display:none;
    }
}</style></head><body><div class='budiva-message' style='font-family: OpenSans, sans-serif;'>";
        $message .= self::get_email_logo( true );
        $message .= "<div class='budiva-message-content' style='margin: 30px 0 30px 10px;'>";
        $message .= $args["message"];
        $message .= "</div>\r\n";
        $message .= self::get_email_sign( true );
        $message .= "</div>\r\n";
        $args["message"] = $message;
        return $args;
    }

    public static function get_email_logo( $html_type = false ) {
        $logo = "<img src='" . get_template_directory_uri() . "/img/logo_email.png'>";

        return $html_type ? nl2br( $logo ) : $logo;
    }

    public static function get_email_sign( $html_type = false ) {
        ob_start();
        get_template_part( "parts/mail/footer" );
        $sign = ob_get_contents();
        ob_end_clean();
        return $sign;
    }
}