<?php

class service{
    
    public function wipetemp(){
        
        filemanagement::emptydir('tmp');
  
    }
    
}
?>
