<?php
class currentcourse{
  public function index(){
      $_SESSION['disablemenu']=false;
   if(!isset($_GET['id'])){header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php?r=classroom'); die(); }
   $course=new course(trim($_GET['id']));   
   if($course->nuevo){header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php'); die(); }
   $_SESSION['currentcourse']=trim($_GET['id']);   
   $_SESSION['currenttitle']=$course->title;
    
if((int) $_SESSION['status']>1){return array('view'=>'currentcourse/assignments','layer'=>'currentcourse',)+self::assignments();}
if(!isset($_SESSION['email'])){  return self::showinfo($_GET['id']);}
$en=new enrollment($_SESSION['email']); 
if( $course->status=='0'){ 
            $_SESSION['disablemenu']=true; 
if(!isset($en->courses[$_SESSION['currentcourse']])){ 
return self::showinfo($_SESSION['currentcourse']);
                        }

            
            return self::showinfo($_GET['id'], $en->courses[$_SESSION['currentcourse']]['finalgrade']);}   
    
    

if(!isset($en->courses[$_SESSION['currentcourse']])){  return self::showinfo($_GET['id']);}
if($en->courses[$_SESSION['currentcourse']]['finalgrade']!='0'){
    return self::showinfo($_GET['id'], $en->courses[$_SESSION['currentcourse']]['finalgrade']);   
}
    switch($en->courses[$_SESSION['currentcourse']]['paid'])
   {
    case '0':
        if($course->price!='0'){
            if(isset($_SESSION['try'])){ return array('layer'=>'currentcourse')+self::currentassignment(); }
            $_SESSION['disablemenu']=true; 
             $priceplus=(float)$course->price*1.005;
             $webmoney=(float)$course->price*1.05;
             $webmoneydol=(float)$course->price*1.05/25;
             $webmoneyeuro=(float)$course->price*1.05/35;             
             $paypal=(float)$course->price/35;
             $paypal=(int)$paypal+1;
             $mymoney=$_SESSION['money']>=$course->price?'<input type="button" value="Заплатить с моего счета" onclick="paywithmy()"/>':'';
return array('layer'=>'payment', 'view'=>'currentcourse/payment', 'coursename'=>$course->title, 'paypal'=>$paypal,'sum'=>$course->price, 'priceplus'=>$priceplus, 'urlencode'=>  urlencode('Пожертвование за курс '.$course->title), 'webmoney'=>$webmoney,'webmoneydol'=>$webmoneydol,'webmoneyeuro'=>$webmoneyeuro, 'mymoney'=>$mymoney, ); 
        }else{ 
           
 return array('layer'=>'currentcourse')+self::currentassignment(); 
            
        }
        break;
case '1':
    $_SESSION['disablemenu']=true; 
return array('layer'=>'currentcourse', 'view'=>'currentcourse/thankyou'); 
 break;
    case '2':
       
 return array('layer'=>'currentcourse')+self::currentassignment(); 
 break;
        default :
         
  return self::showinfo($_GET['id']);
        
       
   }
     }
     private function sessioncontrol($uri){
        if(substr($uri,0,1)!='?'){return;}
        if(!strrpos($uri,'&id=')){return;}
        $id=substr($uri, strrpos($uri,'=')+1);
        if($_SESSION['currentcourse']!= $id){
        $_SESSION['currentcourse']=$id;
         $course=new course($id);   
     $_SESSION['currenttitle']=$course->title;
         }
         
     }
//////////////Для преподов
     public function saveinfo(){
          if($_SESSION['status']<2){die('Только для преподавателей');}         
         if(!isset($_POST['data'])){die('Неверное обращение к странице');}         
          file_put_contents('protected/data/courses/'.$_SESSION['currentcourse'].'/index.php',  stripslashes($_POST['data']));
         
        return array('view'=>'currentcourse/aboutadmin')+self::aboutadmin();
     }
     public function aboutadmin(){
          if($_SESSION['status']<2){die('Только для преподавателей');}
         self::sessioncontrol($_POST['data']);
         
         $text= str_replace('"','&quot;',file_get_contents('protected/data/courses/'.$_SESSION['currentcourse'].'/index.php'));
         return array('text'=> $text);
     }
     public function libraryadmin(){
          if($_SESSION['status']<2){die('Только для преподавателей');}
    self::sessioncontrol($_POST['data']);
         $new='';
         $list='';
         $l4c=new lib4course($_SESSION['currentcourse']);
          $links=  json_decode(file_get_contents('convert/knigi'), TRUE);
          foreach($l4c->list as $k=>$v){
           
                         $list.=<<<a
                            
   <a target="_blank" href="{$links[$v['file']]}" >{$v['title']}</a> <button onclick="display('removebook','{$v['lib']}' )">Убрать</button><br/>  
       
a;
         }
         $newa=$l4c->getnew($_SESSION['currentcourse']);
         foreach($newa as $k=>$v){
             $new.='<option value="'.$k.'">'.$v['title'].'</option>';
             
         }
         $list=$list==''?'':$list;
 $anycontent=file_exists('protected/data/courses/'.$_SESSION['currentcourse'].'/lib.php')?file_get_contents('protected/data/courses/'.$_SESSION['currentcourse'].'/lib.php'):'';
        return array('list'=>$list, 'new'=>$new, 'anycontent'=>$anycontent);
         
     }
     public function addnewbook(){
          if($_SESSION['status']<2){die('Только для преподавателей');}
         if(!isset($_POST['data'])){die('Неверное обращение к странице');}
         $lib= new lib4course($_SESSION['currentcourse']);
         $lib->add2course($_POST['data']);
         
         return array('view'=>'currentcourse/libraryadmin')+ self::libraryadmin();
     }
     
     public function addanycontent(){
          if($_SESSION['status']<2){die('Только для преподавателей');}
         if(!isset($_POST['data'])){die('Неверное обращение к странице');}
file_put_contents('protected/data/courses/'.$_SESSION['currentcourse'].'/lib.php',  stripslashes($_POST['data']));
         
         return array('view'=>'currentcourse/libraryadmin')+ self::libraryadmin();
     }
public function kickhiim(){
          if($_SESSION['status']<2){die('Только для преподавателей');}
         if(!isset($_POST['data'])){die('Неверное обращение к странице');}
    $en=new enrollment($_POST['data']);
  if($en->quit($_SESSION['currentcourse'])){
    return array('view'=>'currentcourse/students')+self::students();   
  }else{
    return array('view'=>'administration/error', 'error'=>'Студент все еще там записан');  
  }
  
    
}
public function enroll(){
  if($_SESSION['status']<2){die('Только для преподавателей');}
         if(!isset($_POST['data'])){die('Неверное обращение к странице');}
         $ar=  explode('%SEPARATOR%', $_POST['data']);
         $en=new enrollment($ar[0]);
         if(!isset($en->courses[$_SESSION['currentcourse']])){
             //$en->enroll($_SESSION['currentcourse']);
             
         }
                 if($ar[1]=='1'){$en->register($_SESSION['currentcourse']);}
         
             $user=new user($ar[0]);
             $message=<<<a
  <div style="background-color: #007bbf; padding: 10px;">
<div style="background-color: #ffffff; margin: 15px; padding: 20px; border-style: solid; border-color: #FFCC66; border-width: thick;">
<div style="margin: 5px; padding: 5px;">
<table>
<tbody>
<tr>
<td><img style="width: 100px; margin: 20px;" src="http://mbis.su/images/simplelogo.gif" alt="" /></td>
<td><a style="font-size: 24px; font-family: Arial, Helvetica, sans-serif; color: #007bbf; font-style: italic; font-weight: bold; height: 40px;" href="http://mbis.su/">МОСКОВСКАЯ БОГОСЛОВСКАЯ ИНТЕРНЕТ-СЕМИНАРИЯ ЕХБ</a><br /><small style="font-size: 8px;"><strong><br /></strong></small><small style="font-size: 12px;"><strong>Адрес</strong>: Москва, ул.Перовская д.4а<br /><strong>Телефон:</strong>+7(495)7303580<br /> </small></td>
</tr>
</tbody>
</table>
<hr /><hr /></div>
<h1 style="color: #0000ff;"><em><span style="background-color: #ffffff;"> Здравствуйте, {$user->name} {$user->fname}! <br /></span></em></h1>
 Вы успешно записаны на курс <a href="http://mbis.su/index.php?r=currentcourse&id={$_SESSION['currentcourse']}"><b>{$_SESSION['currenttitle']}</b></a>. <br/>
 <br />Вопросы по обучению можно задать, просто ответив на данное письмо.<br />Желаем обильных благословений в учебе.<br /><br />Команда МБИС<br /><br /><br /></div>
</div> 
a;
//mailer::send($user->email, 'Запись на курс '.$_SESSION['currenttitle'], $message);           
             
             
  return array('view'=>'currentcourse/students')+self::students();   
           
           
    
}
public function gradecourse(){
  if($_SESSION['status']<2){die('Только для преподавателей');}
         if(!isset($_POST['data'])){die('Неверное обращение к странице');}
         $v=explode('%%', $_POST['data']);
         $student=new user($v[1]);
        $enrollment=new enrollment($v[1]);
  $enrollment->grade($_SESSION['currentcourse'], $v[0]);

  if($v[2]=='true'){
  if($v[0]=='отлично'){
      accountant::altermoney($v[1],$_SESSION['currentcourse'], 25);
        }
 $countdays=$enrollment->countdays($_SESSION['currentcourse']);
        
         if((int)$countdays <30){
      accountant::altermoney($v[1],$_SESSION['currentcourse'], 50);
        }else{
        if((int)$countdays <40){
      accountant::altermoney($v[1],$_SESSION['currentcourse'], 20);
        }
        }
  }
  if(!$enrollment->getcertificate($_SESSION['currentcourse'])){
       $certificate=new certificate();
       $certificate->course=$_SESSION['currentcourse'];
       $certificate->student=$v[1];
       $certificate->address=$student->address;
       $certificate->ask();
  }
       echo "Оценка сохранена";   
  
         
}

 public function feedbackold(){
        $text='';
     
 $flist=new feedbacklist($_SESSION['currentcourse']);
 
 foreach($flist->responded as $k=>$v){
     $user=new user($v['user']);
     $text.=<<<a
<br/>{$user->name} {$user->fname} {$user->lname}<br/>{$v['date']}<br/> {$v['text']}<br/>Ответ<br/>{$v['response']}<br/><input type="button" value="Удалить" onclick="display('deletefeedback', $k)"></button><br/>  
a;
 }
     $text=$text==''?'Нет заданых вопросов':$text;
 
 return array('text'=>$text, 'view'=>'administration/feedback');
        
    }
    
  public function sendresponse(){
  if(!isset($_POST['data'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не заданы параметры');}
$a=explode('%%SEPARATOR%%',$_POST['data']);
$text='';
if(!isset($a[2])){
$feedback=new feedback($a[1]);
$user=new user($feedback->user);
$text="Здравствуйте, ".$user->name." ".$user->fname."! <br/> Приводим ответ на ваш вопрос на сайте Московской богословской интернет-семинарии ЕХБ: <br/>".$a[0]."<br/> Вопрос был: <br/>".$feedback->text."<br/> Успехов в учебе!<br/> Администрация МБИС ЕХБ";
$feedback->response=$a[0];
$feedback->respond();
mailer::send($feedback->user,'Ответ на вопрос по курсу '.$_SESSION['currenttitle'],$text );
$address=$feedback->user;
}else{
$address=$a[1];
 mailer::send($a[1], $a[2],$a[0] );
}
 return array('view'=>'administration/newcreated', 'newcreated'=>'Ответ выслан на адрес '.$address);
    
}

public function deletefeedback(){
if(!isset($_POST['data'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не заданы параметры');}
$feedback=new feedback($_POST['data']);
if($feedback->del()){
return array('view'=>'administration/newcreated', 'newcreated'=>'Вопрос удален!');
}else{return array('view'=>'administration/error', 'error'=>'Вопрос не был удален!');}
   
}
public function correspondance (){
     if($_SESSION['status']<2){die('Только для преподавателей');}
         self::sessioncontrol($_POST['data']);
         
$ul=new userlist;
$ma=$ul->studentcourse($_SESSION['currentcourse']);
$in="";
foreach($ma['in'] as $k=>$v){
    $in.='<option value="'.$k.'">'.$v['lname'].' '.$v['name'].' '.$v['fname'].'</option>';    
}
    $text='';
         $flist=new feedbacklist($_SESSION['currentcourse']);
 
 foreach($flist->newones as $k=>$v){
     $user=new user($v['user']);
     $text.=<<<a
   <hr/>
<br/>{$user->name} {$user->fname} {$user->lname}</td><td>{$v['user']} {$v['date']}<br/> {$v['text']}<br/><textarea>Ответ</textarea><button  onclick="var v=$(this).prev().val()+'%%SEPARATOR%%'+'$k';  display('sendresponse',v)">Ответить</button><br/><input type="button" value="Удалить"  onclick="display('deletefeedback', $k)"><br/> <hr/>   
a;
 }
      $text=$text==''?'Нет заданых вопросов':$text;
      $text.='<p><input type="button" value="История"  onclick="display(\'feedbackold\',\'\')"></p>';
 return array('text'=>$text, 'students'=>$in);
    
}
public function showstudent(){
    $text='';
    include('protected/includes/gradesys.php');
     if($_SESSION['status']<2){die('Только для преподавателей');}
     if(!isset($_POST['data'])){die('Неверное обращение к странице');}
     $fl=new framelist($_SESSION['currentcourse']);
    $gradearray=$fl->gradebookarray($_POST['data']);
    $enr=new enrollment($_POST['data']);
    if(!isset($enr->courses[$_SESSION['currentcourse']])){die('Неверное обращение к странице');}
    $finalgrade=$enr->courses[$_SESSION['currentcourse']]['finalgrade'];
    $finalgradefrase=($finalgrade=='0')?'Курс еще не закончен':$finalgrade;
         $finalgradefrase=($finalgrade=='1')?'Курс ожидает оценки':$finalgradefrase;
     $finalgradefrase=($finalgrade=='1')?'Курс ожидает оценки':$finalgradefrase;
     $paid='';
    // var_dump($enr->courses[$_SESSION['currentcourse']]['paid']);
     switch ($enr->courses[$_SESSION['currentcourse']]['paid']){
       case '0':
           $paid='закрыт, т.к. неоплачен';
           break;
         case '1':
           $paid='закрыт, хотя оплачен';
           break;
     case '2':
           $paid='открыт';
           break;
     
       
     }
     $student=new user($_POST['data']);
      $text.="<hr/><h3>Студент ".$student->lname."  ".$student->name." ".$student->fname." email:".$student->email."</h3><br/> Курс $paid <br/> <h4>Оценка за курс: ".$finalgradefrase.'</h4><select id="finalgrade"><option value="0">Не закончен</option><option value="1">Ожидает оценки</option>'.$gradesys.'</select><input type="checkbox" id="givemoney"/>Дать бонусы.<br/><button onclick="gradecourse(\''.$_POST['data'].'\')">Оценить курс</button><button onclick="kickhim(\''.$_POST['data'].'\')">Исключить из курса</button><br/><hr/><span id="response"></span><span class="details" onclick="$(this).next().toggle()">Подробности</span><div style="display:none">';
      if(count($gradearray)>0){
    foreach($gradearray as $k1=>$v1){
           
        $text.='<div>*****************************</div><div>'.$v1['title'].'  '.$v1['desc'].'</div> ';
        $i=0;
        foreach($v1['gradeinfo'] as $k2=>$v2){
            $i++;
            $submission=$v2['submitted']?'<span class="redpointer" onclick="$(this).next().toggle()">Содержание ответа</span><div style="display: none">'.$v2['submission']:'<div>';
            $text.=<<<a
            <br/>$submission</div>
a;
                if($v2['graded']=='true'){
                if($v2['checked']=='true'){
                    $text.='<br/>Задание зарегистрировано, но не проверено <br/>';
                } else{    
                $text.='<br/>Поставлена оценка '.$v2['grade'].'<br/>'.'<span class="redpointer" onclick="$(this).next().toggle()">Содержание комментария</span><div style="display: none">'.$v2['comments'].'</div>';}
            }else{
                $tempsub=$v2['submission']?"<br/>Сделано: <textarea>".$v2['submission'].'<textarea>':'';
                if($v2['submitted']=='true'){$text.='<br/>Задание сдано, но еще не зарегистрировано<br/>'.$tempsub;}else{$text.='<br/>Задание пока не сдано<br/>'.$tempsub;}
            }
            
$comments=$v2['comments']==''?'Комментариев нет':$v2['comments'];            
    $grade= '<select><option value="0">Выставить (новую) оценку</option><option value="2">Неудовлетворительно</option>'.$gradesys.'</select><textarea>'.$comments.'</textarea><button onclick="grade(\''.$k2.'\',\''.$_POST['data'].'\', this);">Оценить задание</button>';        
            $text.=$grade.'<br/>';
        }
    }}
$text.="</div>";        
     echo $text;
}
public function gradeass(){
  if($_SESSION['status']<2){die('Только для преподавателей');}
         if(!isset($_POST['data'])){die('Неверное обращение к странице');}
$v=explode('%%SEPARATOR%%', $_POST['data'] );//0 assignment 1 student 2 comments 3 grade
if($v[3]=='0'){ return;}

$en=new grades($v[1],$v[0]);
//var_dump($en);
$en->comments=$v[2];
$en->grade=$v[3];   
$en->submission=$en->submission.' <h2>Нестандартный способ оценки!</h2>';   
if($v[3]!='2'){ $en->grade();

}else{
    $en->fail();
}
echo '<script>alert("Задание оценено успешно!");</script>';
}
public function students(){
    if($_SESSION['status']<2){die('Только для преподавателей');}
      self::sessioncontrol($_POST['data']);
$out=''; $in='';

     $ul=new userlist;
$ma=$ul->studentcourse($_SESSION['currentcourse']);
foreach($ma['out'] as $k=>$v){
    $out.='<option value="'.$k.'">'.$v['lname'].' '.$v['name'].' '.$v['fname'].'</option>';    
}
foreach($ma['in'] as $k=>$v){
    $in.='<option value="'.$k.'">'.$v['lname'].' '.$v['name'].' '.$v['fname'].'</option>';    
}

return array('out'=>$out,'in'=>$in,);     
          
     }
     
     public function removebook(){
          if($_SESSION['status']<2){die('Только для преподавателей');}
         if(!isset($_POST['data'])){die('Неверное обращение к странице');}
         $lib= new lib4course($_SESSION['currentcourse']);
         $lib->remove($_POST['data']);
         
         
         return array('view'=>'currentcourse/libraryadmin')+ self::libraryadmin();
     }
     
    public function assignments(){
         if($_SESSION['status']<2){die('Только для преподавателей');}
       if(isset($_POST['data'])){   self::sessioncontrol($_POST['data']);}
        $assignments='';
       
          $framelist='';
      $list=new framelist($_SESSION['currentcourse']);
      foreach($list->list as $k=>$v){
          $assignments.=<<<a
<tr><td>Фрейм номер {$v['order']}</td><td><b>{$v['title']}</b></td><td>{$v['desc']}</td><td><button  onclick="showassignment('$k')">Показать</button></td></tr>
a;
          
          
      }
        
        return array('assignments'=>$assignments,);
        
    }
    

///////////ДЛя студентов
    public function tryme(){
        $_SESSION['try']=1;
    }
    
  public function showinfo($c, $grade=''){
      $v=new course($c);
       
      $enroll=($_SESSION['status']==1)?'<br/><span id="enr'.$c.'"><button class="enrollbut" warn="'.$c.'" course="'.$c.'">Записаться сейчас</button>':"";
                    $warn=$v->status=='0'?'Курс появится в вашей зачетной книжке сразу после публикации':'';
                     
   switch($grade){
       case '':
                $enroll=($_SESSION['status']==1)?'<br/><span id="enr'.$c.'"><button class="enrollbut" warn="'.$warn.'" course="'.$c.'">Записаться сейчас</button>':"";
           $price=$_SESSION['status']==1?'<br><small>Цена курса '.$v->price.' руб </small><br/>':'';
          
           break;
       case'0':
           $enroll="Вы записаны на этот курс. Он станет доступным сразу после публикации";
          $price='';
                     break;
       default:
           $enroll="<span style=\"font-style: normal; font-size:1.4em;\">Курс завершен. Ваша оценка:<span style=\"color:red\"> ".$grade.'</span></span><br/><button style="margin-left:100px;color:white" id="mygrades" class="teasers" ></button>';
          $price='';
           
           
           break;
          }
                    
                   if($v->status =='0'){
$add=' (Курс находится в разработке)';
}else{$add='';}
$list="<div class=\"blog\"><b>".$v->title.$add."</b></p><div class=\"coursedesc\">".$v->desc. $enroll.$price."</div>";
$list.=<<<A
<script>
$('.enrollbut').click(function(e){
   var data=$(e.target).attr('course');
   var warn=$(e.target).attr('warn');
var where='#enr'+data;
$(where).html('<img src="images/progress.gif"/>');
$.ajax({type: 'POST', url:'index.php?r=classroom/enroll', data:'data='+encodeURIComponent(data), success: function (e){
    $(where).html(e+'<br/><small>'+warn+'</small>');    
    }});

});
</script>
A;
     return array('layer'=>'layer', 'view'=>'administration/index', 'text'=>$list);              
      
      
  }  
  public function currentassignment(){
       if($_SESSION['disablemenu']){ die('Меню пока отключено!');}
        if(isset($_POST['data'])){   self::sessioncontrol($_POST['data']);}
      $alist=new framelist($_SESSION['currentcourse']);
 
      if($currentframe=$alist->currentframe($_SESSION['email'])){
         
        
        $frame=new frame($currentframe);
        $_SESSION['currentframeid']=$frame->id;
        $_SESSION['currentframeorder']=$frame->order;
         if(isset($_SESSION['try'])&&$frame->order!=1){unset($_SESSION['try']); echo'<script>alert("Вы успешно прошли пробную лекцию");</script>'; return self::index(); }
        $_SESSION['currentframetitle']=$frame->title;
        $_SESSION['currentframedesc']=$frame->desc;
        $appeal=$frame->frameisactive($_SESSION['email'])?'Сейчас вам следует выполнить задание:':'Для продолжения курса секретарь должен зарегистрировать последние задания.<br/> Это может занять несколько часов.<br/>Займитесь пока повторением материала!';
         return array('title'=>$frame->title, 'desc'=>$frame->desc, 'id'=>$frame->id, 'appeal'=>$appeal, 'view'=>'currentcourse/currentassignment');
         
      }
      $en=new enrollment($_SESSION['email']);
      if($en->courses[$_SESSION['currentcourse']]['finalgrade']=='0'){
                      $en->grade($_SESSION['currentcourse'], '1');
          return array('view'=>'currentcourse/waitfor');
      }
      if($en->courses[$_SESSION['currentcourse']]['finalgrade']=='1'){
              return array('view'=>'currentcourse/waitfor');
      }
       $gra='Ваша оценка: "'.$en->courses[$_SESSION['currentcourse']]['finalgrade'].'".';
              return array('view'=>'currentcourse/finished', 'grade'=>$gra);
      
  }
  public function showassignment(){
           if($_SESSION['disablemenu']){ die('Меню пока отключено!');}
      $sub='';
      if(!isset($_POST['id'])){die();}
      $frame= new frame($_POST['id']);
      if($_SESSION['status']>1){$_SESSION['currentframeid']=$_POST['id']; }
    $ass='';
      if($_POST['id']==$_SESSION['currentframeid'] || $_SESSION['currentframeorder']>$frame->order){//Если

      $assignmentlist=new assignmentlist($_POST['id']);
      foreach ($assignmentlist->list as $k=>$v){
          $a=new assignment($k);
          $g=new grades($_SESSION['email'],$k);
          if(!$g->submitted || $_SESSION['status']>1){
              $subs= str_replace('"',"&quot;", $g->submission);
              $ini=str_replace('"',"&quot;" ,$a->paramsarray['ini']);
              $ass.=$a->html;            
              $ass.=<<<a
   <input type="hidden" value="$subs" id="saveddata"/>
          <input type="hidden" value="$ini" id="ini"/>
a;
      $sub=$g->submission;
    //  var_dump($sub);
          
      //    var_dump($ass);
      
                    }else{
              switch ($g->grade){
                  case '1':
              $gra= 'для регистрации секретарем';              
                      break;
                  case '2':
              $gra= 'и одобрено секретарем';              
                      break;
                  case '':
              $gra= '';              
                      break;
              default:
                  $gra= 'на оценку '.$g->grade;
              
              }
              $comment=$g->comments !=''?'<br/> <b>Комментарий преподавателя:</b><br/> '.$g->comments:'';
              $ass.=<<<a
                 <p class="submitted">Задание сдано $gra (посмотреть)</p><div style="display:none; background-color:#EEFFEE; padding: 20px;">{$g->submission}$comment </div> 
a;
                  }
      }
    
      }
    $ass=$ass==''?'Задание пока недоступно':$ass;
      return array('assignments'=>$ass, 'title'=>$frame->title,'desc'=>$frame->desc, 'submission'=>$sub);
     
      }
 
      
  public function submitass(){
       if($_SESSION['disablemenu']){ die('Меню пока отключено!');}
           if($_SESSION['status']>1){die('Эмуляция сдачи задания');}
      if(!isset($_GET['id'])){die('Задание не сдано!');}
      if($_GET['id']==''){die('Задание не сдано!');}
      if(strlen(trim($_POST['data']))<12){ die('Ответ не достаточно полон. Нужно сделать задание полностью.');}
      $grade=new grades($_SESSION['email'], $_GET['id']);
          $grade->student=$_SESSION['email'];
          $grade->assignment=$_GET['id'];      
      $grade->submission= $_POST['data'];  
     
       if($grade->submit()){     
           echo '<img src="images/checked.png"/>Задание выполнено! <br/><img src="images/thumb.png"/>';}
                  
      
  }
  
   public function courseisover($student, $course){
        if($_SESSION['disablemenu']){ die('Меню пока отключено!');}
       $fl= new framelist($course);
        $ass=new assignmentlist($fl->getIdbyOrder($fl->number));
     foreach($ass->list as $k=>$v){
         $grade= new grades($student, $k);
         if(!$grade->submitted){ return false;}         
     } 
     return true;
    }

    public function savesubmission(){
  //      if($_SESSION['disablemenu']){ die('Меню пока отключено!');} 
      if($_SESSION['status']>1){die('Эмуляция сохранения задания');}
      if(!isset($_GET['id'])){die();}
      $grade=new grades($_SESSION['email'], $_GET['id']);
      if(!$grade->saved){
          $grade->student=$_SESSION['email'];
          $grade->assignment=$_GET['id'];      
      }
    
      $grade->submission=  html_entity_decode($_POST['data']);     
      if($grade->save()){      echo 'Успешно сохранено до сих пор!';}
      
  }
  
   public function preeviousassignments(){
     if($_SESSION['disablemenu']){ die('Меню пока отключено!');}  
  self::sessioncontrol($_POST['data']);
       $framelist='';
      $plist=new framelist($_SESSION['currentcourse']);
      $plist=$plist->getprevious($_SESSION['email']);
          foreach($plist as $k=>$v){
          $ass=new assignmentlist($k);
          $gradenote='<br/><small>Оценка за задание: ';
          foreach($ass->list as $k1=>$v1){
              $grade=new grades($_SESSION['email'],$k1);
            $fgrade=$grade->grade==2?' пока не оценено': $grade->grade;
              $gradenote.='   <spane style="color:red">'.$fgrade.'</span>. </small>';
              
          }
           $framelist.=<<<a
<div class="asslist" onclick="showassignment('$k')">
<b>{$v['title']}</b> $gradenote       
</div>
a;
          }
      
      $framelist=$framelist==''?'Нечего показывать':$framelist;
       return array('view'=>'currentcourse/framelist', 'title'=>'Список выполненных заданий', 'framelist'=>$framelist);
      
  }
  public function book(){
     if(!isset($_GET['book'])){die();}
    // if(!isset($_SESSION['currentcourse'])){die('У вас нет прав для скачивания данного ресурса');}
     $book=new lib($_GET['book']);
     $links=  json_decode(file_get_contents('convert/knigi'), TRUE);
     
     if(!in_array($book->file, $links)){die('Книга не найдена');}
         $link=$links[$book->file]; 
       
header('Location:'.$link);
       
/*     filemanagement::emptydir('tmp');
$filesec=substr(md5(time()),0,9);
file_put_contents('tmp/'.$filesec, $book->file);
$libaddress='http://mbs.ru/knigi';//.serverchooser::choose('lib');
header('Location:'.$libaddress.'/downloader.php?r='.$filesec);
      */
 
         //       header('Content-Disposition: attachment; filename='.$book->file);
 
            //   header('Content-Length: '.strlen($result));
              // header('Content-Type: application/x-rar-compressed');
  
   
  }
   public function library(){
        if($_SESSION['disablemenu']){ die('Меню пока отключено!');}
         self::sessioncontrol($_POST['data']);
     $new='';
         $list='';
         $l4c=new lib4course($_SESSION['currentcourse']);
           $links=  json_decode(file_get_contents('convert/knigi'), TRUE);
                 foreach($l4c->list as $k=>$v){
                                      $link=$links[$v['file']]; 
                         $list.=<<<a
  <div class="library"> <a target="_blank" href="$link" >{$v['title']}</a> </div>  
       
a;
         }
         $newa=$l4c->getnew($_SESSION['currentcourse']);
         foreach($newa as $k=>$v){
             $new.='<option value="'.$k.'">'.$v['title'].'</option>';
             
         }
         
         $anycontent=file_exists('protected/data/courses/'.$_SESSION['currentcourse'].'/lib.php')?file_get_contents('protected/data/courses/'.$_SESSION['currentcourse'].'/lib.php'):'';
        return array('list'=>$list,  'anycontent'=> $anycontent);
         
      
      
  }
   public function about(){
  self::sessioncontrol($_POST['data']);
      $about=  file_get_contents('protected/data/courses/'.$_SESSION['currentcourse']."/index.php");
      echo $about;
      
  }
  public function questiontoteacher(){
      if($_SESSION['disablemenu']){ die('Меню пока отключено!');} 
         self::sessioncontrol($_POST['data']);
           
  }
   public function sendquestion(){
        if($_SESSION['disablemenu']){ die('Меню пока отключено!');}
     if(!isset($_POST['data'])){return array('view'=>'administration/error', 'error'=>'Вопрос выслать не удалось');}     
     $feedback=new feedback;
     $feedback->text=$_POST['data'];
     $feedback->user=$_SESSION['email'];
     $feedback->course=$_SESSION['currentcourse'];
     
     $course=new course($_SESSION['currentcourse']);
    $email=$course->teacher=='0'?ADMINEMAIL:$course->teacher;
    
    mailer::send($email, 'Вопрос по курсу '.$course->title, 'Пользователь '.$_SESSION['name'].' '.$_SESSION['fname'].' '.$_SESSION['lname'].' Email: '.$_SESSION['email'].' задал вопрос:<br/> '.$feedback->text);     
   $feedback->ask();
    
   }

  public function futureassignments(){
       if($_SESSION['disablemenu']){ die('Меню пока отключено!');}
       self::sessioncontrol($_POST['data']);
  $framelist='';
      $alist=new framelist($_SESSION['currentcourse']);
      if($nlist=$alist->getnext($_SESSION['email'])){ 
          foreach($nlist as $k=>$v){
           $framelist.=<<<a
<div class="asslist" onclick="showassignment('$k')">
<b>{$v['title']}</b> 
    
   
</div>
a;
          }
      }
      $framelist=$framelist==''?'Нечего показывать':$framelist;
       return array('view'=>'currentcourse/framelist', 'title'=>'Список невыполненых заданий', 'framelist'=>$framelist);    
      
  }
     
  public function paying(){
  if(!isset($_POST['data'])){return array('view'=>'administration/error', 'error'=>'Оплата не прошла');}    
   
  $en=new enrollment($_SESSION['email']);
         if($en->pay($_POST['data'], $_SESSION['currentcourse'])){
             accountant::altermoney($_SESSION['email'],$_SESSION['currentcourse'], 10 );// Задать, сколько идет на бонуса.
             mailer::send(ADMINEMAIL, 'Оплата обучения', 'Была проведена оплата обучения. Проверьте.');
             return array('view'=>'currentcourse/thankyou'); 
         }
   
      
  }
  public function paywithmy(){
  if(!isset($_POST['data'])){return array('view'=>'administration/error', 'error'=>'Оплата не прошла');}    
  $en=new enrollment($_SESSION['email']);
  $sum=-(int)$_POST['data']*0.9;
             accountant::altermoney($_SESSION['email'],$_SESSION['currentcourse'], '', $sum );
             
      $en->register($_SESSION['currentcourse']);
      
      return array('view'=>'administration/index', 'text'=>'Опалата принята. Можете приступать к занятиям.<br/><input type="button" value="OK" onclick="location.reload()"/>');
  }
    public function dontpay(){
    
  $en=new enrollment($_SESSION['email']);            
      $en->register($_SESSION['currentcourse']);
      
      return array('view'=>'administration/index', 'text'=>'Можете приступать к занятиям.<br/><input type="button" value="OK" onclick="location.reload()"/>');
  }
  
  
  
}

?>
