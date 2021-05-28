<?php
// Настройка почты
$mailmode='smtp';//Способ отправки. Варианты '' - не отправлять, 'smtp', 'sendmail'
$hostsmtp= "smtp.yandex.ru";//Хост smtp "smtp.google.com"
$SMTPdebug=0; //Режим отладки выключен 0. Включен 2
$SMTPAuth=true; //Нужно авторизироваться перед отправкой почты
$CharSet = 'UTF-8';//Кодировка писем
$SMTPSecure = "ssl";//Префикс соединения. Для яндекса или гугла оставьте как есть.
$Port       = 465;//Порт. Для яндекса или гугла оставьте как есть. 
$Username   = "mail@mbis.su";  // Логин на почту
$Password   = "";            // Пароль на почту 
$From='';// Исходящий ящик
$FromName='';//Имя исходящего ящика
$AddReplyTo=$Username;
$AddReplyToname=$FromName;

//////////////////
?>
