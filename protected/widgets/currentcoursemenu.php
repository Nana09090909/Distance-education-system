<?php

class currentcoursemenu{
    
    public function menu(){
         if($_SESSION['disablemenu']){ return '';}
        $student=<<<a
    <div id="currentassignment" class="menu">Текущее задание</div>
        <div id="preeviousassignments" class="menu">Прошлые задания</div>
        <div id="futureassignments" class="menu">Предстоящие задания</div>
        <div id="about" class="menu">Информация</div>
        <div id="library" class="menu">Библиотека</div>        
        <div  class="menu" id="questiontoteacher"> Вопрос учителю </div>
        
a;
        $admin=<<<a
    <div id="assignments" class="menu">Просмотр заданий</div>
<div id="students" class="menu">Управление студентами</div>                
<div id="aboutadmin" class="menu">Информация</div>
        <div id="libraryadmin" class="menu">Библиотека</div> 
        <div id="correspondance" class="menu">Переписка</div> 
         <div class="menu" id="mailing"> Рассылка</div>
        
a;
 $result=$_SESSION['status']==1?$student:$admin;
 return $result;
        
        
        
    }
    
    
}

?>
