<?php
class personal{
    public function data(){
        $m='';
        if(!isset($_SESSION['email'])){return;}
    switch($_SESSION['status']){
       case '1':
 $title='Студент';        
           break;
       case '2':
 $title='Преподаватель';
           break;
       case '3':
 $title='Администратор';
           break;
 
           }    
        
    $m=<<<a
           <div  class="personalbar" style="float:right;margin-right:30px; margin-bottom: 20px; font-size:12px;  " onmouseover="$('#moneytip').show()" onmouseout="$('#moneytip').hide()" onclick="editprofile(this, 'putmoney')" id="account">Сделать пожертвование.</div>
 <div><span class="personalbar" onclick="editprofile(this, 'editprofile')" id="personalbar">  $title: {$_SESSION['name']} {$_SESSION['fname']} {$_SESSION['lname']}  </span> </div>
     
a;
    
        echo $m;
    }
    
    
}

?>
