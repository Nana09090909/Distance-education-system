<?php
class chat extends db{
    public $text='';
    public $date='';
    public $title='';
    public $id='';
    public $active=false;
          
    public function __construct($id='') {
        if($id==''){return;}
        $this->id=$id;
        $v=$this->mfa($this->query("SELECT * FROM `chat` WHERE `id`='$id'"));
        $this->text=$this->restore($v['text']);
        $this->date=$v['date'];
        $this->title=$this->restore($v['title']);
        if($v['active']=='1'){$this->active=true;}         
    }
    
    public function create(){
        
        
        
        
    }
    
    
    
}



?>
