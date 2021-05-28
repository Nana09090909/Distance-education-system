<?php
class filemanagement{
    public function emptydir($directory) {
if ($handle = opendir( $directory )) {
    while (false !== ($file = readdir($handle))) { 
        if ($file != "." && $file != "..") { 
            unlink($directory."/".$file); 
        } 
    }
    closedir($handle); 
}  
return TRUE;  }  
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

?>
