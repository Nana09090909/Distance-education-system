<?php
class course extends db{
   public $nuevo=false;
    public $code='';
public $status=0;
    public $title='';
   public $price='';
   public $desc='';
   public $credits='0';
   public $obligatory='0';
   public $category='none';
   public $teacher=0;
   public function __construct($code=''){
       if($code!==''){
           $this->code=$code;
           $r=$this->mfa($this->query("SELECT * FROM `courses` WHERE `code`='".$this->code."' ORDER BY `category` ASC, `title` ASC ;"));
           if(!$r){ $this->nuevo=true;
      
           }else{
           $this->title=$this->restore($r['title']);
           $this->desc=$this->restore($r['desc']);
           $this->category=$r['category'];
           $this->status=$r['status'];
           $this->credits=$r['credits'];
           $this->obligatory=$r['obligatory'];
           $this->teacher=$r['teacher'];
           $this->price=$r['price'];           
           $this->id=$r['id'];
           
           }
                             }
       
   }
    public function add(){
        if(!isset($this->code)){return false;}
        $q="INSERT INTO `courses` (`code`,`title`,`desc`,`category`, `price`, `credits`, `obligatory`) VALUES ('".$this->code."','".$this->supermes($this->title)."','".$this->supermes($this->desc)."','".$this->category."','".$this->price."','".$this->credits."','".$this->obligatory."');";
              
        $this->query($q);
                return true;
            }
            public function del(){
                if($this->isthere('enrollment', 'course', $this->code)){return false;}
                $this->delete('courses','code', $this->code);
                    return true;
                    
            }
//////////////////
            public function renew(){
                if(!isset($this->code)){return false;}
 $q="UPDATE `courses` SET  `code`='".$this->code."',`price`='".$this->price."',`teacher`='".$this->teacher."',`status`='".$this->status."',`title`='".$this->supermes($this->title)."',`desc`='".$this->supermes($this->desc)."',`category`='".$this->category."',`credits`='".$this->credits."',`obligatory`='".$this->obligatory."' WHERE `code`='".$this->code."';";
        
 $this->query($q);
                return true;
            }
            ///////////////////
            public function setteacher($teacher){
                
                $this->teacher=$teacher;
                $this->renew();
            }
    ////////////////
            public function changestatus($status){
               $this->status=$status;
                $this->renew();
            }
    ////////////////
    
}///////////Конец класса
class courselist extends db{
    public $list=array();
    public $number;
    public $actual=array();
    public $passed=array();
    public $notpaid=array();
    public $tobeenrolled=array();
    public function __construct($which='all', $student='',$teacher='') {
        $pre='WHERE `status`=';
        switch($which){
                 case 'all':
                $where='';
                break;
            case 'unpublished':
                $where=$pre.'0';
                break;
            case 'published':
                $where=$pre.'1';
                                break;
                           }
                               $q=$this->query('SELECT * FROM `courses`'.$where.' ORDER BY `title`;');
       $n=0;
            while($r=$this->mfa($q)){
            $this->list[$r['code']]=array(
                'title'=>$this->restore($r['title']),
                'desc'=>$this->restore($r['desc']),
                'teacher'=>$r['teacher'],
                'category'=>$r['category'],
                'status'=>$r['status'],
                 'credits'=>$r['credits'],
                 'obligatory'=>$r['obligatory'],
                'price'=>$r['price'],
                          );    
            $n++;    
            }           
            $this->number=$n;
                       if($teacher !=''){
             foreach($this->list as $k=>$v){
                 if($v['teacher']!=$teacher){
                     unset($this->list[$k]);
                 }
                 
             }   
                
            }
  
            if($student !=''){
                $enr=new enrollment($student);
                $this->tobeenrolled=$this->list;
                foreach($this->list as $k=>$v){
                    foreach($enr->courses as $k1=>$v1){
                        if($k==$k1){
                           unset($this->tobeenrolled[$k]);
                            if($v1['finalgrade']!='0'){
                                $this->passed[$k]=$v+$v1;
                            }else{
                                $days=$enr->countdays($k);
                                $this->actual[$k]=$v+$v1+array('days'=>$days);
                                if($v1['paid']=='1'){
                                    $this->notpaid[$k]=$v+$v1;
                                }
                            }
                        }
                        
                    }
                    
                    
                }
            }
    }
    
}

?>
