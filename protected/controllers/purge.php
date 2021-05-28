<?php
class purge{
    public function index(){
if(filemanagement::emptydir('tmp')){
echo "ok";
}
    }
}
?>
