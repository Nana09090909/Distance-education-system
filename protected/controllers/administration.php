<?php

class administration{
   //////////
    public function index(){
        
        return array('layer'=>'administration', 'text'=>'Начальная страница административного раздела');
              
    }
    public function cleancache(){
        filemanagement::emptydir('protected/cache');
    }
    public function mailexport(){
        $mes='';
        $ul=new userlist();
        foreach($ul->list as $k=>$v){
if($k){
    $mes.=<<<a
all@mbs.ru,$k,USER,MEMBER\n
a;
}

        }
        $mes="Group Email [Required],Member Email,Member Type,Member Role\n".$mes;
     return array('mes'=>$mes);   
    }
    
    
    //////////////////////// Переписка
    public function sendresponse(){
  if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не заданы параметры');}
$a=explode('%%SEPARATOR%%',$_POST['code']);


$feedback=new feedback($a[1]);
$user=new user($feedback->user);
$text="Здравствуйте, ".$user->name." ".$user->fname."! <br/> Приводим ответ на ваш вопрос на сайте Московской богословской интернет-семинарии ЕХБ: <br/>".$a[0]."<br/> Вопрос был: <br/>".$feedback->text."<br/> Успехов в учебе!<br/> Администрация МБИС ЕХБ";
 mailer::send($feedback->user, 'Ответ на вопрос на сайте МБИС ЕХБ',$text );
$feedback->response=$a[0];
if($feedback->respond()){
 return array('view'=>'administration/newcreated', 'newcreated'=>'Ответ выслан на адрес '.$feedback->user);
  }else{return array('view'=>'administration/error', 'error'=>'Ответ выслать не удалось!');}
    
}
public function deletefeedback(){
if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не заданы параметры');}
$feedback=new feedback($_POST['code']);
if($feedback->del()){
return array('view'=>'administration/newcreated', 'newcreated'=>'Вопрос удален!');
}else{return array('view'=>'administration/error', 'error'=>'Вопрос не был удален!');}
   
}
    
    public function feedback(){
     $text=self::feedbackgen('');    
 return array('layer'=>'administration','text'=>$text);
            }
    
    public static function feedbackgen($course){
           $text='';
         $flist=new feedbacklist($course);
 
 foreach($flist->newones as $k=>$v){
     $user=new user($v['user']);
     $text.=<<<a
<tr><td>{$user->name} {$user->fname} {$user->lname}</td><td>{$v['user']} {$v['date']}</td><td> {$v['text']}</td><td><textarea>Ответ</textarea><button  onclick="var v=$(this).prev().val()+'%%SEPARATOR%%'+'$k';  display('sendresponse',v)">Ответить</button></td><td><div class="del"  onclick="display('deletefeedback', $k)"></button></td></tr>   
a;
 }
     $text=$text==''?'Нет заданых вопросов':$text;
return $text;        
    }
    public function feedbackold(){
        $text='';
     
 $flist=new feedbacklist('');
 
 foreach($flist->responded as $k=>$v){
     $user=new user($v['user']);
     $text.=<<<a
<tr><td>{$user->name} {$user->fname} {$user->lname}</td><td>{$v['date']}</td><td> {$v['text']}</td><td>Ответ<br/>{$v['response']}</td><td><div class="del"  onclick="display('deletefeedback', $k)"></button></td></tr>   
a;
 }
     $text=$text==''?'Нет заданых вопросов':$text;
 
 return array('layer'=>'administration', 'text'=>$text, 'view'=>'administration/feedback');
        
    }
  //////// Пользователи  
    public function saveuserchanges(){
        
  if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$_POST['email'])){return array('view'=>'administration/error', 'error'=>'Электронная почта введена неправильно Не заданы параметры');}

  $user=new user($_POST['key']);
  $user->name=trim($_POST['name']);
  $user->fname=trim($_POST['fname']);
  $user->lname=trim($_POST['lname']);
  $user->info=trim($_POST['info']);
  $user->address=trim($_POST['address']);
  $user->email=trim(strtolower($_POST['email']));
  $user->skype=trim($_POST['skype']);
  $user->status=$_POST['status']=='0'?$user->status:$_POST['status'];
  $user->password=trim($_POST['password'])==''?$user->password:md5(trim($_POST['password']));
  $user->phone=trim($_POST['phone']);
  if($user->renew($_POST['key'])){
 return array('view'=>'administration/newcreated', 'newcreated'=>'Сведения о студенте успешно обновлены');
  }else{return array('view'=>'administration/error', 'error'=>'Обновить запись не удалось');}
        
    }
    ///
      public function createnewuser(){
         
  if(!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$_POST['email'])){return array('view'=>'administration/error', 'error'=>'Электронная почта введена неправильно Не заданы параметры');}
  foreach($_POST as $k=>$p){if(trim($p)=='' AND $k!='key'){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не заданы параметры');}}
  $user=new user($_POST['key']);
  $user->name=trim($_POST['name']);
  $user->fname=trim($_POST['fname']);
  $user->lname=trim($_POST['lname']);
  $user->info=trim($_POST['info']);
  $user->address=trim($_POST['address']);
  $user->email=trim(strtolower($_POST['email']));
  $user->skype=trim($_POST['skype']);
  $user->status=$_POST['status']=='0'?'1':$_POST['status'];
  $user->phone=trim($_POST['phone']);
  if($user->register($_POST['password'])){
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
<h1 style="color: #0000ff;"><em><span style="background-color: #ffffff;"> Здравствуйте, {$user->name} {$user->fname}! </span></em></h1>
    Вы успешно зарегистрированы на сайте дистанционного обучения МБС ЕХБ http://mbis.su .<br/>
 Ваши данные в системе:<br/>
 Логин: {$user->email}<br/>
 Пароль: {$_POST['password']}<br/>
  Вы можете выбрать автоматическую авторизацию, чтобы не вводить эти данные каждый раз.<br/>
Выбрать курсы для обучения можно здесь: <a href="http://mbis.su/index.php#listofcourses">http://mbis.su/index.php#listofcourses</a> .<br />Для начала рекомендуется пройти бесплатный вводный курс <a href="http://mbis.su/index.php?r=currentcourse&amp;id=intro">http://mbis.su/index.php?r=currentcourse&amp;id=intro</a> .<br /><br />Вопросы по обучению можно задать, просто ответив на данное письмо.<br />Желаем обильных благословений в учебе.<br /><br />Команда МБИС<br /><br /><br /></div>
</div> 
a;
mailer::send($user->email, 'Регистрация в МБИС ЕХБ', $message); 
      
 return array('view'=>'administration/newcreated', 'newcreated'=>'Новый пользователь создан');
  }else{return array('view'=>'administration/error', 'error'=>'Его создать не удалось');}
        
    }
    
    ////
    public function edituser(){
  if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не заданы параметры');}
  $user=new user($_POST['code']);
 $firstpart=$user->generatefields('foradmin');
 return array('view'=>'administration/edituser','fields'=>$firstpart);
  
  }
  public function deleteuser(){
  if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не заданы параметры');}
  $user=new user($_POST['code']);
 $user->del();
 return array('view'=>'administration/newcreated', 'newcreated'=>'Все! Юзер теперь в прошлом');
  
  }
    public function altermoney(){
  if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не заданы параметры');}
  $v=explode('%%SEPARATOR%%', $_POST['code']);
  $user=new user($v[0]);
  $user->money=$v[1];
 $user->renew();
 return array('view'=>'administration/newcreated', 'newcreated'=>'Деньги изменены');
  
  }
  
  public function excludestudent(){
      if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не заданы параметры');}
  $a=explode('/',$_POST['code']);
  $en=new enrollment($a[0]);
  if($en->quit($a[1])){
    return array('view'=>'administration/newcreated', 'newcreated'=>'Студенту теперь меньше работы');   
  }else{
    return array('view'=>'administration/error', 'error'=>'Студент все еще там записан');  
  }
  
  }
  
  
  public function editusercourses(){
        $text='';
 if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не заданы параметры');}
 $student=new user($_POST['code']);
  $en=new enrollment($_POST['code']);

 
  foreach($en->courses as $k=>$v){
    
         $course=new course($k);
         $finalgrade=$v['finalgrade']=='0'?'Оценки пока нет':$v['finalgrade'];
         $finishdate=$v['finishdate']=='0'?'В процессе':$v['finishdate'];
         if(($v['paid']=='0')||($v['paid']=='1')){ $register="<button onclick=\"display('acceptpayment', '{$_POST['code']}/$k')\">Открыть курс</button>";}else{
             $register="<button onclick=\"display('rejectpayment', '{$_POST['code']}/$k')\">Неоплачен!</button>";
         }
         $text.=<<<a
 <tr><td>{$course->title}</td></tr><tr><td>Дата записи: {$v['enrollmentdate']}<br/>Дата окончания: $finishdate</td></tr><tr><td>Оценка:<br/>$finalgrade </td></tr> 
<tr><td><button onclick="display('excludestudent', '{$_POST['code']}/$k')">Исключить</button>$register</td></tr>     
<tr><td><hr/></td></tr>
a;
           }
           $text=$text==''?'Пока студент никуда не записан':$text;
      
  return array('user'=>$student->lname.' '.$student->name.' '.$student->fname, 'listofcourses'=>$text );       
      
  }
  
   public function users(){
       $students=$teachers=$admins='';
       $years=array();
       $users=new userlist();
        foreach ($users->list as $k=>$v){
            $delete=$k==$_SESSION['email']?'':'<div onclick="if(confirm(\'Удаляем мерзавца?\')){display(\'deleteuser\',\''.$k.'\');}" class="del"></div>';
            $year=substr($v['date'],0,4);            
           $str='<tr>
               <td> '.$v['lname'].' '.$v['name'].' '.$v['fname'].' </td>
               <td> Email: '.$k.' <br/>Телефон: '.$v['phone'].' <br/> Aдрес: '.$v['address'].' <br/> Скайп: '.$v['skype'].' </td>
                   <td> Деньги: <input type="text" value="'.$v['money'].'"/><input type="button" onclick="if(confirm(\'Вы хотите изменить счет пользователя?\')){display(\'altermoney\',\''.$k.'%%SEPARATOR%%\'+$(this).prev().val());}" value="Сохранить"/> </td>
               <td> Личная информация: '.$v['info'].'; Дата регистрации: '.$v['date'].' </td>
                   <td>'.$delete.'<div onclick="display(\'edituser\',\''.$k.'\')" class="edit"></div><div onclick="display(\'editusercourses\',\''.$k.'\')" class="editusercourses"></div></td>               
</tr>';     
           // For statistics
           if($v['status']==1){
               if($year!=0){
                   
                   if(array_key_exists($year,$years)){
                   $years[$year]++;
               }else{
                   $years[$year]=0;
               }
               }
               
           }
           ///////////////////////////
           switch ($v['status']){
              case '1':
           $students.=$str;    
           break;
       case '2':
           $teachers.=$str;    
           break;
               case '3':
           $admins.=$str;    
           break;
           }
           
       }
       /// Count of entrants
       $statistics='';
       $tn=0;
       ksort($years);
       foreach($years as $k=>$v){
           $tn+=$v+1;
                      $v++;
           $statistics.='В '.$k.' году зачислено '.$v.' чел.; <br/>';
       }
       $statistics.='Всего обучается '.$tn.' чел..';
             return array('layer'=>'administration','users'=>$students,'teachers'=>$teachers,'admins'=>$admins, 'statistics'=>$statistics);
          
          }
     public function newuser(){
          $user=new user;
             return array('newuser'=>$user->generatefields('foradmin'));
     }
    public function payment(){
        $text='';
        $en=new enrollmentlist;
        foreach($en->justpaid as $k=>$v){
            $user=new user($v['student']);
            $course=new course($v['course']);
            $text.='<tr><td>Студент '.$user->lname.' '.$user->name.' '.$user->fname.' говорит, что оплатил курс '.$course->title.'. </td><td>Его сообщение:<br/> '.$v['payment'].'</td><td> <button onclick="display(\'acceptpayment\',\''.$v['student'].'/'.$v['course'].'\') ">Подтвердить</button> <button onclick="display(\'rejectpayment\',\''.$v['student'].'/'.$v['course'].'\') ">Отвергнуть</button></td></tr>' ;
            
        }
        $text=$text==''?'В настоящее время новой оплаты нет!':$text;
          return array('layer'=>'administration','payments'=>$text);
        
    }
    public function acceptpayment(){
  if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не заданы параметры');}
  $f=explode('/',$_POST['code']);
  $en=new enrollment($f[0]);

  
  if($en->register($f[1])){ return array('view'=>'administration/newcreated', 'newcreated'=>'Студент успешно принят на курс'); }
  else{return array('view'=>'administration/error', 'error'=>'И ни фига...');}
        
    }
    public function rejectpayment(){
  if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не заданы параметры');}
  $f=explode('/',$_POST['code']);
  $en=new enrollment($f[0]);
  if($en->notpaid($f[1])){
      accountant::altermoney( $f[0], $f[1], -10);
      return array('view'=>'administration/newcreated', 'newcreated'=>'Студент в пролёте'); }
  else{return array('view'=>'administration/error', 'error'=>'И ни фига...');}
        
    }
///////////////////////
//
//               FRaMES
//
////////////////////////
    
  public function saveedittedframe(){
  if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не задан код фрейма');}
  $f=explode('%%SEPARATOR%%',$_POST['code']);
  $frame=new frame($f[0]);
  $frame->title=$f[2];
  $frame->desc=$f[1];
  $frame->renew();
  return array('view'=>'administration/newcreated', 'newcreated'=>'Фрейм успешно обновлен');
          }
          //
          public function editassignment(){
  if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не задан код фрейма');}
  $ass=new assignment($_POST['code']);
  $auto=$ass->auto=='0'?'':'checked="checked"';
   $types=new atypelist;
  $options=$types->makeoptions();
  return array('view'=>'administration/editassignment', 'params'=>str_replace('>','&gt;',str_replace('<','&lt;',$ass->params)), 'html'=>$ass->html,'id'=>$ass->id, 'auto'=>$auto, 'types'=>$options);             
          }
          //
          public function saveassignment(){
  if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не задан код фрейма');}
  $c=explode('/SEPARATOR/',$_POST['code']);
  $ass=new assignment($c[1]);
  $ass->params=$c[0];
  $ass->auto=$c[2]=='true'?'1':'0';
   $ass->renew();
  return array('view'=>'administration/newcreated', 'newcreated'=>'Задание успешно обновлено');
          }
public function deleteassignment(){
  if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не задан код фрейма');}
  $ass=new assignment($_POST['code']);
  $ass->del();
  return array('view'=>'administration/newcreated', 'newcreated'=>'Задание успешно удалено');
    
              
          }
    public function compilecourse(){
        include('protected/includes/frametemplates.php');
        $frametext='';
      if(!isset($_GET['code'])){
          return array('layer'=>'administration', 'view'=>'administration/error', 'error'=>'Не верное обращение к странице');
      }
      $course=new course(trim($_GET['code']));
      $framelist=new framelist($_GET['code']);
      foreach($framelist->list as $k=>$v){
          $up=<<<a
       <button class="up" onclick="display('moveframeup',$k)" /></button>
a;
$up=$v['order']==1?'':$up;  
 $down=<<<a
       <input type="button" class="down" onclick="display('moveframedown',$k)"/>
a;
$down=$v['order']==$framelist->number?'':$down;  
$ass=new assignmentlist($k);
$assignments='';
foreach($ass->list as $k1=>$v1){
 $a=new assignment($k1);
    $assignments.="<span class=\"ass\" onclick=\"display('editassignment','".$a->id."');\">".$a->title."</span> ";
    
   $assignments.='<br/>Автооценка '.$a->auto.'<br/>';
   
  
        }
        $assignments=$assignments==''?"Нет":$assignments;
$frametext.=<<<a
<tr><td>Фрейм номер {$v['order']}<br/><b>{$v['title']}</b></td><td><input type="button"  class="edit" onclick="display('editframe',$k)" />$up $down<input type="button" class="del" onclick="if(confirm('Подтвердите удаление этого фрейма')){display('deleteframe',$k)}" /></td><td>Задания:<br/> $assignments <input type="button" onclick="display('addassignment',$k)" class="add"/> </td></tr>
a;
 }
      return array('layer'=>'administration', 'course'=>$course->title, 'framelist'=>$frametext, 'frametemplates'=>$frametemplates, 'code'=>$_GET['code']);
  }
public function addassignment(){
  if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не задан код фрейма');}
  $frame=new frame($_POST['code']);
  $types=new atypelist;
  $options=$types->makeoptions();
      return array('view'=>'administration/addassignment', 'frame'=>$_POST['code'],'types'=> $options, 'order'=>$frame->order);
         
}

public function savenewass(){
      if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не задан код курса');}
      $ass=new assignment;
      $ass->code=$_POST['code'];
      $ass->params=$_POST['params'];
      $ass->frame=$_POST['frame'];
$ass->auto=$_POST['auto']=='true'?'1':'0';
      if($ass->add()){
        return array('view'=>'administration/newcreated', 'newcreated'=>'Задание успешно добавлено'); 
      }else{
         return array('view'=>'administration/error', 'error'=>'Задание не сохранено из-за какой-то ошибки.'); 
      }
      
}
  public function changeasstype(){
       if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не задан код курса');}
        if(!isset($_POST['id'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не задан код курса');}
     $ass=new assignment ($_POST['id']);
     if($ass->nuevo){return array('view'=>'administration/error', 'error'=>'Задание не найдено');         
     }
        $ass->code=$_POST['code'];
      $ass->params=$_POST['params'];
      $ass->auto=$_POST['auto']=='true'?'1':'0';
      $ass->renew();
       return array('view'=>'administration/newcreated', 'newcreated'=>'Задание успешно обновлено');
  }
  public function newframe(){
      if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не задан код курса');}
      $framelist=new framelist($_POST['code']);
      $newframe=new frame;
      $newframe->course=$_POST['code'];
      $newframe->title=$_POST['title'];
      $newframe->desc=$_POST['desc'];
      $newframe->order=$framelist->number+1;
      $newframe->add();
      return array('view'=>'administration/newcreated', 'newcreated'=>'Новый фрейм успешно добавлен'); 
  }
 
  public function editframe(){
      if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не задан код фрейма');}
      $frame=new frame($_POST['code']);
      return array('view'=>'administration/editframe', 'code'=>$_POST['code'], 'desc'=>  str_replace('>','&gt;',str_replace('<','&lt;',$frame->desc)), 'title'=> str_replace('"','&quot;',$frame->title), );
       }
  public function deleteframe(){
       if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не задан код фрейма');}
      $oldframe=new frame($_POST['code']);
      $order=$oldframe->order;
      $framelist=new framelist($oldframe->course);
     
      foreach($framelist->list as $k=>$v){
 
          if($order<$v['order']){
              $id=$framelist->getIdbyOrder($v['order']);
              $frame=new frame($id);
                $frame->moveup();
          }
      }
      $oldframe->del();
      return array('view'=>'administration/newcreated', 'newcreated'=>'Фрейм успешно удален'); 
      
  }
  
  public function moveframeup(){
       if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не задан код фрейма');}
      $oldframe=new frame($_POST['code']);
      $framelist=new framelist($oldframe->course);      
      $oldframe->moveup();
      $id=$framelist->getIdbyOrder($oldframe->order);
      $newframe=new frame($id);
      $newframe->movedown();
      
  return array('view'=>'administration/reload'); 
  }
  
  public function moveframedown(){
      if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не задан код фрейма');}
      $oldframe=new frame($_POST['code']);
       $framelist=new framelist($oldframe->course);   
      $oldframe->movedown();
      $id=$framelist->getIdbyOrder($oldframe->order);
      $newframe=new frame($id);
      $newframe->moveup();
      
  return array('view'=>'administration/reload'); 
  }

  public function chooseparams(){
       if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя');}
        $atype=new atype(trim($_POST['code']));
        if($_POST['code']=='0'){return array('view'=>'site/empty');}
      /* $params=explode(';', $atype->params);
       foreach($params as $params){
           if($params!=''){
           $p=explode('=',$params);
           $text.='<input type="text" placeholder="'.trim($p[0],'%%').'"/>';
           }
           
           }*/
        return array('params'=>$atype->params);
      
  }
    
 /////////////
 //  КУРСЫ
 //   
 //////////
  public function courses(){
      $course='';
        $list=new courselist('all');
        $userlist=new userlist;
        if(count($list->list)<1){$course='Курсов пока нет';}
        $n=0;
           foreach($list->list as $k=>$v){
               $n++;
    $teacher=isset($userlist->list[$v['teacher']])?$userlist->list[$v['teacher']]['lname'].' '.$userlist->list[$v['teacher']]['name'].' '. $userlist->list[$v['teacher']]['fname']:'не назначен ';
    $status=$v['status']==1?'Опубликован':'Неопубликован';
    $obligatory=$v['obligatory']=='1'?'Обязательный':'Факультативный';
                   $course.="<tr><td><b>".$n.'. '.$v['title'].":</b> </td><td>Стоимость: ".$v['price']."<br/>Кредитов: ".$v['credits']."<br/>$obligatory</td><td>Учитель: ".$teacher."</td><td>".$status."</td><td> <button onclick=\"display('preparecourseedit','".$k."')\">Редактировать</button> <button onclick=\"if(confirm('Да вы с с ума сошли! Вы действительно хотите удалить этот прекрасный курс?')){display('deletecourse','".$k."');}\" >Удалить</button><button onclick=\"location.replace('index.php?r=administration/compilecourse&code=".$k."')\">Компановать</button></td></tr> ";
           
        }
        include('protected/includes/categories.php');
        return array('layer'=>'administration', 'courses'=>$course, 'categories'=>$categories);
    }
    
    public function newcourse(){
        if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Произошла ошибка при создании : Не определен код курса');}
        $course=new course($_POST['code']);
                $course->title=trim($_POST['title']);
        $course->desc=trim($_POST['desc']);
        $course->category=trim($_POST['category']);
        $course->price='0';
            cache::delete('listofcourses'.$course->category);
            cache::delete('listofcourses');
        if($course->add()){
            mkdir('protected/data/courses/'.$course->code);
                mkdir('protected/data/courses/'.$course->code.'/lib');
                mkdir('protected/data/courses/'.$course->code.'/assets');
                
$asscontent=<<<a
<h2>Нагрузка:</h2>
<p>40 астр. часов.</p>
<h2>Лектор:</h2>
<p>*******</p>
<h2>Цель курса:</h2>
<p>*******</p>
<h2>Задачи курса:</h2>
<p>*******</p>

<h2>Описание курса:</h2>
<p>*******</p>
<h2><span>Формы контроля и система оценки.&nbsp; </span></h2>
<p>Финальной формой отчета является *******.</p>
<p><span>Оценка за курс складывается из:</span></p>
<p>*******</p>
<p><span>Градация оценки полученных знаний: </span></p>
<p class="p20"><span>Оценка &laquo;5&raquo; отлично ставится при балле свыше 90%.</span></p>
<p class="p20"><span>Оценка &laquo;4&raquo; хорошо &ndash; при балле свыше 80%.</span></p>
<p class="p20"><span>Оценка &laquo;3&raquo; удовлетворительно &ndash; при балле свыше 70%.</span></p>
a;
                file_put_contents('protected/data/courses/'.$course->code.'/index.php', $asscontent);
            return array('view'=>'administration/newcreated', 'newcreated'=>'Новый курс "'.$_POST['title'].'" создан');
        }else{return array('view'=>'administration/error', 'error'=>'Произошла ошибка базы данных при создании курса');}
    }
    ///////////
    public function checkcoursecode(){
        $course= new course(trim($_POST['code']));
       
        if (!$course->nuevo){
                
            return array('view'=>'administration/occupied');
        }
        
    }
        
    ////////////
        public function deletecourse(){
          if(!isset($_POST['code'])){die();}
            $course=new course(trim($_POST['code']));
                cache::delete('listofcourses'.$course->category);
            cache::delete('listofcourses');
            if($course->del()){
            return array('view'=>'administration/newcreated', 'newcreated'=>'Курс удален. Не забудьте стереть папку protected/data/courses/ "'.$_POST['code'].'".');
            }else {return array('view'=>'administration/error', 'error'=>'На курсе есть студенты. Его нельзя удалить');}
        }
        ///////////////////
         public function preparecourseedit(){
    if(!isset($_POST['code'])){return array( 'view'=>'administration/error', 'error'=>'Не правильное обращение к странице');}
$course=new course(trim($_POST['code']));
 include('protected/includes/categories.php');
 include('protected/includes/status.php');
 $categories=  str_replace($course->category.'"', $course->category.'" selected="selected"', $categories);
 $teachers=new userlist;
 $teacheroptions=$teachers->maketeacheroptions();
   $obligatory=$course->obligatory=='0'?'':'checked="checked"';
 $teacher=str_replace($course->teacher.'"',$course->teacher.'" selected="selected" ', $teacheroptions );
 $status=str_replace('value="'.$course->status.'"','value="'.$course->status.'" selected="selected"', $status );
return array('code'=> $course->code,'title'=> $course->title,'price'=>$course->price,'desc'=> $course->desc,'categories'=>$categories,'status'=> $status,'teacher'=> $teacher, 'credits'=>$course->credits, 'obligatory'=>$obligatory );          
                      }

    public function editcourse(){
      if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя');}
        $course=new course;
        $course->code=trim($_POST['code']);
        $course->title=trim($_POST['title']);
        $course->desc=trim($_POST['desc']);
         $course->teacher=trim($_POST['teacher']);
          $course->status=trim($_POST['status']);
           $course->credits=trim($_POST['credits']);
           $course->obligatory=$_POST['obligatory']=='true'?'1':'0';
           $course->price=trim($_POST['price']);
        $course->category=trim($_POST['category']);
        if($course->renew()){
            cache::delete('listofcourses'.$course->category);
            cache::delete('listofcourses');
            
            return array('view'=>'administration/newcreated', 'newcreated'=>'Курс "'.$_POST['title'].'" обновлен');
        }else{return array('view'=>'administration/error', 'error'=>'Произошла ошибка при редактировании курса');}  
    }

 /////////////////// Типы заданий
         public function assignments(){
             $m='';
             $list=new atypelist;
          
             if ($list->number==0){
                 $m='Заданий пока не создано';
             }else{
                 foreach($list->list as $k=>$v){
             
                 $m.=<<<a
<tr ><td> <b>Имя:</b> {$v['title']}</td><td> Код: $k </td><td><input type="button" class='del' onclick="if(confirm('Подтвердите удаление этого типа')){display('deleteatype','$k')}"/><input type="button" class="edit" onclick="display('prepareatype','$k')"/></td></tr>
            
a;
              }
             return array('layer'=>'administration', 'assignments'=>$m);
             
         }
         }
         ////////////
    public function prepareatype(){
        $code=trim($_POST['code']);
        $type=new atype($code);
        return array('html'=>  htmlentities($type->html, ENT_QUOTES, "UTF-8"), 'params'=>$type->params, 'title'=>$type->title, 'code'=>$type->code);
    }
    ////
    public function editatype(){
      if(!isset($_POST['code'])){return array('view'=>'administration/error', 'error'=>'Так нельзя');}
        $type=new atype(trim($_POST['code']));
        $type->title=trim($_POST['title']);
        $type->html=  html_entity_decode (trim($_POST['html']),ENT_QUOTES, "UTF-8");
        $type->params=trim($_POST['params']);
        if($type->renew()){
            return array('view'=>'administration/newcreated', 'newcreated'=>'Задание "'.$_POST['title'].'" обновлено');
        }else{return array('view'=>'administration/error', 'error'=>'Произошла ошибка при редактировании задания');}      
        
        
    }
    public function newatype(){
        $code=trim($_POST['code']);
        $type=new atype($code);
        if($type->nuevo){
            $type->title=trim($_POST['title']);
            $type->html=html_entity_decode (trim($_POST['html']));
            $type->params=trim($_POST['params']);
            $type->code=trim($_POST['code']);
            $type->create();   
            return array('view'=>'administration/newcreated', 'newcreated'=>'Новый тип создан успешно');
        }else{ return array('view'=>'administration/error', 'error'=>'Уже есть задание с таким кодом');}
        
        
    }
    //////////
    public function deleteatype(){
        $code=trim($_POST['code']);
        $type=new atype($code);
        if(!$type->nuevo){
            if(!$type->del()){
                return array('view'=>'administration/error', 'error'=>'Данный тип используется.');
            }            
        }else{ return array('view'=>'administration/error', 'error'=>'Тип не существует.');}
        
        
    }
    public function givethem(){
        //var_dump($_POST['code']);
        $sum=(int)$_POST['code']==''?0:(int)$_POST['code'];
        
        $ul=new userlist();
        foreach($ul->list as $k=>$v){
        accountant::putmoney($k,$sum); 
     //   echo 'На почту '.$k.' дано'.$sum; 
        }
        
       return array('view'=>'administration/newcreated', 'newcreated'=>'Всем студентам было положено '.$sum.' рублей.');  
        
    }

}

?>
