<?php

class cache{
    
    public function purge(){
        filemanagement::emptydir('protected/cache');               
        return true;
    }
    public function delete($file){
        @unlink('protected/cache/'.$file);
        return true;
        
    }
    
    public function write($what, $file){
        file_put_contents('protected/cache/'.$file, $what);
        return true;
    }
    public function cached($file){
        return file_exists('protected/cache/'.$file);
        
    }
    public function read($file){
        if(file_exists('protected/cache/'.$file)){
           return file_get_contents('protected/cache/'.$file);
      
        }
        return false;
            }
    
            
            
    
}
?>
