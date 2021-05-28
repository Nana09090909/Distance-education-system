<?php
class shop extends db{
    public $nuevo = true;
    public $id;
    public $title;
    public $desc;
    public $price;
    public $cat;
    
    public function __construct($id=0) {
        if($id==0){return;}
        $q='SELECT * FROM `shop` WHERE `id`='.$id;
        $v=$this->mfa($this->query($q));
        if(!$v){return;}              
        $nuevo=false;
        $this->id=$v['id'];
        $this->price=$v['price'];
        $this->cat=$v['cat'];
        $this->desc=$this->restore($v['desc']);
        $this->title=$this->restore($v['title']);
        
    }
  public function add(){
        if(!$this->nuevo){return false;}
        $q="INSERT INTO `shop` (`title`,`desc`,`cat`, `price`) VALUES ('".$this->supermes($this->title)."','".$this->supermes($this->desc)."','".$this->cat."','".$this->price."');";             
        $this->query($q);
                return true;
  }  
  public function del(){
      if(!isset($this->id)){return false;}
      $this->delete('shop', 'id', $this->id);
      return true;
  }  
  public function renew(){
       if(!isset($this->id)){return false;}
 $q="UPDATE `shop` SET  `price`='".$this->price."',`title`='".$this->supermes($this->title)."',`desc`='".$this->supermes($this->desc)."',`cat`='".$this->cat."' WHERE `id`='".$this->id."';";      
 $this->query($q);
                return true;
  }
    
}
class shoplist extends db{
    public $number=0;
    public $list=array();
    public function __construct($cat=0 ){
        $where= $cat==0?'':'WHERE `cat`='.$cat."'";
        $q='SELECT * FROM `shop` '.$where.' ORDER BY `title`';
        $r=$this->query($q);
        while($v=$this->mfa($r)){
            $this->list[$v['id']]=array(
                'title'=>$this->restore($v['title']),
                'desc'=>$this->restore($v['desc']),
                'price'=>$v['price'],
                'cat'=>$v['cat'],              
                                );
            $this->number++;
        }
        
        
    }
    
    
}

class buy extends db{
    public $nuevo=true;
    public $id;
    public $user;
    public $item;
    public $orderday;
    public $sentday;
    public $address;
    public $comments;
    public function __construct($id=0){
        if($id==0){return;}
     $q='SELECT * FROM `buy` WHERE `id`='.$id;
        $v=$this->mfa($this->query($q));
        if(!$v){return;}              
        $nuevo=false;
        $this->id=$v['id'];
        $this->user=$v['user'];
        $this->item=$v['item'];
        $this->orderday=$v['orderday'];
        $this->sentday=$v['sentday'];
        $this->address=$this->restore($v['address']);
        $this->comments=$this->restore($v['comments']);
                       
    }
    public function purchase(){
        if(!$this->nuevo){return false;}
        $q="INSERT INTO `buy` (`user`,`item`,`orderday`, `address`, `comments`) VALUES ('".$this->user."', ".$this->item.", date('now'), '".$this->supermes($this->address)."', '".$this->supermes($this->comments)."');";               
        $this->query($q);
                return true;   
    }
    public function send(){
        if($this->nuevo){return false;}
         $this->query("UPDATE `buy` SET `sentday`=date() WHERE `id`={$this->id};");
               
    }
    public function correct(){
        
        if($this->nuevo){return false;}
     $address=$this->supermes($this->address);
         $comments=$this->supermes($this->comments);
        $this->query("UPDATE `buy` SET `sentday`='{$this->sentday}', `orderday`='{$this->orderday}', `user`='{$this->user}', `item`='{$this->item}', `address`='$address', `comments`='$comments'  WHERE `id`={$this->id};");
     return true;   
        
    }
    
    public function del(){
        $this->delete('buy', 'id', $this->id);
        return true;
    }
    
}
class buylist extends db{
   public $number=0;
    public $actuallist=array();
    public $oldlist=array();
    public $list=array();
    public function __construct() {
        $r=$this->selectall('buy');
        while($v=$this->mfa($r)){
            $this->number++;
            $list[$v['id']]=array(
                'user'=>$v['user'],
                'item'=>$v['item'],
                'sentday'=>$v['sentday'],
                'orderday'=>$v['orderday'],
'address'=>$this-restore($v['user']),
                'comments'=>$this->restore('comments'),              
                            );
            if($v['sentday']=='0'){
                $actuallist[$v['id']]=$list[$v['id']];
            }else{
                $oldlist[$v['id']]=$list[$v['id']];
            }
            
        }
        
    }
    
    
    
    
    
}
?>
