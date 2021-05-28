<?php
class feedback extends db{
    public $nuevo=true;
    public $id;
    public $user;
    public $course;
    public $date;
    public $text;
    public $response="";
    
    public function __construct($id='') {
         if($id==''){return;}
         $this->id=$id;
   $r=$this->mfa($this->query("SELECT * FROM `feedback` WHERE `id`='$id';"));     
    if(!$r){return;}
    $this->user=$r['user'];
    $this->course=$r['course'];
    $this->date=$r['date'];
    $this->text=$this->restore($r['text']);
    
    }
    public function ask(){
        $q="INSERT INTO `feedback` (`user`,`course`,`text`,`date`) VALUES('{$this->user}','{$this->course}','".$this->supermes($this->text)."', DATE('now'));";
        $this->query($q);
        return true;
            }
     public function del(){
   $this->delete('feedback', 'id', $this->id);
         return true;
         
     }
    public function respond(){
        $q="UPDATE `feedback` SET `response`='".$this->supermes($this->response)."', `status`='1' WHERE `id` ='".$this->id."';";
        $this->query($q);
    return true;       
            }
           
}
class feedbacklist extends db{
    public $list=array();
    public $newones=array();
    public $responded=array();
    public function __construct($course){
        $q=$this->query("SELECT * FROM `feedback` WHERE `course`='".$course."' ORDER BY `date`;");
        while($r=$this->mfa($q)){
            $this->list[$r['id']]=array(
             'user'=>$this->restore($r['user']),
             'course'=>$r['course'],
             'text'=>$this->restore($r['text']),
             'date'=>$r['date'],
             'response'=>$r['response'],               
            );
            if($r['status']=='0'){$this->newones[$r['id']]=$this->list[$r['id']];}else{$this->responded[$r['id']]=$this->list[$r['id']];}
            
        }
    }
}

?>
