<?php
class classroom{
/////////Дрова  
   public function index(){
//       $gr=self::gradebook();
        
$gr=$_SESSION['status'] == '1'? self::gradebook() : self::gradeassignment(); 
$grs=$_SESSION['status'] == '1'?'gradebook':'gradeassignment';
  return array('layer'=>'classroom', 'view'=>'classroom/'.$grs,)+$gr;    
   }
    public function menu(){
       
      
       return array('view'=>'classroom/'.$_POST['data'],)+self::processmenu($_POST['data']);
          }
    
  private function processmenu($data) {
              switch( $data){
                  case 'gradeassignment':
                   return  self::gradeassignment(); 
              break;
            case 'correspondance':
                   return  self::correspondance(); 
              break;
          case 'gradecourse':
     
              return  self::gradecourse(); 
              break;
             case 'certificates':
     
              return  self::certificates(); 
              break;
            case 'explorecourses':
                   return  self::explorecourses(); 
              break;
                  case 'gradebook':
                   return  self::gradebook(); 
              break;
          case 'checkassignment':
                         return  self::checkassignment(); 
              break;
                 case 'enrollment':
          return  self::enrollment(); 
                        break;
                default:
                 return array();
                     break;
                
             
              }
          }

          
  
////////////// Учительская часть
 
 public function fail(){
       if($_SESSION['status']<2){die('Только для преподавателей');}        
    if(!isset($_POST['data'])){ return array('view'=>'administration/error', 'error'=>'Неверное обращение');}   
    $v=explode('%%SEPARATOR%%', $_POST['data']);
    $grade=new grades('','',$v[1]);
    $ass=new assignment($grade->assignment);
    $frame=new frame($ass->frame);
    $course=new course($frame->course);    
    $student=new user($grade->student);
  $enrollment=new enrollment($grade->student);  
  if($grade->fail()){ 
      if($enrollment->courses[$frame->course]['finalgrade']=='1'){
          $enrollment->fail($frame->course);
      }
       $message=<<<a
   Здравствуйте, {$student->name} {$student->fname}!<br/>
К сожалению, Ваше задание по курсу <b>{$course->title}</b> было отвергнуто!<br/>
Вам следует его переделать.<br/>

С уважением<br/>
Команда МБИС ЕХБ<br/> 
<b>Название задания: </b>{$frame->title}<br/>
<b>Содержание задания: </b>{$frame->desc}<br/>
    <b>Комментарии преподавателя</b>:<br/>{$v[0]}<br/>
      
a;
      mailer::send($grade->student, 'Оценка задания по курсу '.$course->title, $message);
    
     
       return array('view'=>'administration/index', 'text'=>'Студент успешно провалил задание');
        
   }else{return array('view'=>'administration/error', 'error'=>'Задание не получилось оценить');}
   }
   
/////////
      public function passed(){
            if($_SESSION['status']<2){die('Только для преподавателей');}        
    if(!isset($_POST['data'])){ return array('view'=>'administration/error', 'error'=>'Неверное обращение');}   
    $grade=new grades('','',$_POST['data']);
    $ass=new assignment($grade->assignment);
    $frame=new frame($ass->frame);
    $course=new course($frame->course);    
    $student=new user($grade->student);
   if($grade->passed()){ 
       $message=<<<a
   Здравствуйте, {$student->name} {$student->fname}!<br/>
Ваше задание по курсу <b> {$course->title}</b> было одобрено!<br/>
Вы можете продолжить выполнение заданий по данному курсу.<br/>
С уважением<br/>
Команда МБИС ЕХБ <br/>
<b>Название задания:</b> {$frame->title} <br/>
<b>Содержание задания:</b> {$frame->desc} <br/>
      
a;
     //  mailer::send($grade->student, 'Одобрение последнего задания по курсу '.$course->title, $message);
        return array('view'=>'administration/index', 'text'=>'Задание принято');
        
      }else{return array('view'=>'administration/error', 'error'=>'Задание не получилось оценить');}
   }
   public function gradeass(){
         if($_SESSION['status']<2){die('Только для преподавателей');}        
    if(!isset($_POST['data'])){ return array('view'=>'administration/error', 'error'=>'Неверное обращение');}   
    $v=explode('%%SEPARATOR%%', $_POST['data']);
   $grade=new grades('','',$v[2]);
   $grade->comments=$v[0];
   $grade->grade=$v[1];
   $ass=new assignment($grade->assignment);
    $frame=new frame($ass->frame);
    $course=new course($frame->course);    
    $student=new user($grade->student);
    if(   $grade->grade()){
        
      $message=<<<a
   Здравствуйте, {$student->name} {$student->fname}!<br/>
Преподаватель оценил Ваше задание по курсу <b> {$course->title}</b>. <br/>
<b>Оценка: </b><br/>
{$grade->grade}
<br/>
<b>Комментарии: </b><br/>
{$grade->comments}
<br/>
С уважением<br/>
Команда МБИС ЕХБ <br/>
<b>Название задания:</b> {$frame->title} <br/>
<b>Содержание задания:</b> {$frame->desc} <br/>
      
a;
       // mailer::send($grade->student, 'Оценка задания по курсу '.$course->title, $message);
        return array('view'=>'administration/index', 'text'=>'Задание принято');    
        
        
        
        
    }          
   }
   public function savemodified(){
       if($_SESSION['status']<2){die('Только для преподавателей');}        
    if(!isset($_POST['data'])){ return array('view'=>'administration/error', 'error'=>'Неверное обращение');}   
    $v=explode('%%SEPARATOR%%', $_POST['data']);
     $grade=new grades('','',$v[1]);
     $grade->submission=$v[0];
    $grade->save();
    return array('view'=>'classroom/gradeassignment')+self::gradeassignment();
       
   }
   private function grass($depth){
         if($_SESSION['status']<2){die('Только для преподавателей');}        
       $text='';
       $gl=new gradelist($depth);
         if (count($gl->list)==0){
           $text='<tr><td>Текущик проверок нет!</td></tr>';
           return array('text'=>$text); }
       foreach($gl->list as $k=>$v){
            $student= new user($v['student']);
           $ass=new assignment($v['assignment']);
           $frame=new frame($ass->frame);
           $course=new course($frame->course);
           if($_SESSION['status']==2){if($course->teacher != $_SERVER['email']){continue;}}
            $passed='<button onclick="check(\''.$k.'\', this, \'passed\');">Принять</button>';
       $already='<div style="font-size:24px; color:red">Задание принято</div>';
       include('protected/includes/gradesys.php');
       $grade= '<select>'.$gradesys.'</select><textarea>Комментариев нет</textarea><button onclick="grade(\''.$k.'\', this);">Оценить задание</button>';
       $grade=$depth=='1'?'':$grade;
       $passed=$depth=='2'?'':$passed;
       $already=$depth=='2'?'':$already;
     
       $fail='<textarea>Отвергнуто без комментариев</textarea><button onclick="var data=$(this).prev().val()+\'%%SEPARATOR%%\'+\''.$k.'\';  check(data, this, \'fail\');">Незачет</button>';
       
           $assessment=$v['grade']=='1'?$passed.'<br/>**************<br/>'.$fail.'<br/>**************<br/>'.$grade:$already.'<br/>**************<br/>'.$grade.'<br/>**************<br/>'.$fail;
           
           $text.=<<<a
  <div class="gradeassignment"><hr/>
   <div>Студент</b> {$student->lname} {$student->name} {$student->fname} <i>{$student->email}</i> </div>
  <div>Курс: <b> {$course->title}</b> </div>
       <div><b>Задание:</b><br/>
  {$frame->title} {$frame->desc}<br/>
         <span style="color:red; cursor:pointer" onclick="$(this).next().toggle()">Показать ответ</span><div style="display:none">{$v['submission']}</div>
   <div style="display:none" ><textarea>{$v['submission']}</textarea><input type="button" value="Изменить задание" onclick="display( 'savemodified', $(this).prev().val()+'%%SEPARATOR%%$k')" /></div><input type="button" value="Редактировать ответ" onclick="$(this).prev().toggle()"/>             
</div>
<div class="assess">$assessment</div>          
<br/ >***********************</div>
a;
            
            
           
           
           
           
       }
           
           
       /*if( $_SESSION['status']==2){$cl=new courselist('all','',$_SESSION['email']);}
       if ($_SESSION['status']==3){$cl=new courselist;}
       foreach($cl->list as $clk=>$clv){
       $framelist=new framelist($clk);
       $c2g=$framelist->listtograde($depth);
      if(count($c2g)>0){
       foreach ($c2g as $k=>$v){
           $student= new user($v['student']);
       $passed='<button onclick="check(\''.$k.'\', this, \'passed\');">Принять</button>';
       $already='<div style="font-size:24px; color:red">Задание принято</div>';
       include('protected/includes/gradesys.php');
       $grade= '<select>'.$gradesys.'</select><textarea>Комментариев нет</textarea><button onclick="grade(\''.$k.'\', this);">Оценить задание</button>';
       $grade=$depth=='1'?'':$grade;
       $passed=$depth=='2'?'':$passed;
       $already=$depth=='2'?'':$already;
     
       $fail='<textarea>Отвергнуто без комментариев</textarea><button onclick="var data=$(this).prev().val()+\'%%SEPARATOR%%\'+\''.$k.'\';  check(data, this, \'fail\');">Незачет</button>';
       
           $assessment=$v['grade']=='1'?$passed.'<br/>**************<br/>'.$fail.'<br/>**************<br/>'.$grade:$already.'<br/>**************<br/>'.$grade.'<br/>**************<br/>'.$fail;
           $text.=<<<a
  <div class="gradeassignment"><hr/>
   <div>Студент</b> {$student->lname} {$student->name} {$student->fname} <i>{$student->email}</i> </div>
  <div>Курс: <b> {$clv['title']}</b> </div>
       <div><b>Задание:</b><br/>
  {$v['frametitle']} {$v['framedesc']}<br/>
      <span style="color:red; cursor:pointer" onclick="$(this).next().toggle()">Показать ответ</span><div style="display:none">{$v['submission']}</div></div>
<div class="assess">$assessment</div>          
<br/ >***********************</div>
a;
       }
       }
       }
        *  
        */
       if($text==''){$text='<tr><td>Текущие проверки есть!</td></tr>';}
    return array('text'=>$text);   
       
       
       
   }
   
   public function checkassignment(){

       return self::grass(1);   
   }
   public function gradeassignment(){
   return self::grass(2);   
   }
  ///////////////////////////
   public function savegradedcourse(){
         if($_SESSION['status']<2){die('Только для преподавателей');}        
        if(!isset($_POST['data'])){ return array('view'=>'administration/error', 'error'=>'Неверное обращение');} 
   $v=explode('%%SEPARATOR%%', $_POST['data']);
   $student=new user($v[1]);
   $course=new course($v[2]);
   $framelist=new framelist($v[2]);
   $fl=$framelist->gradebookarray($v[1], true);
   if($fl['allcompleted']!=true){ return array('view'=>'administration/error', 'error'=>'Курс не может быть оценен, т.к. есть неоценненые задания');}
   $enrollment=new enrollment($v[1]);
   if($enrollment->grade($v[2], $v[0])){
       $certificate=new certificate();
       $certificate->course=$v[2];
       $certificate->student=$v[1];
       $certificate->address=$student->address;
       $certificate->ask();
       
    $message=<<<a
   Здравствуйте, {$student->name} {$student->fname}!<br/>
Пройденный вами курс <b> {$course->title}</b> был оценен преподавателем!<br/>
Оценка за курс:<br/><b/>{$v[0]}</b>.<br/>
По итогам курса Вам будет выслан сертификат по адресу <b>{$student->address}</b>. <br/>   
С уважением<br/>
Команда МБИС ЕХБ <br/>
      
a;
       mailer::send($student->email, 'Завершение курса '.$course->title, $message);
      
  if($v[0]=='отлично'){
      accountant::altermoney($v[1],$v[2], 25);
        }
       $countdays=$enrollment->countdays($v[2]);
          if((int)$countdays <30){
      accountant::altermoney($v[1],$v[2], 50);
        }else{
        if((int)$countdays <40){
      accountant::altermoney($v[1],$v[2], 20);
        }
        }
       
   
        return array('view'=>'administration/index', 'text'=>'Курс оценен');
   } 
        
   return array('view'=>'administration/index', 'text'=>'не прошло');      
       
   }
   
   ///////////////////////////
   public function gradecourse(){
         if($_SESSION['status']<2){die('Только для преподавателей');}        
       $text='';
       include('protected/includes/gradesys.php');
     $teacher=$_SESSION['status']=='3'?'':$_SESSION['email'];
       $mycourses=new courselist('all', '', $teacher);
        $el= new enrollmentlist;
         if( count($mycourses->list)==0){$courses='У вас нет курсов для преподавания';} else{
                          foreach($el->justfinished as $k=>$v){
                             ;
if( isset($mycourses->list[$v['course']])){
    $fl=new framelist($v['course']);
    $gradearray=$fl->gradebookarray($v['student']);
    $student=new user($v['student']);
    $text.="<hr/><h2>".$mycourses->list[$v['course']]['title']."</h2><h3>Студент ".$student->lname."  ".$student->name." ".$student->fname." email:".$student->email."</h3>";
    foreach($gradearray as $k1=>$v1){
        $text.='<div>*****************************</div><div>'.$v1['title'].'  '.$v1['desc'].'<br/>';
        $i=0;
        foreach($v1['gradeinfo'] as $k2=>$v2){
            $i++;
            $text.=<<<a
            <br/><div><i>Задание </i> $i<br/><span class="redpointer" onclick="$(this).next().toggle()">Содержание ответа</span><div style="display: none">{$v2['submission']}</div>
a;
                if($v2['graded']=='true'){
                if($v2['checked']=='true'){
                    $text.='<br/>Задание зарегистрировано, но не проверено <br/>';
                } else{    
                $text.='<br/>Поставлена оценка '.$v2['grade'].'<br/>'.'<span class="redpointer" onclick="$(this).next().toggle()">Содержание комментария</span><div style="display: none">'.$v2['comments'].'</div>';}
            }else{
                if($v2['submitted']=='true'){$text.='<br/>Задание еще не зарегистрировано<br/>';}
            }
            
            $text.='</div>';
        }
        
    }
    
    
    
}
$text.=<<<a
<div>
    <h3>Выставаление оценки </h3>
<select>$gradesys</select>
<button onclick="var data=$(this).prev().val()+'%%SEPARATOR%%{$v['student']}%%SEPARATOR%%{$v['course']}'; $.ajax({type: 'POST', url:'index.php?r=classroom/savegradedcourse', data:'data='+encodeURIComponent(data), success: function (e){alert(e); display('menu', 'gradecourse'); ;}}) ">Выставить оценку</button>    
</div>
<hr/>
   
a;
      
                  
              }
         }
       
     $text=$text==''?'Курсов, готовых к проверке, нет.<br/>':$text;
       return array('text'=>$text);   
   }
   //////////////////////////////////////////////
    //////////////////////// Переписка
    public function sendresponse(){
  if(!isset($_POST['data'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не заданы параметры');}
$a=explode('%%SEPARATOR%%',$_POST['data']);
if(isset($a[2])){
    mailer::send($a[1], $a[2],$a[0] );
 return array('view'=>'administration/newcreated', 'newcreated'=>'Письмо послано по адресу '.$a[1]);   
    
    
}

$feedback=new feedback($a[1]);

$user=new user($feedback->user);
$text="Здравствуйте, ".$user->name." ".$user->fname."! <br/> Приводим ответ на ваш вопрос на сайте Московской богословской интернет-семинарии ЕХБ: <br/><b>".$a[0]."</b><br/> Вопрос был: <br/><i>".$feedback->text."</i><br/> Успехов в учебе!<br/> Администрация МБИС ЕХБ";
 mailer::send($feedback->user, 'Ответ на вопрос на сайте МБИС ЕХБ',$text );
  mailer::send(ADMINEMAIL, 'Ответ на вопрос на сайте МБИС ЕХБ',$text );
$feedback->response=$a[0];
if($feedback->respond()){
 return array('view'=>'administration/newcreated', 'newcreated'=>'Ответ выслан на адрес '.$feedback->user);
  }else{return array('view'=>'administration/error', 'error'=>'Ответ выслать не удалось!');}
    
}
public function deletefeedback(){
      if($_SESSION['status']<2){die('Только для преподавателей');}        
if(!isset($_POST['data'])){return array('view'=>'administration/error', 'error'=>'Так нельзя. Не заданы параметры');}
$feedback=new feedback($_POST['data']);
if($feedback->del()){
return array('view'=>'classroom/correspondance',)+self::correspondance();
}else{return array('view'=>'administration/error', 'error'=>'Вопрос не был удален!');}
   
}
    
    public function correspondance(){
        $text='';
        $in='';
     
 $flist=new feedbacklist('');
 
 foreach($flist->newones as $k=>$v){
     $user=new user($v['user']);
     $text.=<<<a
<hr/><div>{$user->name} {$user->fname} {$user->lname}<br/>{$v['user']}<br/> {$v['date']}<br/>***************<br/> <b>Текст вопроса</b><br/>{$v['text']}<br/>___________________<td><textarea>Ответ</textarea><button  onclick="var v=$(this).prev().val()+'%%SEPARATOR%%'+'$k'; display('sendresponse',v)">Ответить</button><br/><button class="del"  onclick="display('deletefeedback', $k)">Удалить вопрос</button><br/><hr/></div>   
a;
 }
     $text=$text==''?'Нет заданых вопросов':$text;
 
$ul=new userlist;

foreach($ul->list as $k=>$v){
    $in.='<option value="'.$k.'">'.$v['lname'].' '.$v['name'].' '.$v['fname'].'</option>';    
}

 return array('text'=>$text, 'students'=>$in);
        
    }
    public function feedbackold(){
        $text='';
     
 $flist=new feedbacklist('');
 
 foreach($flist->responded as $k=>$v){
     $user=new user($v['user']);
     $text.=<<<a
<div><hr/>{$user->name} {$user->fname} {$user->lname}<br/>{$v['date']}<br/> {$v['text']}</td><td>Ответ<br/>{$v['response']}<br/><div class="del"  onclick="display('deletefeedback', $k)">Удалить вопрос</button><hr/></div>   
a;
 }
     $text=$text==''?'Нет заданых вопросов':$text;
 
 return array('text'=>$text, 'view'=>'classroom/correspondance');
        
    }
 
   public function explorecourses(){
         if($_SESSION['status']<2){die('Только для преподавателей');}        
       $courses='';
       $teacher=$_SESSION['status']=='3'?'':$_SESSION['email'];
       $mycourses=new courselist('all', '', $teacher);
   if( count($mycourses->list)==0){$courses='У вас нет курсов для преподавания';} else{
       foreach($mycourses->list as $k=>$v){
          $courses.=<<<a
  <tr><td><a href="index.php?r=currentcourse&id={$k}">{$v['title']}</a><br/><div style="color: blue; cursor:pointer" onclick="$(this).next().toggle()">Показать описание</div><div style="display:none">{$v['desc']}</div></td></tr> 
a;
          
       }
   }
       
    return array('courses'=>$courses, );       
   }
   public function delcert(){
         if($_SESSION['status']<2){die('Только для преподавателей');}        
     if(!isset($_POST['data'])){return array('view'=>'classroom/certificates')+self::certificates();}     
$c=new certificate($_POST['data']);
$c->delete('certificate','id',$_POST['data'] );
  return array('view'=>'classroom/certificates')+self::certificates();     
   }
   public function sendcert(){
         if($_SESSION['status']<2){die('Только для преподавателей');}        
     if(!isset($_POST['data'])){return array('view'=>'classroom/certificates')+self::certificates();}     
     $ar=explode('SEPARATOR', $_POST['data']);
$c=new certificate($ar[2]);
$student=new user($c->student);
$course=new course($c->course);

$c->address=$ar[0];
$c->number=$ar[1];
$c->send();
$message=<<<a
   Здравствуйте, {$student->name} {$student->fname}!<br/>

По итогам курса <h2>{$course->title}</h2> Вам выслан сертификат по адресу <b>{$c->address}</b>.  <br/> Номер сертификата {$c->number}  
С уважением<br/>
Команда МБИС ЕХБ <br/>
      
a;
       mailer::send($student->email, 'Вам выслан сертификат за курс '.$course->title, $message);
    



  return array('view'=>'classroom/certificates')+self::certificates();     
   }
   public function unsendcert(){
         if($_SESSION['status']<2){die('Только для преподавателей');}        
     if(!isset($_POST['data'])){return array('view'=>'classroom/certificates')+self::certificates();}     
     
$c=new certificate($_POST['data']);
$c->unsend();
  return array('view'=>'classroom/certificates')+self::certificates();     
   }
   
   public function certificates()
           {
       $pendings='';
       emptydir('documents');
        include('protected/lib/ncl/NCL.NameCase.ru.php');
        $case=new NCLNameCaseRu();
         if($_SESSION['status']<2){die('Только для преподавателей');}        
         $c = new certificatelist;
         foreach($c->pending as $k=>$v){
          $student=new user($v['student']);
          $course=new course ($v['course']);
          $grade=new enrollment($v['student']);               
        $params=array();
        $namear=$case->q($student->lname.' '.$student->name.' '.$student->fname);
        $params['name']=$namear[2];
        $params['title']=$course->title;
        $params['credits']=$course->credits;
        $params['start']=reversedate($grade->courses[$v['course']]['enrollmentdate']);
        $params['finish']=date('d.m.Y');
        $params['grade']=$grade->courses[$v['course']]['finalgrade'];
        $certcontent=self::getadocument('certificate', $params);
        $fileName='documents/cert_'.translit($student->lname.'_'.$student->name).$v['course'].'.rtf';
   file_put_contents($fileName,$certcontent); 
          
          $pendings.= '<b>Студент</b> '.$student->name.' '.$student->fname.' '.$student->lname.'<br/><b>Курс</b>  '.$course->title.'<br/><b>Оценка</b>  '.$grade->courses[$v['course']]['finalgrade'].'<br/><b>Дата записи на курс:</b> '.$grade->courses[$v['course']]['enrollmentdate'].'<br/><b>Адрес</b><br/>
<textarea id="certadr'.$k.'">Кому: '.$params['name']."\nКуда: ".$v['address']."\n\n\n\n\n\n\nОт кого: ЛОГО\nОткуда: Москва, ул. Перовская, д. 4а\n                   111524".'</textarea>
    <br/>              
    <a href="'.$fileName.'">Скачать сертификат</a><br/>
<input type="text" id="certnum'.$k.'" placeholder="Номер сертификата" /><br/>            
    <input type="button" value="Удалить" onclick="if(confirm(\'Вы действительно хотите удалить эту запись?\')){display(\'delcert\',\''.$k.'\')}"/>            <input type="button" value="Выслать сертификат" onclick="display(\'sendcert\',$(\'#certadr'.$k.'\').val()+\'SEPARATOR\'+$(\'#certnum'.$k.'\').val()+\'SEPARATOR'.$k.'\')"/>      

<hr/>';
             
         }
         
         
         return array('text'=>$pendings);}
         private function printadocument($type,$params ){
   
 
$fileName='documents/'.$type.'_'.translit($student->lname.'_'.$student->name).'.rtf';
   file_put_contents($fileName,$mes);      
    return '<a href="'.$fileName.'">Получить документ</a>';
    
}
           public function oldcertificates()
           {
       $old='';
         if($_SESSION['status']<2){die('Только для преподавателей');}        
         $c = new certificatelist;
         $statistics =array();
         $slist=array();
         foreach($c->sent as $k=>$v){
          $student=new user($v['student']);
          $course=new course ($v['course']);
          $grade=new enrollment($v['student']);
          $year=  substr($v['date'],0,4);
          $slist[$course->title]=isset($slist[$course->title])?$slist[$course->title]+1:1;
          if(key_exists($year, $statistics)){$statistics[$year]++;}else{$statistics[$year]=1;}
          $old.= '<b>Студент</b> '.$student->name.' '.$student->fname.' '.$student->lname.'<br/><b>Курс</b>  '.$course->title.'<br/><b>Оценка</b>  '.$grade->courses[$v['course']]['finalgrade'].'<br/><b>Дата записи на курс:</b> '.$grade->courses[$v['course']]['enrollmentdate'].'<br/> <b>Адрес:</b> '.$v['address'].'<br/><b>Номер:</b> '.$v['number'].'<br/><b>Дата:</b> '.$v['date'].'<br/>    <input type="button" value="Удалить" onclick="if(confirm(\'Вы действительно хотите удалить эту запись?\')){display(\'delcert\',\''.$k.'\')}"/><input type="button" value="Не выслан" onclick="display(\'unsendcert\',\''.$k.'\')"/> <hr/>';
             
         }
         
         ksort($statistics);
         foreach($statistics as $k=>$v){
             $showstat.=$k.': '.$v.'<br/>';
         }
         asort($slist);
         $slist=  array_reverse($slist);
         $showstat.='<hr>';
         foreach($slist as $k=>$v){
         $showstat.=$k.': '.$v.'<br/>';    
         }
         $old.='<div>Статистика<br/>'.$showstat.'</div>';
         return array('text'=>$old);
       
       
       
           }
               private function getadocument($type,$params=array()){
    $template=  file_get_contents('protected/refs/templates/'.$type.'.rtf');
    setlocale(LC_CTYPE, 'ru_RU');
    foreach($params as $k=>$v){
        
       $template=  str_ireplace('%%'.$k.'%%', mb_convert_encoding($v,"Windows-1251", "utf8"), $template); 
            }
            return $template;
    
    
    
}
///////////////////////////////
///////////////////////////////
   ///////
   //////
   ///////   
///////////////// Студенческая часть//
//////////////////////////////////////
   public function sendquestion(){
     if(!isset($_POST['data'])){return array('view'=>'administration/error', 'error'=>'Вопрос выслать не удалось');}     
     $feedback=new feedback;
     $feedback->text=$_POST['data'];
     $feedback->user=$_SESSION['email'];
     $feedback->ask();
    mailer::send(ADMINEMAIL, 'Вопрос администрации', 'Пользователь '.$_SESSION['name'].' '.$_SESSION['fname'].' '.$_SESSION['lname'].' Email: '.$_SESSION['email'].' задал вопрос:<br/> '.$feedback->text);     
   }

  
public function quit(){
        if(!isset($_POST['data'])){return;} 
               $en=new enrollment($_SESSION['email']);
     $en->quit($_POST['data']);
        $_POST['data']='gradebook';
        return self::menu();
        
     }     
      public function enroll(){
      if(!isset($_POST['data'])){return array('view'=>'administration/error', 'error'=>'Регистрация не удалась');}    
      if((int)$_SESSION['status']>1){
        return array('view'=>'administration/error', 'error'=>'<span style="color:red; font-size:20px;">Куда вам на старости лет еще и учиться, господин профессор.</span>');  
      }          
      $enrollment=new enrollment($_SESSION['email']);
       if(isset($enrollment->courses[$_POST['data']]) ){ return array('view'=>'administration/error', 'error'=>'Вы уже записаны на этот курс');  
      } 
      if(!$enrollment->enroll($_POST['data'])){
        return array('view'=>'administration/error', 'error'=>'Регистрация не удалась');  
      }          
      
      }    
      private function enrollment(){
       
  /*        include('protected/includes/categories.php');
       $courselist=new courselist('published', $_SESSION['email']);
       $list='';
       foreach($courselist->tobeenrolled as $k=>$v){
           $price=$v['price']=='0'?'Бесплатно':$v['price'].' руб. ';
          $list.='<tr><td><b>'.$v['title'].'</b><br/><small>Категория: <i>'.$cats[$v['category']].'</i></small><br/>Стоимость: '.$price.'<br/><span id="enr'.$k.'"><button class="enrollbut" course="'.$k.'">Записаться</button></span></td><td colspan="2"><div class="details">Подробнее</div><div class="showdetails"'.$v['desc'].'</div></td></tr>';
       }
       $list=$list==''?'Нет доступных для записи курсов':$list;
          return array('list'=>$list, 'img'=>'newcourses');
   * 
   */
          return array();
      }    
     private function gradebook(){
         $_SESSION['money']=  accountant::showmoney($_SESSION['email']);
         
       $lista='';
       $notpaid='';
         $courselist=new courselist('all', $_SESSION['email']);
                         foreach($courselist->actual as $k=>$ca){
                     
                 
         $lista.='<tr border="1"><td><a href="index.php?r=currentcourse&id='.$k.'">'.$ca['title'].'</a> <br/><small style="font-size:9px">Со дня записи на курс прошло '.$ca['days'].'  дн.</small> <span class="quit" course="'.$k.'">&times;</span></td></tr> ';
                  }
                  $lista=$lista==''?'У вас нет активных курсов':$lista;
                  $listp='';
                  //var_dump($courselist->passed);
                  foreach($courselist->passed as $k=>$ca){
                      $finalgrade=$ca['finalgrade']==1?'Курс пока не оценен':' Оценка: '.$ca['finalgrade'];
                      $listp.= '<tr><td><a href="index.php?r=currentcourse&id='.$k.'">'.$ca['title'].'</a>  '.$finalgrade.'</td></tr> ';
                   
                                                              }
                                                 
                  $listp=$listp==''?'У вас нет завершенных курсов':$listp;
                  
     return array('img'=>'zachetka', 'actual'=>'<table>'.$lista.'</table>', 'passed'=>$listp);                   
       
   }
              
              
public function paying(){
 if(!isset($_POST['data'])){return;} 
  $v=explode('%%SEPARATOR%%',$_POST['data']);
  $check=preg_match('/^[1-9][0-9]*$/',trim($v[1]));
  //var_dump($check);
 if(!$check){die('Нужно правильно ввести сумму');}
 if($_SESSION['status']!='1'){die('Пополнение возможно только для студентов');}   

 accountant::putmoney($_SESSION['email'],trim($v[1]));
$message=" {$_SESSION['name']} {$_SESSION['fname']} {$_SESSION['lname']} перевел на свой счет {$v[1]} баллов-рублей. Дополнительная информация: <br/> {$v[0]}.";
mailer::send(ADMINEMAIL, 'Пополнение счета пользователя', $message); 
 $m=$v[1].' рублей успешно зачислены на ваш счет. <input value="0K" type="button" onclick="location.reload()"/>';
 echo $m;
    
}
          
    
}

?>
