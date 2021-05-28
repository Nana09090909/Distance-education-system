<?php
class store{
    
    public function getcertificate(){
        $student=new user($_GET['student']);
        
        $mes=self::printadocument('certificate', $student->email, $params);
        
        
    }
    


public function docdetails(){
  $students=  explode(':', $_GET['student']);
                      
    switch($_GET['type']){
        case 'zachisleniye':
            for($i=1;$i<22;$i++){
                if($i<=count($students)){
            $student=new reader('',$students[$i-1]);
            $group=$i==1?$student->group:$group;
            $hid.='<input type="hidden" id="student'.$i.'" value="'.$i.'. '.$student->lastname.' '.$student->name.' '.$student->fname.' '.'"/>';                                       }else{
                
            $hid.='<input type="hidden" id="student'.$i.'" value=""/>';            
            }
            
            }
            $abitur=count($students)>1?'следующих абитуриентов':'cледующего абитуриента';
            $cd=rdate('d.m.Y');
            $title="Приказ о зачислении";
            $mes=<<<a
                    $hid
   <input type="hidden" id="abitur" value="$abitur" />                 
   <input placeholder="Номер приказа" type="text" id="nomer"/><br/>  
       <input placeholder="Дата приказа" value="$cd" type="text" id="date"/><br/>
                <input placeholder="Группа" value="$group" type="text" id="group"/><br/>
                      
a;
            break;
        case 'invitationtosession1':
        case 'invitationtosession':
           
            $title="Приглашение на сессию";
            $secretary=SECRETARYNAME;
            $cd=rdate('d M Y').'г.';
            $mes=<<<a
                    <input placeholder="Дата выдачи" value="$cd" type="text" id="currentdate"/><br/>
                <input placeholder="Начало сессии" type="text" id="start"/><br/>
                     <input placeholder="Конец сессии" type="text" id="finish"/><br/>
                   <input placeholder="Курс" type="text" id="course"/><br/>
                    <select onchange="$(this).next().val($(this).val())" ><option>пасторского факультета</option><option>факультета христианского образования</option><option>богословского факультета</option></select></select> <input placeholder="Факультет" type="hidden" id="department" value="пасторского факультета" /><br/>
                    <input type="text" placeholder="Cекретарь" id="secretary" value="$secretary"/><br/>
                   
a;
            
            break;
         case 'lodginglist':
             $student=new reader('',$students[0]); 
           $mes='<input type="text" id="session" placeholder="Сессия"/><br/><input type="text" value="'.$student->group.'" id="group" placeholder="Группа"/>';
             break;
        case 'checklistforgraduate':
            break;
        default:
            $mes='';
    }
    
    return array('layer'=>'secretary', 'title'=>$title,  'mes'=>$mes, 'student'=>$_GET['student'], 'type'=>$_GET['type']);
    
}
    public function add(){
          if($_SESSION['status']<3){die('Только для преподавателей');}
         if(!isset($_POST['data'])){die('Неверное обращение к странице');}
         $v=  explode('%%SEPARATOR', $_POST['data']);
        $shop= new shop;
        $shop->title=$v[0];
        $shop->desc=$v[1];
        $shop->price=$v[2];
        $shop->cat=$v[3];
      if(  $shop->add()){           
        echo "Товар добавлен успешно <br/><button onclick=\"lrep()\">OK</button>";
      }
    }
    public function del(){
 if($_SESSION['status']<3){die('Только для преподавателей');}
  if(!isset($_POST['data'])){die('Неверное обращение к странице');}
    $shop= new shop($_POST['data']);
    var_dump($shop);
  if($shop->del()){
      echo 'Удаление успешно';
            
  } 
      }
      
       public function edit(){
       if($_SESSION['status']<3){die('Только для преподавателей');}
         if(!isset($_POST['data'])){die('Неверное обращение к странице');}
         $v=  explode('%%SEPARATOR', $_POST['data']);
        // var_dump($v);
         $film= new shop($v[4]);
       //  var_dump($film);
        $film->title=$v[0];
        $film->desc=$v[1];
        $film->price=$v[2];
        $film->cat=$v[3];
        if($film->renew()){echo 'Товар обновлен';}                
       
    }
    public function showorder(){
         if(!isset($_POST['data'])){die('Неверное обращение к странице');}
        echo "<div   style=\"background-color:white; border-style:solid;  width:400px; font-size: 9px; font-family:arial; padding:20px;\"><div style=\" float:right; font-size:16px; color:red; cursor:pointer;\" onclick=\"$(this).parent().prev().show(); $(this).parent().remove()\">X</div> <div id=\"conver".$_POST['data']."\">Подтвердите покупку данного товара.<br/> С вашего счета будет списана соответствующая сумма.<br/> Корреция счета будет сделана после обработки заказа. <br/> Товар будет выслан по адресу:<br/> <textarea cols=\"50\" rows=\"4\" id=\"orderaddress".$_POST['data']."\">{$_SESSION['address']}</textarea><br/> Комментарии к заказу:<br/><textarea id=\"ordercomments".$_POST['data']."\" cols=\"50\" rows=\"4\"> Комментариев нет.</textarea><br/> <button onclick=\"buy(".$_POST['data'].", this)\">Подтвердить покупку</button></div></div>";
        
        
        
    }
    public function buy(){
        if(!isset($_POST['data'])){die('Неверное обращение к странице');}
        $v=explode('%%SEPARATOR', $_POST['data']);
           $shop=new shop($v[2]);
        $pch=new buy;
        $pch->item=$v[2];
        $pch->address=$v[0];
        $pch->comments=$v[1];
        $pch->user=$_SESSION['email'];
        if($_SESSION['money']<$shop->price){  die('У вас не достаточно средств на счете');}
        if($pch->purchase()){          
            $shop=new shop($v[2]);
  accountant::altermoney($_SESSION['email'],'','',-$shop->price);
        $message=<<<a
 {$_SESSION['name']} {$_SESSION['fname']} {$_SESSION['lname']}  заказал {$shop->title} за {$shop->price} баллов. Их надо выслать по адресу {$v[0]}. Комментарии заказчика <br/>{$v[1]}.
a;
        
            mailer::send ('alexandpopov@yandex.ru', 'Заказ товара в минишопе', $message);
        echo "Ваш заказ оформлен. По всем вопросам обращайтесь по почте <a href=\"mailto:mail@mbis.su\">mail@mbis.su</a>. ";
        }
    }
    
    public function showsum(){
        echo $_SESSION['money'];
    }
    
}


?>
