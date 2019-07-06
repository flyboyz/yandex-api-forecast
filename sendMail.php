<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';

$mail = new PHPMailer;
$mail->isSMTP();

$mail->Host = 'sm-marketing.pro';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'info@sm-marketing.pro';
$mail->Password = 'Mg6QIEvoft1pXoCz';

$mail->setFrom('info@sm-marketing.pro', 'SM Marketing');
$mail->addAddress('muctep@bk.ru');

$name = $_POST['name'] ?? '<i>пусто</i>';
$email = $_POST['email'] ?? '<i>пусто</i>';
$message = $_POST['message'] ?? '<i>пусто</i>';

$body = "<h2>Новая заявка с сайта</h2>";
$body .= "<p>Имя: $name</p>";
$body .= "<p>Email: $email</p>";
$body .= "<p>Сообщение: $message</p>";

$mail->Subject = 'Пришла заявка!';
$mail->msgHTML($body);

echo $mail->send() === true ? '1' : $mail->ErrorInfo;
