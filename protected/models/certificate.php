<?php

class certificate extends db{
    public $nuevo=true;
    public $id;
    public $student;
    public $course;
    public $address;
    public $date;
    public $number;
    public function __construct($id='', $number='') {
        if($id=='' AND $number==''){return;}
        $r=$this->mfa($this->query("SELECT * FROM `certificate` WHERE `id`=$id;"));
        if(!$r){return;}else{
            $this->id=$id;
            $this->nuevo=false;
            $this->student=$r['student'];
            $this->course=$r['course'];
            $this->address=$this->restore($r['address']);
            $this->number=$r['number'];
            $this->date=$r['date'];
            return;            
        }
    }
    
    public function ask(){
        $q="INSERT INTO `certificate`(`student`, `course`,`address`, `number`, `date`) VALUES('{$this->student}','{$this->course}','".$this->supermes($this->address)."', '0','0')";
 $this->query($q);
 return true;
    }
    public function send(){
        $q="UPDATE `certificate` SET `address`='".$this->supermes($this->address)."', `number`= '{$this->number}', `date`=date('now') WHERE `id`='{$this->id}';";
        $this->query($q);
 return true;
    }
    public function unsend(){
        $q="UPDATE `certificate` SET `address`='".$this->supermes($this->address)."', `number`= '0', `date`='0' WHERE `id`='{$this->id}';";
        $this->query($q);
 return true;
    }
    
    
}
class certificatelist extends db{
    public $list=array();
    public $number=0;
    public $sent=array();
    public $pending=array();
    public function __construct() {
        $re=$this->selectall('certificate');
        while($r=$this->mfa($re)){
            $this->list[$r['id']]=array(
                'student'=>$r['student'],
                'course'=>$r['course'],
                'date'=>$r['date'],
                'address'=>$this->restore($r['address']),
                'number'=>$r['number'],
            );
          if($r['date']=='0'){ $this->pending[$r['id']]=$this->list[$r['id']]; }else{ $this->sent[$r['id']]=$this->list[$r['id']]; }
            
        }
    }
    
    
    
    
}
?>
