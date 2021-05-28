<?php

class restorepass{
    public function index(){
         echo "Восстановление забытого пароля";
        return array('layer'=>'restorepass'); 
    }
    public function setnew(){
        if(!isset($_GET['key'])){ return array('view'=>'administration/error', 'error'=>'Не верное обращение к данной странице');}   
    $user=new user('',$_GET['key']);

    if($user->unregistered){   
        return array('layer'=>'restorepass', 'view'=>'administration/index', 'text'=>'Вы перешли по неверной ссылке!'); 
        
    }
        
        return array('layer'=>'restorepass', 'key'=>$_GET['key']); 
        
        
    }
    public function setnewpass(){
        if(!isset($_POST['data'])){ return array('view'=>'administration/error', 'error'=>'Восстановить пароль не удалось!');}   
        if(!isset($_GET['key'])){ return array('view'=>'administration/error', 'error'=>'Это какое-то жульничество.');}   
    $user=new user('',$_GET['key']);

    if($user->unregistered){   
        return array( 'view'=>'administration/index', 'text'=>'Страница устарела!<br/><button onclick="location.replace(\'index.php?r=restorepass\')">OK</button>');         
    }else{
        $user->password=md5(trim($_POST['data']));
        $user->key='';
if($user->renew()){
    $mainpage=MAINPAGE;
        $mainpageshort=  'МБС ЕХБ';
        
    $message=<<<a
Здравствуйте, {$user->name} {$user->fname}!<br/>
 Ваш пароль на сайте ДО МБС ЕХБ был успешно изменен.<br/>
 Ваш новый пароль: {$_POST['data']}.<br/>
 С уважением <br/>
 Команда <a href="https://mbs.ru/mbis"> $mainpageshort</a> <br/>
a;
        mailer::send($user->email, "Восстановление пароля на сайте ДО МБС ЕХБ ", $message);
    
    return array( 'view'=>'administration/index', 'text'=>'Пароль был успешно изменен');         
    
    
}        
        
    }
    
    
    }
    public function sendmail(){
        if(!isset($_POST['data'])){ return array('view'=>'administration/error', 'error'=>'Восстановить пароль не удалось!');}   
        $user=new user($_POST['data']);
        if($user->unregistered){
            return array('view'=>'administration/index', 'text'=>'Данный адрес не зарегистрирован. Зарегистрируйтесь на главной странице сайта!');
        
        }
        $key=$user->setnewkey();
        $mainpage=MAINPAGE;
        $message=<<<a
Здравствуйте, {$user->name} {$user->fname}!<br/>
 Для вашего адреса электронной почты был послан запрос на восстановление пароля на сайте дистанционных курсов МБС ЕХБ. Чтобы восстановить пароль проследуйте по ссылке 
 $mainpage/index.php?r=restorepass/setnew&key=$key .<br/>
 С уважением <br/>
 Секретарь МБС ЕХБ. <br/>
a;
        mailer::send($user->email, "Восстановление пароля на сайте дистанционных курсов ", $message);
        return array('view'=>'administration/index', 'text'=>'Для восстановления пароля перейдите по ссылке, указанной в письме, высланном на ваш адрес. Если письмо не пришло, возможно, посмотрите в папку Спама (некоторые провайдеры не доверяют автоматическим письмам со ссылками).');
        
    }
    
    
}
?>