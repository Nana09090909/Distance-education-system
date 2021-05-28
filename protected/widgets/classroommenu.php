<?php

class classroommenu{
    
    public function menu(){
        $studentmenu=<<<a
   <div id="index" class="menu">Правила обучения</div>
        <div id="gradebook" class="menu">Зачетная книжка</div>
         <a href="index.php?#listofcourses" target="_blank">   <div id="enrollment" class="menu">Запись на курсы</div></a>
        <div  class="menu" id="question"> Вопрос администрации </div>
     
a;
        $teachermenu=<<<a
    <div id="gradeassignment" class="menu">Текущие проверки</div>
   <div id="gradecourse" class="menu">Оценка курсов</div>
    <div id="explorecourses" class="menu">Просмотр курсов</div>
        <div  id="correspondance" class="menu" "> Переписка со студентами </div>
     
a;
        $adminaddition=' <div id="checkassignment" class="menu">Поставить зачеты</div><div id="certificates" class="menu">Сертификаты</div>';
        
        
        switch ($_SESSION['status']){
            case'1':
            return  $studentmenu;
                break;
            case'2':
               return $teachermenu;
                break;
            case'3':
               return $teachermenu.$adminaddition;
                break;
            default:
                break;
                        
            
        }
        
        
        
    }
    
    
}
?>
