<?php
class proxyframe{
    public function index(){
        if($_SESSION['currentcourse']!=$_GET['course']){die();}
        echo <<<a
   <iframe src="http://mbsniki.ru:81/lect/{$_GET['params']}" ></iframe>
a;
        
    }
}

?>
