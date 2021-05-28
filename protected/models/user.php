<?php
class user extends db{
public $unregistered=true;
public $lname='';
public $fname='';
public $name='';
public $email='';
public $address='';
public $password='';
public $status='';
public $phone=''; 
public $skype='';
public $id=''; 
public $info='';
public $key='';
public $money=0;
//////
//
//
//
//
///////////
public function user($email='', $key=''){
    if($email!=''){$email=strtolower(trim($email));
   $user=$this->mfa($this->query("SELECT * FROM `user` WHERE `email`='$email'; "));
   $this->email=$email;
   }else{
   if($key!=''){$user=$this->mfa($this->query("SELECT * FROM `user` WHERE `key`='$key'; "));}
   else{return;}
   
   }
     if($user==false){  return;
    }else{   
$this->unregistered=false;        
$this->lname=$this->restore($user['lname']);
$this->fname=$this->restore($user['fname']);
$this->name=$this->restore($user['name']);
$this->address=$this->restore($user['address']);
$this->status=$this->restore($user['status']);
$this->phone=$this->restore($user['phone']);
$this->email=$this->restore($user['email']);
$this->password=$this->restore($user['password']);
$this->skype=$this->restore($user['skype']);
$this->id=$this->restore($user['id']);
$this->info=$this->restore($user['info']);      
$this->key=$this->restore($user['key']);    
$this->money=$this->restore($user['money']);    

    }
}
////////////////////
///////////////////
public function enter(){
    
$_SESSION['email']=$this->email;
$_SESSION['lname']=$this->lname;
$_SESSION['fname']=$this->fname;
$_SESSION['name']=$this->name;
$_SESSION['address']=$this->address;
$_SESSION['phone']=$this->phone;
$_SESSION['status']=$this->status;
$_SESSION['skype']=$this->skype;
$_SESSION['info']=$this->info;
$_SESSION['id']=$this->id;
    $_SESSION['money']=$this->money;
return true;
    
}
//////////////
public function setnewkey(){
 $this->key=md5(time());
 if($this->renew()){
 return $this->key;
  }
  return false;
}
//////////////
public function register($password){
      $name=$this->supermes($this->name);
      $fname=$this->supermes($this->fname);
      $lname=$this->supermes($this->lname);
     $address=$this->supermes($this->address);
     $phone=$this->supermes($this->phone);
     $skype=$this->supermes($this->skype);
     $email=$this->supermes($this->email);
     $info=$this->supermes($this->info);
    $pass=md5(trim($password));
     $q="INSERT INTO `user`(`email`, `name`, `fname`,`lname`, `address`, `phone`, `password`, `skype`,`info`, `status`, `date`) VALUES('$email','$name','$fname','$lname','$address','$phone','$pass', '$skype', '$info', 1, date('now'));";
    $this->query($q);
    $this->user($this->email);
    mkdir('protected/data/users/'.$this->id);
    
  // unlink('protected/cache/users.php');
   
    return true;    
}  

public function del(){
    $this->delete('grades', 'student', $this->email);
    $this->delete('enrollment', 'student', $this->email);
    $this->delete('feedback', 'user', $this->email);
    filemanagement::emptydir('protected/data/users/'.$this->id);
    rmdir('protected/data/users/'.$this->id);
    $this->delete('user', 'email', $this->email);
//   unlink('protected/cache/users.php');   
    return true;
    
}
public function renew($oldemail=''){
      $name=$this->supermes($this->name);
      $fname=$this->supermes($this->fname);
      $lname=$this->supermes($this->lname);
     $address=$this->supermes($this->address);
     $phone=$this->supermes($this->phone);
     $skype=$this->supermes($this->skype);
     $email=$this->supermes(trim(strtolower($this->email)));
     $info=$this->supermes($this->info);
     $status=$this->supermes($this->status);
     $key=$this->supermes($this->key);
     $money=$this->supermes($this->money);
     
     $password=$this->password;
     $oldemail=$oldemail==''?$email:$oldemail;
     $q="UPDATE `user` SET `email`='$email', `name`='$name', `fname`='$fname',`lname`='$lname', `address`='$address', `phone`='$phone', `password`='$password', `skype`='$skype',`info`=='$info', `status`=='$status', `key`=='$key', `money`='$money' WHERE `email`='$oldemail';";

     $this->query($q);
    if( $oldemail !=''){
       $q="UPDATE `grades` SET `student`='$email' WHERE `student`='$oldemail';";
    $this->query($q);
     $q="UPDATE `enrollment` SET `student`='$email' WHERE `student`='$oldemail';";
    $this->query($q);
     $q="UPDATE `feedback` SET `user`='$email' WHERE `user`='$oldemail';";
    $this->query($q);
     $q="UPDATE `certificate` SET `student`='$email' WHERE `student`='$oldemail';";
    $this->query($q);
    $q="UPDATE `buy` SET `user`='$email' WHERE `user`='$oldemail';";
    $this->query($q);
    }
        return true;    
}  
/////////////////

public function generatefields($extended=''){
$text=<<<a
 <p>
      <input  value="{$this->email}" id="key" type="hidden"/>
     Фамилия<br/>
        <input  id="lname" value="{$this->lname}" type="text"/><br/> Имя<br/>
        <input  id="name" value="{$this->name}" type="text"/><br/>Отчество<br/>
        <input  id="fname" value="{$this->fname}" type="text"/></p>
       <p> <br/> Адрес<br/>
        <textarea cols="50" rows="5" id="address">{$this->address}</textarea></p>
        <p>
        <br/> Телефон<br/>        
        <input  value="{$this->phone}" id="phone" type="text"/>
         <br/> Адрес электронной почты<br/>        
        <input  value="{$this->email}" onfocus="asksecretcode()" id="email" type="text"/>
        <br/> Скайп<br/>
        <input  value="{$this->skype}" id="skype" type="text"/></p>
        <p>Личная информация: <br/>
        <textarea id="info" cols="50" rows="5" >{$this->info}</textarea>
        </p>
               
a;
        $password=<<<a
   <p>
       <br/> Пароль: отавьте пустым, чтобы не менять<br/>
        <input id="password" type="text"/>
   </p>     
a;
 
if($extended =='withpassword'){$text.=$password;}
if($extended =='foradmin'){
    $text.=$password;
    $text.=<<<a
   <p> <select id="status"><option value="0">Статус</option><option value="1">Студент</option><option value="2">Преподаватель</option><option value="3">Администратор</option></select></p>
a;
$text=  str_replace('="'.$this->status.'"', '="'.$this->status.'" selected="selected"',$text);
}
$text.='<p><input type="button"  value="Сохранить изменения" id="editsavechanges"></p>';    
return $text;
    
    
}

///////////////////
 public  function xorEncrypt($input,$decrypt=false)
   {
      $o = $s1 = $s2 = array(); // Arrays for: Output, Square1, Square2
    // формируем базовый массив с набором символов
    $basea = array('(','@','?','$',';',"]",'#','*',"&"); // base symbol set
    $basea = array_merge($basea, range('a','z'), range('A','Z'), range(0,9) );
    $basea = array_merge($basea, array('!',')','_','+','|','%','/','[','.',' ') );
    $dimension=9; // of squares
    for($i=0;$i<$dimension;$i++) { // create Squares
        for($j=0;$j<$dimension;$j++) {
            $s1[$i][$j] = $basea[$i*$dimension+$j];
            $s2[$i][$j] = str_rot13($basea[($dimension*$dimension-1) - ($i*$dimension+$j)]);
        }
    }
    unset($basea);
    $m = floor(strlen($input)/2)*2; // !strlen%2
    $symbl = $m==strlen($input) ? '':$input[strlen($input)-1]; // last symbol (unpaired)
    $al = array();
    // crypt/uncrypt pairs of symbols
    for ($ii=0; $ii<$m; $ii+=2) {
        $symb1 = $symbn1 = strval($input[$ii]);
        $symb2 = $symbn2 = strval($input[$ii+1]);
        $a1 = $a2 = array();
        for($i=0;$i<$dimension;$i++) { // search symbols in Squares
            for($j=0;$j<$dimension;$j++) {
                if ($decrypt) {
                    if ($symb1===strval($s2[$i][$j]) ) $a1=array($i,$j);
                    if ($symb2===strval($s1[$i][$j]) ) $a2=array($i,$j);
                    if (!empty($symbl) && $symbl===strval($s2[$i][$j])) $al=array($i,$j);
                }
                else {
                    if ($symb1===strval($s1[$i][$j]) ) $a1=array($i,$j);
                    if ($symb2===strval($s2[$i][$j]) ) $a2=array($i,$j);
                    if (!empty($symbl) && $symbl===strval($s1[$i][$j])) $al=array($i,$j);
                }
            }
        }
        if (sizeof($a1) && sizeof($a2)) {
            $symbn1 = $decrypt ? $s1[$a1[0]][$a2[1]] : $s2[$a1[0]][$a2[1]];
            $symbn2 = $decrypt ? $s2[$a2[0]][$a1[1]] : $s1[$a2[0]][$a1[1]];
        }
        $o[] = $symbn1.$symbn2;
    }
    if (!empty($symbl) && sizeof($al)) // last symbol
        $o[] = $decrypt ? $s1[$al[1]][$al[0]] : $s2[$al[1]][$al[0]];
    return implode('',$o);
   }
 
    
    
    
    
    
    
    
    
    
}
class userlist extends db{
    public $list;
    public $number=0;
    public function __construct() {
/*if(file_exists('protected/cache/users.php')){
    include('protected/cache/users.php');
}else{
$userlist="<? \n \$this->list=array(\n";*/
    $s=$this->query("SELECT * FROM `user` ORDER BY `lname`;");
        while($r=$this->mfa($s)){
            $this->list[$r['email']]=array(
           'name'=>$this->restore($r['name']),
          'fname'=>$this->restore($r['fname']),
          'lname'=>$this->restore($r['lname']),
          'phone'=>$this->restore($r['phone']),
          'address'=>$this->restore($r['address']),
          'id'=>$this->restore($r['id']),
          'skype'=>$this->restore($r['skype']),
          'info'=>$this->restore($r['info']),
          'date'=>$this->restore($r['date']),
          'status'=>$r['status'],
                'money'=>$r['money'],               
         
            );
/*$userlist.=<<<a
    '{$r['email']}'=>array(
     'name'=>'{$r['name']}',
          'fname'=>'{$r['fname']}',
          'lname'=>'{$r['lname']}',
          'phone'=>'{$r['phone']}',
          'address'=>'{$r['address']}',
          'id'=>'{$r['id']}',
          'skype'=>'{$r['skype']}',
          'info'=>'{$r['info']}',
          'date'=>'{$r['date']}',
          'status'=>'{$r['status']}'   
              ),\n
a;*/
            $this->number++;        }
    //    $userlist.=");\n";
      //  file_put_contents('protected/cache/users.php',$userlist);
    //}
    
    }
    /////////////////////////
   public function studentcourse($course){
       $in=array();
       $out=array();
       $localenrollment=array();
$el=new enrollmentlist;
foreach($el->list as $k=>$v){    
    if($v['course']==$course){
       $localenrollment[$v['student']]=$v; 
    }
    
    }
   
 foreach($this->list as $k=>$v){
        if($v['status']==1){
       
     if(isset($localenrollment[$k])){
         $in[$k]=$v;
         }else{
             $out[$k]=$v;
         }

      }
 }
   return array('in'=>$in, 'out'=>$out); 
}
       
       
       
  
   
   
   
   /////////////////////
    public function maketeacheroptions(){
        $teacheroptions='';
    foreach($this->list as $k=>$v){
        if($v['status']>1){
            $teacheroptions.=<<<a
   <option value="$k">{$v['lname']} {$v['name']}</option>
a;
        }
    }    
        
        return $teacheroptions;
    }
    //////////////////////////
}
?>