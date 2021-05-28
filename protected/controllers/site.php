<?php
class site{
    public function index(){
       
      return array('layer'=>'layer');  
        }  
         public function error(){
       header("Location: http://".$_SERVER['HTTP_HOST']
.dirname($_SERVER['PHP_SELF'])
."/index.php");
      return array('layer'=>'layer');  
        }  
        public function teaser(){       
$addition=array();
            if($_POST['data']=='listofcourses'){
                $addition=self::listofcourses();
                }
                 if($_POST['data']=='mygrades'){
                $addition=self::mygrades();
                }
                 if($_POST['data']=='articles'){
               $addition= self::rss();
                
                } 
                  if($_POST['data']=='films'){
               $addition= self::films();
                
                } 
                if($_POST['data']=='webinars'){
               $addition= self::shop();
                
                } 
                
            return array('view'=>'site/'.$_POST['data'])+$addition;
        }
    public function cats(){
        return self::listofcourses($_POST['data']);
        
    }
    private function listofcourses($cat=''){
        if(cache::cached('listofcourses'.$cat)){$list=cache::read('listofcourses'.$cat); }else{
        $i=0;
           $list='';
        $star="<span class=\"star\">*</span>";
        $star1="";
        
        $addn=0;
                $clist=new courselist;
                
                foreach($clist->list as $k=>$v){
                     $warn=$v['status']=='0'?'Курс появится в вашей зачетной книжке сразу после публикации':'';
                    $price='';
                    $enroll='<br/><span id="enr'.$k.'"><button class="enrollbut" warn="'.$warn.'" course="'.$k.'">Записаться сейчас</button>';                                          
        if(($v['category']!=$cat) AND ($cat!='')){  continue;}
        $i++;            
        if($v['status']=='0'){
     continue;   
$add=$star;
$addn++;
           }else{
    if($v['obligatory']=='1'){$add=$star1;
$addn++;
   
    
    }else{
    $add='';}}
    $certific=$v['price']!='0'?'ВЫСЫЛАЕТСЯ<br/>СЕРТИФИКАТ':'';
$addn=$v['status']=='0'?$addn+1:$addn;
$list.="<div class=\"courselist\"><b>".$v['title'].$add."</b></div><div class=\"coursedesc\"style=\"display:none; position:fixed; top:10px; left:10%; height:70%; z-index:2000;  width:80%;   overflow:auto; padding:50px; border-style:solid;  background-color:white;\"><button style=\"float:right\" onclick=\"$(this).parent().hide()\">X</button><h2>".$v['title']."</h2><div class=\"showcert\">".$certific."</div><small> Количество  академических кредитов: ".$v['credits']."<br/> ".$price."</small><hr/>".$v['desc']. $enroll."</div>";


                    
                }
                if($addn!=0){$list="<hr/><p style=\"font-size:8px; color:red;\">* Курсы в разработке</p>".$list;}
                                $list=$i==0?'В данной категории пока нет курсов':$list;
                                cache::write($list,'listofcourses'.$cat);
        }
                include('protected/includes/categories.php');
                return array('list'=>$list, 'options'=>$categories);
                
    }
    
    public function mygrades(){
          $text='';
        $fl=new framelist($_SESSION['currentcourse']);
         $gradearray=$fl->gradebookarray($_SESSION['email']);
         
          if(count($gradearray)>0){
    foreach($gradearray as $k1=>$v1){
           
        $text.='<div>*****************************</div><br/>'.$v1['title'].'  '.$v1['desc'].'<br/> <span class="star" style="cursor:pointer" onclick="$(this).next().toggle(); if($(this).text()==\'Показать\' ){$(this).text(\'Скрыть\')}else{$(this).text(\'Показать\')}" >Показать</span><div style="display:none; background-color:#EEFFEE; padding: 20px;">';
        $i=0;
        foreach($v1['gradeinfo'] as $k2=>$v2){
            $i++;
            $submission=$v2['submission'];
                                   if($v2['graded']=='true'){
              
                $text.='<br/><div>'.$submission.'</div><div >Поставлена оценка <span style="font-size:1.3em; color:red">'.$v2['grade'].'</span></div>';
            }else{
                $text.='<br/>Конспекта нет.<br/>';
            }
            
$comments=$v2['comments']==''?'Комментариев нет':$v2['comments'];            
$text.='<br><span class="star"> Комментарии</span><br/>'.$comments.'</div>';
        }
    }}
        return array('text'=> $text);
    }
    
    
        public function rss(){
            $text='';
            include('protected/lib/readerrss.php');
            $w4u=parseRSSReader('http://www.word4you.ru/rss/');
            $tbn=parseRSSReader('http://tbn-tv.ru/feed/');
$bib=parseRSSReader('http://www.bible.com.ua/news/export/rss.rss');
$nr=parseRSSReader('http://feeds.newsru.com/com/www/section/religy');


            for($i=1;$i<=7;$i++){
            /*   if($i==5){
                $text.='<div style="width: 250px;float:right;"><iframe id="inforframe-a_links_left-13614346195342" src="http://www.invictory.org/informers/code.html?s=news&ss=&enc=UTF-8&wb=250&hb=391&cbr=%23616E90&cbg=%23ffffff&ctx=%23000000&ctl=%23E16602&cl=%23616E90&lu=1&ff=Verdana%2C%20sans-serif&fs=12&t=a_links_left&id=inforframe-a_links_left-13614346195342" allowtransparency="true" frameborder="0" height="391" scrolling="no" width="250"></iframe></div>';
       
   }*/

                $text.=<<<a
 <a href="{$w4u[$i]['link']}" target="_blank">  <h3>{$w4u[$i]['title']}</h3></a>
       <div >{$w4u[$i]['desc']}</div><hr/>
              <h3><a href="{$bib[$i]['link']}" target="_blank">{$bib[$i]['title']}</a></h3>
       <div>{$bib[$i]['desc']}</div><hr/>
            <h3><a href="{$nr[$i]['link']}" target="_blank">{$nr[$i]['title']}</a></h3>
       <div>{$nr[$i]['desc']}</div><hr/>
   <h3><a href="{$tbn[$i]['link']}" target="_blank">{$tbn[$i]['title']}</a></h3>
       <div>{$tbn[$i]['desc']}</div><hr/>
   
a;
                
                
                
                
            }
            
            
            return array('text'=>$text);
            
            
        }
        public function films(){
            $c='0';
           include('protected/includes/films.php');
            include('protected/includes/filmtempl.php');
            if(isset($_POST['cat'])){
                            $c=$_POST['cat'];                           
                        }
                        if((int)$_SESSION['status']<=1){
                if(cache::cached('filmlist'.$c)){ 
                    $text=cache::read('filmlist'.$c);
                 return array('text'=> $text, 'admin'=>'', 'cat'=>$cats, 'jadmin'=>'');
                }
            }
            
                        $cats4users=  str_replace($c.'"', $c.'" selected="selected"', $cats);
                         
$admin=<<<a
   <hr/>
       <h3>Добавление нового фильма</h3>
    
 <input size="100" type="text" placeholder="Название фильма" id="newtitle"/><br/>
     <textarea cols="100" rows="5"  id="newdesc"><table><tr><td width="20%"><img style="width:100px" src="images/covers/"/></td><td>Описание фильма</td></tr></table></textarea><br/>
 <input type="text" placeholder="файл" id="newfile"/><br/> 
 Либо код:<br/>
<textarea cols="100" rows="5"  id="newcode"></textarea><br/>
<select id="newcat"><option value="0">Выберите категорию</optioin>$cats4users</select><br/>
    
<select onchange="$('#newcode').val($(this).val())"><option value="0">Добавить шаблон</option>$filmtempl</select><br/>
<input type="button" value="Добавить" onclick="addfilm()"/>

   
a;
$jadmin=<<<a
<script>
function addfilm(){
    if($('#newcat').val()=='0'){alert('Надо выбрать категорию');return;}
if($('#newfile').val()=='' && $('#newcode').val()==''){alert('Надо заполнить либо файл, либо код');return;}

var v=encodeURIComponent($('#newtitle').val())+'%%SEPARATOR'+encodeURIComponent($('#newdesc').val())+'%%SEPARATOR'+encodeURIComponent($('#newcode').val())+'%%SEPARATOR'+encodeURIComponent($('#newfile').val())+'%%SEPARATOR'+$('#newcat').val();
$('.text').html('<img src="images/progress.gif"/>');
$.ajax({type: 'POST', url:'index.php?r=filmshow/add', data:'data='+v, success: function (e){
  if(location.hash !='#films'){location.replace('index.php#films')} else{location.reload()}
   }});

}
function editfilm(id){
//$('.text').html('<img src="images/progress.gif"/>');

var v=encodeURIComponent($("#title"+id).val())+'%%SEPARATOR'+encodeURIComponent($('#desc'+id).val())+'%%SEPARATOR'+encodeURIComponent($('#code'+id).val())+'%%SEPARATOR'+encodeURIComponent($('#file'+id).val())+'%%SEPARATOR'+$('#cat'+id).val()+'%%SEPARATOR'+id;
$.ajax({type: 'POST', url:'index.php?r=filmshow/edit', data:'data='+v, success: function (e){
//$('.text').html(e);
if(location.hash !='#films'){location.replace('index.php#films')} else{location.reload()}
   }});


}
function delfilm(id){
$('.text').html('<img src="images/progress.gif"/>');
$.ajax({type: 'POST', url:'index.php?r=filmshow/del', data:'data='+id, success: function (e){
   if(location.hash !='#films'){location.replace('index.php#films')} else{location.reload()}
  }});

}
</script>
a;
   
$admin= (int)$_SESSION['status']>1?$admin:'';
$jadmin= (int)$_SESSION['status']>1?$jadmin:'';

$fl=new filmslist($c);
if(count($fl->list)<1){ $text='Пока фильмов нет';}else{
    $text='';
       foreach($fl->list as $k=>$v){
            $del='<button onclick="delfilm('.$k.')">Удалить</button><button onclick="$(this).next().toggle()">Редактировать</button>';
            
       $cats4admin=  str_replace($v['cat'].'"', $v['cat'].'" selected="selected"', $cats);
            $edit=<<<a
   <div style="display:none"> 
 <input size="100" type="text" placeholder="Название фильма" id="title$k" value="{$v['title']}"/><br/>
     <textarea cols="100" rows="5"  id="desc$k">{$v['desc']}</textarea><br/>
 <input type="text" placeholder="файл" value="{$v['file']}" id="file$k"/><br/> 
 Код:<br/>
<textarea cols="100" rows="5"  id="code$k">{$v['code']}</textarea><br/>
<select id="cat$k"><option value="0">Выберите категорию</optioin>$cats4admin</select><br/>
<input type="button" value="Сохранить изменения" onclick="editfilm($k)"/>
</div>
   
a;
$del= (int)$_SESSION['status']>1?$del:'';
$edit= (int)$_SESSION['status']>1?$edit:'';
$categoryname=$filmarray[$v['cat']];
        $text.=<<<a
<hr style="color:red; background-color: red; height: 5px;"/>
<h3>{$v['title']}</h3>
    <small>$categoryname </small>
<div>{$v['desc']}</div>    
<button id="film$k" onclick="showfilm('$k')">Начать показ </button>
$del $edit
   
a;
        
        
    }
    
    
 if($_SESSION['status']==3){$text.="Общее количество фильмов в данной категории: ".$fl->number; }  
    
}
 if((int)$_SESSION['status']<=1){
                    cache::write($text,'filmlist'.$c);
                }
            
return array('text'=> $text, 'admin'=>$admin, 'cat'=>$cats, 'jadmin'=>$jadmin);


            
           
            
            
        }
        
        
        public function filmalarm(){
            
              if(!isset($_POST['data'])){return array('view'=>'administration/error', 'error'=>'Ошибка передачи');}
              $film= new films($_POST['data']);
              
             mailer::send('alexandpopov@yandex.ru', 'Что-то с фильмом '.$film->title, 'Что-то с фильмом '.$film->title.' .Проверь.' );
             
            return array('view'=>'administration/index', 'text'=>'СПАСИБО ЗА ОПОВЕЩЕНИЕ!!! <br/>СКОРО ПРОВЕРИМ И ИСПРАВИМ!!!');
        }
        
        
        
        public function shop(){
       /*include('protected/includes/shop.php');  
       
       $admin=<<<a
   <hr/>
       <h3>Добавление нового товара</h3>
    
 <input size="100" type="text" placeholder="Название товара" id="newtitle"/><br/>
     <textarea cols="100" rows="5"  id="newdesc"><table><tr><td width="20%"><img style="width:100px" src="images/covers/"/></td><td>Описание товара</td></tr></table></textarea><br/>
 <input type="text" placeholder="цена" id="newprice"/><br/> 
 <select id="newcat">$cats</select><br/>
    
<input type="button" value="Добавить" onclick="additem()"/>

   
a;
       
       
       $jadmin=<<<a
<script>
    
function additem(){
  if($('#newcat').val()=='0'){alert('Надо выбрать категорию');return;}
if($('#newprice').val()==''){alert('Надо добавить цену');return;}
var v=encodeURIComponent($('#newtitle').val())+'%%SEPARATOR'+encodeURIComponent($('#newdesc').val())+'%%SEPARATOR'+$('#newprice').val()+'%%SEPARATOR'+$('#newcat').val();
$('.text').html('<img src="images/progress.gif"/>');
$.ajax({type: 'POST', url:'index.php?r=store/add', data:'data='+v, success: function (e){
 if(location.hash !='#webinars'){location.replace('index.php#webinars')} else{location.reload()}
    }});
    }
    


function delitem(id){
$('.text').html('<img src="images/progress.gif"/>');
$.ajax({type: 'POST', url:'index.php?r=store/del', data:'data='+id, success: function (e){
//alert(e);
 if(location.hash !='#webinars'){location.replace('index.php#webinars')} else{location.reload()}
  }});

}


function edititem(id){

var v=encodeURIComponent($("#title"+id).val())+'%%SEPARATOR'+encodeURIComponent($('#desc'+id).val())+'%%SEPARATOR'+$('#price'+id).val()+'%%SEPARATOR'+$('#cat'+id).val()+'%%SEPARATOR'+id;
$('.text').html('<img src="images/progress.gif"/>');
$.ajax({type: 'POST', url:'index.php?r=store/edit', data:'data='+v, success: function (e){
//$('.text').html(e);
 if(location.hash !='#webinars'){location.replace('index.php#webinars')} else{location.reload()}
   }});


}


</script>
a;
$juser=<<<a
   <script>
   function showorder(id, where){
$('<img src="images/progress.gif"/>').insertAfter(where);
      
$.ajax({type: 'POST', url:'index.php?r=store/showorder', data:'data='+id, success: function (e){
$(where).next().remove();
$(e).insertAfter(where);
$(where).hide();
  }});

}

function buy(id, where){
$('<img src="images/progress.gif"/>').insertBefore('#conver'+id);
var data=encodeURIComponent($('#orderaddress'+id).val())+'%%SEPARATOR'+encodeURIComponent($('#ordercomments'+id).val())+'%%SEPARATOR'+id;
$.ajax({type: 'POST', url:'index.php?r=store/buy', data:'data='+data, success: function (e){
$('#conver'+id).prev().remove();
$('#conver'+id).html(e);
$.ajax({type: 'POST', url:'index.php?r=store/showsum', data:'data=no', success: function (f){
$('#money').text(f)
}});

  }});

}

</script>
a;
       
       
 $admin= (int)$_SESSION['status']==3?$admin:'';           
   $jadmin= (int)$_SESSION['status']==3?$jadmin:$juser;
   
   $c=0;
$fl=new shoplist;
if(isset($_SESSION['email'])){
$personaldata=<<<a
 <div style="float:right;margin-right:30px; margin-bottom: 20px; font-size:12px; cursor:pointer; text-decoration:underline;" onmouseover="$('#moneytip').show()" onmouseout="$('#moneytip').hide()" onclick="editprofile(this, 'putmoney')" id="account">На вашем счету: <br/> <span id="money"> {$_SESSION['money']}</span> рублей.</div>
 <div><span style="font-weight:bold; color:red">  {$_SESSION['name']} {$_SESSION['fname']} {$_SESSION['lname']}  </span> </div>
a;
}else{$personaldata='Идентифицируйтесь для использования данного раздела';}
if($fl->number==0){ $text='Пока магазин пуст';}else{
    $text=''; $del=''; $edit='';
       foreach($fl->list as $k=>$v){
  $del='<button onclick="delitem('.$k.')">Удалить</button><button onclick="$(this).next().toggle()">Редактировать</button>';
       $cats4admin=  str_replace($v['cat'].'"', $v['cat'].'" selected="selected"', $cats);
$edit=<<<a
       <div style="display:none"> 
 <input size="100" type="text" placeholder="Название товара" id="title$k" value="{$v['title']}"/><br/>
     <textarea cols="100" rows="5"  id="desc$k">{$v['desc']}</textarea><br/>
 <input type="text" placeholder="цена" value="{$v['price']}" id="price$k"/><br/> 
 <select id="cat$k"><option value="0">Выберите категорию</optioin>$cats4admin</select><br/>
<input type="button" value="Сохранить изменения" onclick="edititem($k)"/>
</div>
a;

if(isset($_SESSION['email'])){
$del= (int)$_SESSION['status']==3?$del:'';
$edit= (int)$_SESSION['status']==3?$edit:'';
}
$buy=isset($_SESSION['money'])?(int)$_SESSION['money']>=$v['price']?'<input value="Сделать пожертвование" type="button" onclick="showorder('.$k.', this)" />':'':'';
$categoryname=$shoparray[$v['cat']];
$text.=<<<a
<hr style="color:red; background-color: red; height: 5px;"/>
<h3>{$v['title']}</h3>
    <small>$categoryname </small><br/>
       Цена: <b>{$v['price']}</b> руб.
          $buy
<div>{$v['desc']}</div>    

$del $edit  
a;
       }}
       
         return array('text'=>$text, 'admin'=>$admin, 'jadmin'=>$jadmin, 'personaldata'=>$personaldata); */  
         return array('text'=>'<div align="center"><h3>По вопросам сотрудничества пишите по адресу <a href="mailto:mail#mbis.su">mail@mbis.su</a></h3><br/><img src="images/fellowship.jpg" style=" height:200px; margin:10px"/></div><br/>');
            
        }
        
}
?>