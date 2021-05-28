<?php
class enrollment extends db{
    public $student;
    public $courses=array();
    public function __construct($student='') {
        $this->student=trim($student);
        if($this->student==''){return;}
        $s=$this->query("SELECT * FROM `enrollment` WHERE `student`='{$this->student}';");
        while($r=$this->mfa($s)){
            $this->courses[$r['course']]=array(
                'enrollmentdate'=>$r['enrollmentdate'],
                'finishdate'=>$r['finishdate'],
                'finalgrade'=>$r['finalgrade'],
                'paid'=>$r['status'],
                'payment'=>$this->restore($r['payment']),
            ); 
        }
        
    }
    public function isenrolled($course){
        if(isset($this->courses[$course])){return true;}
        return false;
        
    }
    public function register($course){
        $q="UPDATE `enrollment` SET  `status`='2' WHERE `student`='".$this->student."' AND `course`='".$course."';";
          $this->query($q);
        return true;
    }
     public function getcertificate($course){
        $q="SELECT * FROM `certificate` WHERE `student`='".$this->student."' AND `course`='".$course."';";
        $r=$this->mfa($this->query($q));
        if(!$r){return false;}else{ return $r['id'];}
         
     }
     public function notpaid($course){
        $q="UPDATE `enrollment` SET  `status`='0' WHERE `student`='".$this->student."' AND `course`='".$course."';";
          $this->query($q);
              
        return true;
    }
    
    public function pay($payment, $course){
        $q="UPDATE `enrollment` SET  `status`='1',`payment` = '".$this->supermes($payment)."' WHERE `student`='".$this->student."' AND `course`='".$course."';";
        
        $this->query($q);
        return true;
        
    }
    public function countdays($course){
        if(isset($this->courses[$course]['enrollmentdate'])){$begin=  strtotime($this->courses[$course]['enrollmentdate']);
        $finish=$this->courses[$course]['finishdate'];
        $finish=$finish=='0'?date("Y-m-d"):$finish;
        $end=  strtotime($finish);
        $days=  round(($end-$begin)/86400);  
        return $days;
        }
        return 1000000;
    }
    public function enroll($course){
        $q='INSERT INTO `enrollment` (`student`,`course`, `enrollmentdate`) VALUES (\''.$this->student.'\',\''.$course.'\', date(\'now\'));';
      $this->query($q);       
      return true;
    }
    public function quit($course){
    $frames=new framelist($course);
    foreach($frames->list as $k=>$v){
        $assigments=new assignmentlist($k);
        foreach($assigments->list as $k1=>$v1){
        $this->query("DELETE FROM `grades` WHERE `student`='".$this->student."'AND `assignment`='".$k1."' ;");         
        } 
        
    }
        $this->query("DELETE FROM `enrollment` WHERE `student`='".$this->student."'AND `course`='".$course."' ;");
        $this->query("DELETE FROM `certificate` WHERE `student`='".$this->student."'AND `course`='".$course."' ;");
        return true;
     
    }
    public function fail($course){
        $this->query("UPDATE `enrollment` SET `finishdate`='0', `finalgrade`='0' WHERE `course`='$course';");
        return true;
    }
        public function grade($course, $grade){
$q="UPDATE `enrollment` SET `finishdate` =date('now'), `finalgrade` = '".$grade."' WHERE `student`='".$this->student."' AND `course`='".$course."';";
$this->query($q);            
return true;
                    }
               
    
    
}
class enrollmentlist extends db{
    public $list=array();
    public $justpaid=array();
    public $paid=array();
    public $notpaid=array();
     public $finished=array();
      public $notfinished=array();
      public $justfinished=array();
    public function __construct(){
        $se=$this->selectall('enrollment');
        while($r=$this->mfa($se)){
            $this->list[$r['id']]= array(
                'student'=>$r['student'],
                'enrollmentdate'=>$r['enrollmentdate'],
                'finishdate'=>$r['finishdate'],
                'finalgrade'=>$r['finalgrade'],
                'paid'=>$r['status'],
                'course'=>$r['course'],
                'payment'=>$this->restore($r['payment']),
            );
            if($r['status']==1){$this->justpaid[$r['id']]=$this->list[$r['id']];}
            if($r['status']==0){$this->notpaid[$r['id']]=$this->list[$r['id']];}
            if($r['status']==2){$this->paid[$r['id']]=$this->list[$r['id']];}
            if($r['finalgrade']=='0'){$this->notfinished[$r['id']]=$this->list[$r['id']];}else{
                                $this->finished[$r['id']]=$this->list[$r['id']];
             if($r['finalgrade']=='1'){$this->justfinished[$r['id']]=$this->list[$r['id']]; }                   
             
            }
        }
        
    }
    
   
    
}

?>
