<?php
class filmshow{
    public function index(){
        echo "I am here";
    }
    public function add(){
       if($_SESSION['status']<3){die('Только для преподавателей');}
         if(!isset($_POST['data'])){die('Неверное обращение к странице');}
         $v=  explode('%%SEPARATOR', $_POST['data']);
        $film= new films;
        $film->title=$v[0];
        $film->desc=$v[1];
        $film->code=$v[2];
        $film->file=$v[3];
        $film->cat=$v[4];
        cache::delete('filmlist'.$film->cat);
         cache::delete('filmlist'.'0');
        $film->add();                
        echo "Фильм добавлен успешно <br/><button onclick=\"lrep()\">OK</button>";
    }
     public function edit(){
       if($_SESSION['status']<3){die('Только для преподавателей');}
         if(!isset($_POST['data'])){die('Неверное обращение к странице');}
         $v=  explode('%%SEPARATOR', $_POST['data']);
         $film= new films($v[5]);
       //  var_dump($film);
        $film->title=$v[0];
        $film->desc=$v[1];
        $film->code=$v[2];
        $film->file=$v[3];
        $film->cat=$v[4];
        cache::delete('filmlist'.$film->cat);
         cache::delete('filmlist'.'0');
               $film->renew();                
       
    }
    public function del(){
       if($_SESSION['status']<3){die('Только для преподавателей');}
         if(!isset($_POST['data'])){die('Неверное обращение к странице');}     
         $film=new films($_POST['data']);
         cache::delete('filmlist'.$film->cat);
         cache::delete('filmlist'.'0');
        
         $film->del();
      echo "Фильм удален успешно<br/><button onclick=\"lrep()\">OK</button>";
   
         }
         
         
    public function start(){
        $text='<button style="float:right; background-color:white; color:red" onclick="if(location.hash !=\'#films\'){location.replace(\'index.php#films\')} else{location.reload()}">К списку фильмов</button>';
        if(!isset($_POST['id'])){echo'<script>location.reload();</script>';}     
         $film=new films($_POST['id']);
         
         if($film->file!=''){
             if((int)$_SESSION['status']<1  ){
               $text.='<h2>Данный раздел доступен только студентам программы.</h2>';
               $text.= '<span   class="enter" onclick="$(\'.login\').slideDown(\'slow\');
$(\'.wrapper\').slideUp(\'slow\');$(\'#data\').slideUp(\'slow\');">ВХОД</span><span onclick="$(\'.register\').slideDown(\'slow\');
$(\'.wrapper\').slideUp(\'slow\'); $(\'#data\').slideUp(\'slow\');" class="enter">РЕГИСТРАЦИЯ</span>';
               
             }else{
                 $server=serverchooser::choose();
                  $text.='<h2>'.$film->title.'</h2>';
                 $text.=<<<a
   
<script src="assets/fp/flowplayer-3.2.11.min.js"></script>

<div align="center" >
<a href="http://$server/films/{$film->file}" style="display:block;width:720px;height:530px"  id="player">  
		</a> 


<button onclick=" var w=$('#player').css('width'); var h=$('#player').css('height'); w=100+parseInt(w); w.toString(); h=100+parseInt(h); h.toString();$('#player').css({'width' : w, 'height' : h});">+</button><button onclick=" var w=$('#player').css('width'); var h=$('#player').css('height'); w=parseInt(w)-100; w.toString(); h=parseInt(h)-100; h.toString();$('#player').css({'width' : w, 'height' : h});">-</button>
<script>
			flowplayer("player", "assets/fp/flowplayer-3.2.15.swf" );
		</script>
 </div>

a;
                 
             }
            
        }else{
            
      if((int)$_SESSION['status']<1 && $film->file=='no'  ){
               $text.='<h2>Данный раздел доступен только студентам программы.</h2>';
               $text.= '<span   class="enter" onclick="$(\'.login\').slideDown(\'slow\');
$(\'.wrapper\').slideUp(\'slow\');$(\'#data\').slideUp(\'slow\');">ВХОД</span><span onclick="$(\'.register\').slideDown(\'slow\');
$(\'.wrapper\').slideUp(\'slow\'); $(\'#data\').slideUp(\'slow\');" class="enter">РЕГИСТРАЦИЯ</span>';
               
             }else{    
        $text.='<h2>'.$film->title.'</h2>';
        $text.='<div align="center">'.$film->code.'</div>';
             }
        }
        $text.=<<<a
  <br/><div id="filmalarm"><button style="float:left; background-color:white; color:red" onclick="filmalarm( '{$_POST['id']}' );">Нажмите здесь, если фильм не воспроизводится</button></div> 
  <script>
function filmalarm(data){

$('#filmalarm').html('<img src="images/progress.gif"/>');
$.ajax({type: 'POST', url:'index.php?r=site/filmalarm', data:'data='+data, success: function (e){
    $('#filmalarm').html(e);    
    }});

}  
</script>    
a;

        echo $text;
         
    }
    
    
}

?>
