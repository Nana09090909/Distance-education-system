<?php
class serverchooser{//Первоначально материалы грузились на домашние серверы. Надо было проверять, какой из них работает.
    public static function choose($case='lectures'){
        include('protected/includes/servers.php');
$waitTimeoutInSeconds = 1; 
shuffle($servers);
        foreach($servers as $v){
            $vi=explode(':', $v[1]);
             $host = $vi[0]; 
$port = $vi[1]; 
if($fp = @fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)){   
fclose($fp);
//echo $v[0];    
if($case=="lib"){return $v[0].$v[3];}
return $v[0].$v[2]; 
    
} 
        }
return $servers[0];   
        
        
    }
    
}


?>
