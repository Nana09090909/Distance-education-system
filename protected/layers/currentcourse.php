<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js.js"></script>
     <script src="js/tiny_mce/tiny_mce.js"></script>
     
        <script src="js/currentcourse.js"></script>
      <script src="js/mediaelementplayer.min.js"></script>
<link rel="stylesheet" href="css/mediaelementplayer.min.css" />
    
   <script src="assets/kb/vk_iframe.js"></script>
        <link type="text/css"  rel="stylesheet" href="css/classroom.css"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> <? echo $_SESSION['currenttitle']; ?></title>
</head>

<body>
    <div id="assignment"><span style="float:right; color: red; cursor:pointer; margin:5px " onclick="allback()">X</span><div id="assignmentcontent"></div></div>
    <div id="visible">
    <div class="exit"><a style="background-color:white" href="index.php?r=classroom">В ОСНОВНОЙ КЛАСС</a></div>
    
    <div class="personal">
       <? echo currentcoursemenu::menu(); ?>
                </div>
    <div class='wrapper'>
        
        <div class="workingarea">
          <div id="classtopbannerem"> <div  style="width:650px; margin-left: 132px"> <? echo $_SESSION['currenttitle']; ?></div></div>  
          <div id="content">
            

          
   <? echo $message;?>
            

          </div>
</div>
        
        
    </div>
    </div>

</body>
</html>

