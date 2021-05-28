<?php
class films extends db{
    public $id;
    public $desc;
    public $title;
    public $file;
    public $code;
    public $cat;       
    public $nuevo=true;
    public function  __construct($id=''){
        if($id==''){return;}
        $r=$this->mfa($this->query('SELECT * FROM `films` WHERE `id`=\''.$id.'\';'));
        if(!$r){return;}
        $this->id=$r['id'];
        $this->cat=$r['cat'];        
        $this->title=$this->restore($r['title']);
        $this->desc=$this->restore($r['desc']);
        $this->file=$this->restore($r['file']);
        $this->code=$this->restore($r['code']);
    }
     public function add(){
        if(!isset($this->code)){return false;}
        $q="INSERT INTO `films` (`title`,`desc`,`code`, `file`, `cat`) VALUES ('".$this->supermes($this->title)."','".$this->supermes($this->desc)."','".$this->supermes($this->code)."','".$this->file."','".$this->cat."');";  
       // echo $q;
        $this->query($q);
                return true;
            }
      public function del(){
                           $this->delete('films','id', $this->id);
                   return true;                   
            }
            
       public function renew(){
                if(!isset($this->id)){return false;}
 $q="UPDATE `films` SET  `file`='".$this->file."',`cat`='".$this->cat."',`title`='".$this->supermes($this->title)."',`desc`='".$this->supermes($this->desc)."',`code`='".$this->supermes($this->code)."' WHERE `id`='".$this->id."';";
        
 $this->query($q);
                return true;
            }
  
    
    
}




class filmslist extends db{
    public $number=0;
    public $list=array();
    public function __construct($cat='0'){
        $where=$cat=='0'?'':'WHERE `cat`=\''.$cat.'\'';
              $q=$this->query('SELECT * FROM `films`'.$where.' ORDER BY `title`;');
 $n=0;
            while($r=$this->mfa($q)){
            $this->list[$r['id']]=array(
                'title'=>$this->restore($r['title']),
                'desc'=>$this->restore($r['desc']),
                'code'=>$this->restore($r['code']),
                'cat'=>$r['cat'],
                'file'=>$r['file'],
                          );    
            $n++;    
            }           
            $this->number=$n;
    }
    
    
}























?>