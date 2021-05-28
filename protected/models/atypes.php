<?php

class atype extends db{
    public $code;
    public $nuevo=false;
    public $title;
    public $html;
    public $params;
    public function __construct($code=''){
        $r=$this->mfa($this->query("SELECT * FROM `assignment_types` WHERE `code`='".$code."';"));
        if(!$r){$this->nuevo=true;}
        else{
            $this->code=$this->restore($r['code']);
            $this->title=$this->restore($r['title']);
            $this->html=$this->restore($r['html']);
            $this->params=$this->restore($r['params']);
             }
        
    }
    //////////////////////
    
    ////////////
    public function create(){
                $code=$this->supermes($this->code);
                        $title=$this->supermes($this->title);
                                $html=$this->supermes($this->html);
                                        $params=$this->supermes($this->params);
 $q="INSERT INTO `assignment_types`(`code`, `title`, `html`, `params`) VALUES('".$code."','".$title."','".$html."','".$params."');";   
   $this->query($q);
   return true;
        }
    //////////
        
        public function del(){
            if($this->isthere('assignments','code', $this->code)){
               
                return false;
            }   
            $this->delete('assignment_types','code', $this->code);
                    return true;
        }
                    
        
        
        ////////////////////
        public function renew(){
           $q="UPDATE `assignment_types` SET `html`='".$this->supermes($this->html)."',`params`='".$this->supermes($this->params)."',`title`='".$this->supermes($this->title)."' WHERE `code`='".$this->supermes($this->code)."';";
        $this->query($q);
        return true;
        
        }
    
}
///////// List of all types of assignments
class atypelist extends db{
    public $list=array();
    public $number=0;
    public function __construct(){
                $c=$this->selectall('assignment_types');
            while($r=$this->mfa($c)){
                $this->list[$this->restore($r['code'])]=array(
                    'title'=>$this->restore($r['title']),
                    'html'=>$this->restore($r['html']),
                    'params'=>$this->restore($r['params']),                                       
                );
                $this->number++;
            }
           
    }
    public function makeoptions(){
        $options='';
        foreach ($this->list as $k=>$v){
            $options.='<option value="'.$k.'">'.$v['title'].'</option>';
        }
        return $options;
    }
    
}
?>
