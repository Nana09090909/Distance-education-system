<?php
class topmenu{
public function index(){
    $facebook='';
    if(!isset($_SESSION['status'])){$_SESSION['status']=0;}
    $exit=isset($_SESSION['email'])?"<button class=\"topmenuitems\" id=\"exit\">Выход</button>":'';
    $managecourses=$_SESSION['status']==3?"<button class=\"topmenuitems\" onclick=\"location.replace('index.php?r=administration')\">Администрирование</button>":"";
     $library=$_SESSION['status']==3?"<button class=\"topmenuitems\" onclick=\"location.replace('index.php?r=library')\">Библиотека</button>":""; 
     $maillist=$_SESSION['status']==3?"<button class=\"topmenuitems\" onclick=\"window.open('index.php?r=maillist')\">Рассылка</button>":""; 
echo<<<a
$exit $managecourses  $library $maillist    $facebook
       
    <div>
<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="icon" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,lj,moikrug,gplus"></div>  
</div>
a;
}
}

?>
