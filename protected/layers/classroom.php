<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
         <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.ui.resizable.min.js"></script>
    <script src="js.js"></script>
     <script src="js/classroom.js"></script>
    
    <link type="text/css"  rel="stylesheet" href="css/classroom.css"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Классная комната</title>
</head>

<body>
 
    <div class="exit"><a href="index.php"><img title="Выход" src="images/exit.jpg"/></a></div>
    
    <div class="personal">
        <? echo classroommenu::menu();?>
                </div>
    <div class='wrapper'>
        
        <div class="workingarea">
          <div id="classtopbanner"><? personal::data(); ?></div>  
          <div id="content">
            

          
   <? echo $message;?>
            

          </div>
</div>
        
        
    </div>

</body>
</html>

