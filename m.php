<?php

$to = 'sergpost3@mail.ru';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: all123235@budfiva.ua';/* . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();*/

mail( $to, $subject, $message, $headers );

echo '111';