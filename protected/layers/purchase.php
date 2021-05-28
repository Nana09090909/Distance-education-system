<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="http://releases.flowplayer.org/5.1.1/flowplayer.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://releases.flowplayer.org/5.1.1/skin/minimalist.css" />
    <script src="js/lib.js"></script>
     <script src="js.js"></script>
    <link type="text/css"  rel="stylesheet" href="css/administration.css"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Администрирование дистанционной системы МБС ЕХБ</title>
</head>
    <body>
        <div id="response" ondblclick="location.reload();"> </div>
        <a href="index.php">В начало</a>
        <h2>Администрирование дистанционной системы МБС ЕХБ </h2>
        <div style="margin-left:50px; margin-top:20px">
            <div class="menu"> 
                <a href="index.php?r=administration/courses">Курсы</a>
                    <a href="index.php?r=administration/users">Пользователи</a>
                    <a href="index.php?r=administration/assignments">Задания</a>
                    <a href="index.php?r=administration/payment">Оплата</a>
                    <a href="index.php?r=administration/feedback">Вопросы пользователей</a>
                    <a href="index.php?r=library">Библиотека</a>
                      <button onclick="$.ajax('index.php?r=administration/cleancache')">Очистить кеш</button>
            </div>
            
        </div>
        
        <div class="message">
        <? echo $message;?>
        </div>
    </body>
</html>