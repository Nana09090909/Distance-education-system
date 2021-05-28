<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
     <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js.js"></script>
    <script src="js/layer.js"></script>
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet"></link>
    
    <meta name="description" content=" "/>

        <link type="text/css"  rel="stylesheet" href="css/layer.css"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="yandex-verification" content="461700dca0318d42" />
<title>Моя система дистанционного обучения</title>
</head>

<body>
   
    
    
    <div id="data"><span style="float:right; color: red; cursor:pointer; margin:5px " onclick="$('#data').slideUp('slow'); $('#datacontent').html('');   $('.wrapper').slideDown('slow');">X</span><div id="datacontent"></div></div>
    <? invite::invitewindow();?> 
    <div class='wrapper'>
       
        
     
         
        <div class="header">
            
    <div class="menu">
        
   <div class="nav">

       <div class="menuitems">
<? topmenu::index() ?>  </div>
    
  <a href="index.php"> <img style="position:absolute;z-index:200; top: 150px; left:150px;" src="images/logo.gif"/></a>
                                              <div class="title" style="font-family: 'Roboto Slab', serif; font-size:25px"><!--<img src="images/title.gif"/>-->ДИСТАНЦИОННОЕ ОБУЧЕНИЕ<br/><br/><br/><? invite::invitegate();?><a href="index.php"> </a>
       
</div>

    </div>            
        </div>
     
   
        
  </div>
        <div class="index">
        <? echo $message;?></div>
    <br/>         
      
    <div class="footer">&copy; Независимый международный образовательный сайт .
        
    </div>
</body>
</html>

