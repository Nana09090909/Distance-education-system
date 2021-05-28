<?php
class frame extends db{
    public $nuevo=true;
    public $course;
    public $order;
    public $desc;
    public $title;
    public $id;
     
    public function __construct($id='') {
        if($id==''){return;}
        $this->id=trim($id);
        $r=$this->mfa($this->selectalllimited ("frames",'id',$this->id));
        if(!$r){
            return;
        }
         $this->nuevo=false;            
        $this->course=$this->restore($r['course']);
        $this->order=$this->restore($r['order']);
       $this->desc=$this->restore($r['desc']);
      $this->title=$this->restore($r['title']);
      
              } 
public function frameisactive($student){
    $al=new assignmentlist($this->id);
    foreach($al->list as $k=>$v){
        $grade=new grades($student,$k);
        
            if(!($grade->submitted)){ return true;}    
                }
      
                return false;
}

              public function add(){
                  $title=$this->supermes($this->title);
                  $desc=$this->supermes($this->desc);
                  $order=$this->supermes($this->order);
                  $course=$this->supermes($this->course);
 $q="INSERT INTO `frames`(`desc`, `title`, `order`, `course`) VALUES('".$desc."','".$title."','".$order."','".$course."');";   
   $this->query($q);
   return true;                  
              }
              public function del(){
                  $assignmentlist=new assignmentlist($this->id);
                  foreach($assignmentlist->list as $k=>$v){
$assignment=new assignment($k);
$assignment->del();
                  }
                  $this->delete('frames', 'id',$this->id);
                  
                  
              }
              public function renew (){
  $q="UPDATE `frames` SET `title`='".$this->supermes($this->title)."',`desc`='".$this->supermes($this->desc)."',`order`='".$this->supermes($this->order)."' WHERE `id`='".$this->supermes($this->id)."';";
     $this->query($q);
     return true;
                                   
              }
              public function moveup(){
                 $this->order=(int)$this->order-1;
                 
                  $this->renew();
                 return true;                  
              
                 
              }
               public function movedown(){
                  $this->order=(int)$this->order+1;
                  $this->renew();
                 return true;                  
              }
              
              public function move($order){
                  $this->order=$order;
                  $this->renew();
                  return true;
              }
              
                      
     
    
    
}
class framelist extends db{
    public $list=array();
    public $course;
    public $number=0;
    public function __construct($course){
        $this->course=$course;
        $fl=$this->query("SELECT * FROM `frames` WHERE `course`='".$course."' ORDER BY `order` ASC");
        while($r=$this->mfa($fl)){
            $this->list[$r['id']]=array(
                'title'=>$this->restore($r['title']),
                'desc'=>$this->restore($r['desc']),                
                'course'=>$r['course'],
                'order'=>$r['order'],
                            );
            $this->number++;                            
        }
    }
    public function calculatecurrent($student){
        $last=-1;
            $maxframe=0;
  (int)$minframe=$this->number+1;
    foreach($this->list as $k=>$v){      
        $assignments=new assignmentlist($k);    
        foreach($assignments->list as $k1=>$v1){
           $grade=new grades($student, $k1); 
            if($grade->submitted){
            $maxframe=$v['order']>$maxframe?$v['order']:$maxframe;
        } else {$minframe=(int)$v['order']<$minframe? (int)$v['order']:$minframe;}
        if($grade->last){ $last=$v['order'];}
        }
    }
    if($maxframe==$minframe ||$maxframe===$last ){
    return $maxframe;    
    }else{
        if($minframe<=$this->number){return $minframe;}else{return false;}
    }        
    }
public function getprevious($student){
    $prev=array();
    $cu=$this->calculatecurrent($student);
    
    if($cu){
        foreach($this->list as $k=>$v){
if($v['order']<$cu){$prev[$k]=$v; }            
        }
       
    }else{
        
    $prev=$this->list;
    }
     return $prev;
}
public function getnext($student){
    $next=array();
    $cu=$this->calculatecurrent($student);
    
    if($cu){
        foreach($this->list as $k=>$v){
if($v['order']>$cu){$next[$k]=$v; }            
        }
        return $next;
    }
    return false;
}
    

public function currentframe($student){
   $cu=$this->calculatecurrent($student); 
   if($cu){return $this->getIdbyOrder($cu);}
   return false;
}
public function listtograde($depth=1){// 1 для зачета 2 для оценки
    $statement=$depth!=1? "(`grade`='1' OR `grade`='2')":"`grade`='1'";
    $listtograde=array();
    foreach ($this->list as $k=>$v){
           $assignmentlist= new assignmentlist($k);
           foreach($assignmentlist->list as $k1=>$v1){

               $re=$this->query("SELECT * FROM `grades` WHERE `assignment`='$k1' AND $statement;");     
           while($r=$this->mfa($re)){
               $listtograde[$r['id']]=array(
                   'frametitle'=>$this->restore($v['title']),
                   'framedesc'=>$this->restore($v['desc']),
                   'frameorder'=>$this->restore($v['order']),
                   'grade'=>$r['grade'],
                   'student'=>$r['student'],
                   'submission'=>$this->restore($r['submission']),
               );
           }    
           }
           
           
           
       }
//       var_dump($listtograde);
    return $listtograde;
}

    
    public function getIdbyOrder($order){
        $order=trim($order);
        foreach($this->list as $k=>$v){
            if($v['order']==$order){
                return $k;
            }
        }
        return false;
            
        
    }
    
   
 public function swap($order1, $order2){
     $id1=getIdbyOrder($order1);
    $id2=getIdbyOrder($order2);
     $a=new frame($id1);
     $b=new frame($id2);
     $a->move($order2);
     $b->move($order1);
     return true;
 }
  
  public function gradebookarray($student, $number=false){
      $n=0;
      $gradebookarray=array();
      $allcompleted=true;
      foreach($this->list as $k=>$v ){
       $al= new assignmentlist($k);
         $grasarray=array();
  foreach( $al->list as $k1=>$v1){    
     $gr=new grades($student, $k1);
      $grasarray[$k1]= $v1+array(
     'grade'=>$gr->grade,          
      'saved'=>$gr->saved,
     'checked'=>$gr->checked,
     'submitted'=>$gr->submitted,
     'submission'=>$gr->submission,
     'comments'=>$gr->comments,
          'graded'=>$gr->graded,
          ); 
      $n++;
      if(!$gr->graded &&!$gr->checked ){$allcompleted=false;}
            
  }
      $gradebookarray[$k]=$v+array('gradeinfo'=>$grasarray);   
         
     
      }
        
  if(!$number){return $gradebookarray;}else{

      return $gradebookarray+array('totalnumber'=>$n, 'allcompleted'=>$allcompleted);
  }      
        
        
    }
 
 
}
?>
