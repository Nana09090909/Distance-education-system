<?php
class musia{
   public static function main(){
       
//Компиляция        
       require_once 'config.php';
//       if(CURRENTHOST !=$_SERVER['SERVER_NAME']){ header('Location: http://'.CURRENTHOST);}
       require_once 'globalfunctions.php';
        $main=  scandir('protected/main');
        foreach($main as $m){
if (($m !== ".")&&($m !== "..")&&($m !== "mail.php")){include('main/'.$m);}
            }    
        $models=  scandir('protected/models');
        foreach($models as $m){
if (($m !== ".")&&($m !== "..")){include('models/'.$m);}
}
        $widgets=  scandir('protected/widgets');
        foreach($widgets as $m){
if (($m !== ".")&&($m !== "..")){include('widgets/'.$m);}
}



//Определение контроллера 

	$_GET['r']=isset($_GET['r'])?$_GET['r']:'site';            
        $r=explode('/', $_GET['r']);
        $r[1]=isset($r[1])?$r[1]:'index';
        if(!file_exists('protected/controllers/'.$r[0].'.php')){$r['0']='site'; $r[1]='index';}
        include('protected/controllers/'.$r[0].'.php');
 self::start_session();
self::permission($r[0]);	
       //Вывод содержимого
        $args=call_user_func(array($r[0],$r[1]));
 

        $viewpath=isset($args['view'])?$args['view']:$r[0].'/'.$r[1];
        if(file_exists('protected/views/'.$viewpath.'.php')){
        $message=file_get_contents('protected/views/'.$viewpath.'.php');
    if(count($args)>0){
        foreach($args as $k=>$v){
            if(($k!='layer')&&($k!='view')){
        $message=str_replace('%%'.$k.'%%', $v, $message);    
            }//var_dump($message);
        }
    }
        $layer= isset($args['layer'])?$args['layer']:'empty';
        include('layers/'.$layer.'.php');
        }
        }
    
        private function start_session(){
                   session_name('musia');
                 //  session_name('mlib');
                   session_set_cookie_params(86400); 
                 //  $droot= str_replace('/', SLASH, $_SERVER['DOCUMENT_ROOT']);
//ini_set('session.save_path', $droot .SLASH.'protected'.SLASH.'sessions'.SLASH);                  
session_start(); 
// var_dump($_SESSION);
//echo $_SERVER['DOCUMENT_ROOT'] .'/protected/sessions/';
 if(isset($_COOKIE['musiaremember'])&&!isset($_SESSION['email'])){
     $ep=  urldecode($_COOKIE['musiaremember']);
          $ep=  explode('^OO^', $ep);
      $user=new user($ep[0]);
      $ep[1]=$user->xorEncrypt($ep[1],true);
    
    if($user->password == md5($ep[1])){
    
    
    $user->enter();               
               
                }
      }else{
       
          
      }

        }
        private function permission($k){
            include('protected/permissions.php');
            if(isset($permissions[$k]) &&(($permissions[$k]>$_SESSION['status'])||!isset($_SESSION['status']))){
                header("Location: http://".$_SERVER['HTTP_HOST']
.dirname($_SERVER['PHP_SELF'])
."/index.php");
                die();
            }
            
            
        }

}

        ?>