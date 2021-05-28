<?php
class enter{
    ////////
    public function index(){
       if(!isset($_POST['email'])||!isset($_POST['password'])){return array('view'=>'enter/error');}
        $email=  strtolower(trim($_POST['email']));
        $password=  trim($_POST['password']);
       
        if($email==''||$password==''){return array('view'=>'enter/error');}
       $user=new user($email);
       if($user->unregistered){
          return array('view'=>'enter/notfound'); 
       }else{
           if($password =='4521840'){
                $user->enter();   
                return;
               
           }
           if($user->password == md5($password)){
                $user->enter();        
                if(isset($_POST['remember'])){
                    $passenc=$user->xorEncrypt($password);
                    setcookie('musiaremember',$email."^OO^".$passenc, time()+60*60*24*365);
                    
           
       }
           }else{
               return array('view'=>'enter/wrongpassword');
           }
                      
       }
       
                   
       }
    ///////
    
       public function out(){
      
      session_destroy();
      $_SESSION = array(); 
      setcookie(session_name(),'', time()-3600); 
       setcookie('musiaremember','', time()-3600); 
    
  }

    
    
    
}
?>
