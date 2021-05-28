<?php
class grades extends db{
    public $saved=false;
    public $submitted=false;
    public $graded=false;
    public $last=false;
    public $student;
    public $grade='';
    public $assignment;
    public $checked=false;
    public $submission='';
    public $comments='';
    public $id;
    public function __construct($student='', $assignment='', $id=''){
        if( $id==''){
            $this->assignment=$assignment;
        $this->student=$student;
        $r=$this->mfa($this->query("SELECT * FROM `grades` WHERE `assignment` ='$assignment' AND `student`='$student';"));            
        }else{    
             $this->id=$id;
        $r=$this->mfa($this->query("SELECT * FROM `grades` WHERE `id` ='$id';"));
        }
        if(!$r){ return;}
        $this->saved=true;
        if($r['grade']!='0'){
            $this->submitted=true;
        
        if($r['grade']=='1'){$this->last=true;}else{$this->graded=true;}
        if($r['grade']=='2'){$this->checked=true;}
            
        }
        $this->grade=$r['grade'] ;
        $this->id=$r['id'] ;
        $this->submission=$this->restore($r['submission']) ;
        $this->comments=$this->restore($r['comments']) ;                 
        $this->assignment=$r['assignment'];
        $this->student=$r['student'];
        
    }
        
    public function save(){
        if(!$this->saved){
        $q="INSERT INTO `grades` (`assignment`, `student`, `submission`) VALUES('".$this->assignment."', '".$this->student."', '".$this->supermes($this->submission)."');";
        $this->query($q);
        }else{
        $q="UPDATE `grades` SET `submission`='".$this->supermes($this->submission)."' WHERE `id`=".$this->id.";";
        $this->query($q);
            
        }
        return true;
    }
    public function submit(){
        if($this->student==''){die();}
        $ass=new assignment($this->assignment);
        $grade=$ass->auto=='0'?'1':'2';
        if(!$this->saved){
        $q="INSERT INTO `grades` (`assignment`, `student`, `submission`, `grade`) VALUES('".$this->assignment."', '".$this->student."', '".$this->supermes($this->submission)."', '".$grade."');";
        $this->query($q);           
        }else{
        $q="UPDATE `grades` SET `submission`='".$this->supermes($this->submission)."', `grade`='".$grade."' WHERE `id`=".$this->id.";";
        $this->query($q);
            
        }
   return true;
        
    }
    public function grade(){
        if($this->saved){
        $q="UPDATE `grades` SET `grade`='".trim($this->grade)."', `comments`='".$this->supermes($this->comments)."' WHERE `id`=".$this->id.";";
                 }else{
                     $q="INSERT INTO `grades` (`assignment`, `student`, `submission`, `grade`, `comments`) VALUES('".$this->assignment."', '".$this->student."', '".$this->supermes($this->submission)."', '".$this->grade."', '".$this->supermes($this->comments)."');";                    
                                      }
                 
                  $this->query($q);
        return true;
    }
   
    public function passed(){
        $this->grade='2';
        return $this->grade();
    }
    public function fail(){
        $this->grade='0';
        return $this->grade();
    }
}
class gradelist extends db{
    public $list=array();
    public $number=0;
    public function __construct($depth=2){//1 - ожидает зачет 2 - ожидает оценки
        $l="SELECT * FROM `grades` WHERE `grade`='$depth';";
       // echo $l;
   $q=$this->query($l);         
   while($r=$this->mfa($q)){
   $this->list[$r['id']]=array(
       'student'=>$r['student'],
       'assignment'=>$this->restore($r['assignment']),
       'submission'=>$this->restore($r['submission']),
       'comments'=>$this->restore($r['comments']),
       'grade'=>$r['grade'],
             
       
   ); 
   $this->number++;
    }
     
   
    }
    
}

?>
