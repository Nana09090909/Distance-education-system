<?php
class invite{
    
public static function invitegate(){

if(!isset($_SESSION['email'])){
echo<<<a
<span id="enter" class="enter">ВХОД</span><span id="reg" class="enter">РЕГИСТРАЦИЯ</span>
a;
}
else{
if($_SESSION['status']==1){
echo<<<a
<a class="enter" href="index.php?r=classroom">ВХОД В КЛАСС</a>
a;
}else{
echo<<<a
<a class="enter" href="index.php?r=classroom">УЧИТЕЛЬСКАЯ</a>
a;
    
}

}
}

public static function invitewindow(){
global $user;
if(!isset($_SESSION['email'])){
$out=  file_get_contents('protected/views/widgets/invite/invitewindow.php');
echo $out;  
}
}
  
    
    
    
    
    
    
    
    
    
    
    
}

?>
