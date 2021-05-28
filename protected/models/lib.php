<?php
class lib extends db{
    public $nuevo=true;
    public $id;
    public $file;
    public $title;
    public function __construct($id='') {
            $this->id=$id;
        if($id==''){return;}
            $r=$this->mfa($this->query("SELECT * FROM `lib` WHERE `id`='$id';"));
        if (!$r){ return;}
        
        $this->file=$this->restore($r['file']);
        $this->title=$this->restore($r['title']);        
    }
    
    public function add(){
        $q=" INSERT INTO `lib`(`file`, `title`) VALUES('".$this->supermes($this->file)."','".$this->supermes($this->title)."')";
   $this->query($q);     
   return true;     
       }
       public function del(){
           $this->delete('lib', 'id', $this->id);          
             $this->delete('lib4course', 'lib', $this->id);
             return true;
       }
public function renew(){
    $q='UPDATE `lib` SET `file`=\''.$this->supermes($this->file).'\', `title`=\''.$this->supermes($this->title).'\' WHERE `id`=\''.$this->id.'\';';
    $this->query($q);     
   return true;     
   
}
       
}
class liblist extends db{
   public $number=0; 
   public $list=array();
   public function __construct() {
       $re=$this->query("SELECT * FROM `lib` ORDER BY `title`;");
       while($r=$this->mfa($re)){
           $this->list[$r['id']]=array(
               'file'=>$this->restore($r['file']),
               'title'=>$this->restore($r['title'])              
                          );
           $this->number++;
       }
   }
   
    
}
class lib4course extends db{
    public $number=0;
    public $course;
    public $list=array();
    public function __construct($course){
        $this->course=$course;
     $re=$this->query('SELECT * FROM `lib4course` WHERE `course`=\''.$course.'\';');
     while($r=$this->mfa($re)){
         $lib=new lib($r['lib']);
         $this->list[$r['lib']]= array(
             'lib'=>$r['lib'],
             'title'=>$lib->title,
             'file'=>$lib->file,
             );
    $this->number++;     
     }
        
    }
    public function getnew(){
        $liblist=new liblist;
               
        return array_diff_key($liblist->list, $this->list);
    }
    public function add2course($lib){
$this->query("INSERT INTO `lib4course`(`course`, `lib`) VALUES ('{$this->course}', '$lib');");
  return true;      
    }
     public function remove($lib){
$this->delete('lib4course', 'lib', $lib);
  return true;      
    }
 
    
}
?>
