<?php
class accountant{
    public function showmoney($user){
     $user=new user($user);
     return $user->money;
        
    }
    public function altermoney($user, $course, $percent, $sum=0){
               $course=new course($course);
  $user=new user($user);
  if($sum==0){
      $nowm=$user->money;
        $user->money=(int)$nowm+(int)$course->price*$percent/100;
  }else{$user->money=(int)$user->money+$sum;}
  $user->renew();
  if( $_SESSION['email']==$user->email){
      
       $_SESSION['money']=$user->money;
      
  }
  return $user->money;
      
      
  }
  
   public function putmoney($user,$sum){
      $user=new user($user); 
      if($user->unregistered){return false;}
     $user->money=(int)$user->money+$sum;
 $user->renew();
  if( $_SESSION['email']==$user->email){
      
       $_SESSION['money']=$user->money;
      
  }
  return $user->money;
    
}

    
}

?>
