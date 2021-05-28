<?php

class maillist{
public function index(){
    $text='';
    $ul= new userlist;
    foreach($ul->list as $k=>$v){
        if($v['status']=='1'){
        $text.=$k.'^%%%%%%%^';
        }
    }
    $text=rtrim($text, '^%%%%%%%^');
    file_put_contents('mailer/list.txt', $text);
     header("Location: http://".$_SERVER['HTTP_HOST']
.dirname($_SERVER['PHP_SELF'])
."/mailer/index.php");
    
    
    }
    public function course(){
        if(!isset($_SESSION['currentcourse'])){die('');}
          if($_SESSION['status']<2){die('Только для преподавателей');}
$ul=new userlist;
$ma=$ul->studentcourse($_SESSION['currentcourse']);
   $text='';
   
    foreach($ma['in'] as $k=>$v){
        $text.=$k.'^%%%%%%%^';        
    }
    $text=rtrim($text, '^%%%%%%%^');
    file_put_contents('mailer/list.txt', $text);
     header("Location: http://".$_SERVER['HTTP_HOST']
.dirname($_SERVER['PHP_SELF'])
."/mailer/index.php");
    
         
        
    }
    
    
}


?>