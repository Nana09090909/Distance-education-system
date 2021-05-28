<?php
class register{
    public function editprofile(){
        echo<<<a
   <div id="studentcard">
       <div id="progress"></div>
 <div style="background-color:#FFEEFF; color:black; text-align: left;display:block; position:absolute;  float:left; padding:20px; z-index:50;    ">

     <span style="float:right;margin:15px; color:red; cursor:pointer" onclick="$('#personalbar').show();$(this).parent().remove()">X</span>
     <table><tr><td>
     <h3 style="text-align:center">УЧЕТНАЯ КАРТОЧКА СТУДЕНТА</h3>
     <p><button onclick="updateaccount()">Сохранить изменения</button></p>
 Фамилия <br/><input type="text" id="lname" size="60" value="{$_SESSION['lname']}"/><br/>
Имя <br/><input type="text" size="60" id="name" value="{$_SESSION['name']}"/><br/>
Отчество<br/><input type="text" size="60" id="fname" value="{$_SESSION['fname']}"/><br/>
Адрес <br/><textarea  id="address" style="width: 400px; height:250px;">{$_SESSION['address']}</textarea><br/></td><td>
Контактный телефон<br/><input id="phone" type="text" size="60" value="{$_SESSION['phone']}"/><br/>
Скайп<br/>        <input type="text" id="skype" size="60" value="{$_SESSION['skype']}"/><br/>
Дополнительная информация <br/><textarea id="info" style="width: 400px; height:250px;">{$_SESSION['info']}</textarea><br/>
    Email: <input type="text" onfocus="$(this).next().show()" id='email' size="40" value="{$_SESSION['email']}"/><div style="display:none"> Секретный код для смены email: <br/><input type="text" id='skey' size="20" /> <button onclick=" getsecretcode()">Получить секретный код</button></div>
<p>
       <br/> Пароль: отавьте пустым, чтобы не менять<br/>
        <input id="password" type="text"/>
   </p>    </td></tr> 
        </table>
        </div>
        </div>
        <script>$('#studentcard').draggable();</script>
        
a;
        
    }
    public function putmoney(){
     echo<<<a
   <div id="putmoney">

        </div>
        

<script>
function putmoney(place,data){
var where=arguments[2]?arguments[2]:'#content';
$(where).html('<img src="images/progress.gif"/>');
$.ajax({type: 'POST', url:'index.php?r=classroom/'+place, data:'data='+encodeURIComponent(data), success: function (e){
    $(where).html(e);    
    }});

}
</script>
a;
            
        
        
    }
    
    
       public function prereg(){
 $re="/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/";
        if(!isset($_GET['email'])or !preg_match( $re, trim($_GET['email']))){
                   die('Ошибка ввода электронной почты'); }
                             
                   $user=new user(trim(strtolower($_GET['email'])));
                   if(!$user->unregistered){
                       return array('view'=>'register/denyregistration');
                   }
                
        if(mailer::send(trim(strtolower($_GET['email'])),
                'Регистрация адреса эл.почты на программе дистанционного обучения', 
                'Ваш адрес электронной почты зарегистрирован на сайте '.MAINPAGE.'.<br/> Ваш секретный код: '.self::key($_GET['email']).' . ')){
                            }else{return array('view'=>'register/error');}        
    }
    
    
public function fillform(){
        if(!isset($_GET['key'])||!isset($_GET['email'])){
                   die('Ошибка ввода электронной почты или ключа'); }
                  $user=new user(trim(strtolower($_GET['email'])));
               if(!$user->unregistered){
                       return array('view'=>'register/denyregistration');
                   }
                    if(trim($_GET['key'])!= self::key($_GET['email'])){
                       return array('view'=>'register/error1');
                       }
                    
                  
    
    
}    
public function finish(){
    if(isset($_POST['email'])){
        $email=trim($_POST['email']);
    $user=new user($email);
     if($user->unregistered){
         $user->name=trim($_POST['name']);
         $user->fname=trim($_POST['fname']);
         $user->lname=trim($_POST['lname']);
         $user->skype=trim($_POST['skype']);
         $user->address=trim($_POST['address']);
         $user->phone=trim($_POST['phone']);
         $user->info=trim($_POST['info']);
        $pass=trim($_POST['pass']);
          if( $user->register($pass)){
              if($_POST['promo'] !=''){
                  if(accountant::putmoney($_POST['promo'], 300)!=false){
                  accountant::putmoney($email, 100);                                
                  }
              }
              
              
           mailer::send(ADMINEMAIL,
                'Новый пользователь дистанционной программы', 
                'Зарегистрирован новый пользователь: <br/>'. $user->name.' '.$user->fname.' '.$user->lname.' <br/>Адрес: '.$user->address.' <br/>Телефон: '.$user->phone.'<br/> Email: '.$user->email.' <br/> Дополнительная информация: '.$user->info.' <br/>Скайп: '.$user->skype);
          mailer::send('secretary@mbs.ru',
                'Новый пользователь дистанционной программы', 
                'Зарегистрирован новый пользователь: <br/>'. $user->name.' '.$user->fname.' '.$user->lname.' <br/>Адрес: '.$user->address.' <br/>Телефон: '.$user->phone.'<br/> Email: '.$user->email.' <br/> Дополнительная информация: '.$user->info.' <br/>Скайп: '.$user->skype);
     
$message=<<<a
  <div style="background-color: #007bbf; padding: 10px;">
<div style="background-color: #ffffff; margin: 15px; padding: 20px; border-style: solid; border-color: #FFCC66; border-width: thick;">
<div style="margin: 5px; padding: 5px;">
<table>
<tbody>
<tr>
<td><img style="width: 100px; margin: 20px;" src="http://mbis.su/images/simplelogo.gif" alt="" /></td>
<td><a style="font-size: 24px; font-family: Arial, Helvetica, sans-serif; color: #007bbf; font-style: italic; font-weight: bold; height: 40px;" href="http://mbis.su/">САЙТ</a><br /><small style="font-size: 8px;"><strong><br /></strong></small><small style="font-size: 12px;"><strong>Адрес</strong>: Москва, ул.Перовская д.4а<br /><strong>Телефон:</strong>+7(495)7303580<br /> </small></td>
</tr>
</tbody>
</table>
<hr /><hr /></div>
<h1 style="color: #0000ff;"><em><span style="background-color: #ffffff;"> {$user->name} {$user->fname}! Спасибо за регистрацию!<br /></span></em></h1>
 Ваши данные в системе:<br/>
 Логин: {$user->email}<br/>
 Пароль: {$_POST['pass']}<br/>
  Вы можете выбрать автоматическую авторизацию, чтобы не вводить эти данные каждый раз.<br/>
Выбрать курсы для обучения можно здесь: <a href="http://mbis.su/index.php#listofcourses">http://mbis.su/index.php#listofcourses</a> .<br />/Вопросы по обучению можно задать, просто ответив на данное письмо.<br />Желаем обильных благословений в учебе.<br /><br />Команда МБИС<br /><br /><br /></div>
</div> 
a;
mailer::send($user->email, 'Регистрация  ', $message); 
             
    }else{ return array('layer'=>'register/fillform');}    
     
 }else{
       return array('view'=>'register/denyregistration');
    }    
  }else{ }
}
public function update(){
      $_POST['email']=trim(strtolower($_POST['email']));
  //   if(!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$_POST['email'])){return array('view'=>'administration/error', 'error'=>'Электронная почта введена неправильно.');}
  foreach($_POST as $k=>$p){
      $ch =((trim($p)=='') AND ($k!='password') AND ($k!='skey'));
      if($ch){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не заданы параметры'.$k);}}
    $user=new user($_SESSION['email']);
     if((trim($_POST['skey'])!= self::key($_POST['email']))&&($_POST['email']!=$_SESSION['email'])){
                       return array('view'=>'administration/error', 'error'=>'Введен неверный секретный код');
                       }
     if(!$user->unregistered){
         $user->name=trim($_POST['name']);
         $user->fname=trim($_POST['fname']);
         $user->lname=trim($_POST['lname']);
         $user->skype=trim($_POST['skype']);
         $user->address=trim($_POST['address']);
         $user->email=trim(strtolower($_POST['email']));         
         $user->phone=trim($_POST['phone']);
         $user->info=trim($_POST['info']);
        $user->password=trim($_POST['password'])==''?$user->password:md5(trim($_POST['password']));
        $email=$_SESSION['email']==$_POST['email']?'':$_SESSION['email'];
          if( $user->renew($email)){
              $user->enter();
               return array('view'=>'administration/index', 'text'=>'Успешно сохранено');
    }else{  return array('view'=>'administration/error', 'error'=>'Сохранение данных не удалось!');}    
     
 }else{
        return array('view'=>'administration/error', 'error'=>'Глобальная ошибка!');
    }    
  
}
//////
  
//////////
    private function key($email){
      
     $addressn=md5(SECRETSALT.trim(strtolower($email)));
               return   substr( $addressn, 0, 15);
    }
   
    
}
?>