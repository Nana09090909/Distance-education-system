<?php
class assignment extends db{
    public $nuevo=true;
    public $frame;
    public $code;
    public $params;
    public $auto=0;
    public $html;
    public $paramsarray=array();
    public $title;
    public $id;
   public function __construct($id='') {
        if($id==''){return;}
        $this->id=trim($id);
        $r=$this->mfa($this->selectalllimited ("assignments",'id',$this->id));
        if(!$r){
            return;
        }
      $this->nuevo=false;                  
      $this->frame=$this->restore($r['frame']);
      $this->code=$this->restore($r['code']);
$this->auto=$r['auto'];
$fr=new frame($this->frame);
      $this->params=$this->restore($r['params']);
     // var_dump($r['params']);
      eval("\$params=array(".$this->restore($r['params']).");");
      if(file_exists('convert/'.$fr->course)){ 
        
    $replacearr=json_decode(file_get_contents('convert/'.$fr->course),1);//Это костыль после смены места хранения материалов. 
    $newparams=$this->replaceass($this->code,$params,$replacearr);
    $this->code=$newparams[0];
    $params=$newparams[1];
}
 $atype=new atype($this->code);
      $this->title=$atype->title;
     
      $params['ini']=isset($params['ini'])?$this->ini($params['ini']):'';
      $params['server']=  serverchooser::choose();
     $this->paramsarray = $params;
     $html=$atype->html;
     if(count($params)>0){
         foreach($params as $k=>$v){
    $html=  str_replace('%%'.$k.'%%',$v ,$html);
    
                      }
         
     }
    
     $html=  str_replace('%%thisassignment%%',$this->id ,$html);
     
     $this->html=$html;
              } 
              
public function replaceass($code, $old, $new){
    switch($code){
        
        case 'flowkonspekt':
            if(key_exists($old['file'], $new)){
                $code='google';
                $id=extractlink($new[$old['file']]);
                $old=array('id'=>$id);
            }          
                break;
                
        case 'iframeconspect':
           
            $fc=explode('=',$old['file']);
            if(!isset($fc[1])){$fc[1]=$old['file'];}
            $flv=$fc[0].'.flv';                   
            $fm=explode('.',$old['file']);                        
            $mp3=$fm[0].'.mp3';
            $mp4=$fm[0].'.mp4';
               if(key_exists($flv, $new)){
             $code='google';
                $id=extractlink($new[$flv]);
                $old=array('id'=>$id);
            }
            if(key_exists($mp4, $new)){
             $code='google';
                $id=extractlink($new[$mp4]);
                $old=array('id'=>$id);
            }
           
            if(key_exists($fc[1], $new)){            
             $code='google';
                $id=extractlink($new[$fc[1]]);
                $old=array('id'=>$id);
           
            }
         if(key_exists($mp3, $new)){
             $code='googleaudio';
                $id=extractlink($new[$mp3]);
                $old=array('id'=>$id);
            }
            break;
        case 'audcontent':
            if(key_exists($old['file'].'.mp3', $new)){
                $code='googleaudiocontent';
                 $id=extractlink($new[$old['file'].'.mp3']);
                $old=array('id'=>$id, 'content'=>$old['content']);
            }
            break;
            
              case 'aud':
            if(key_exists($old['file'].'.mp3', $new)){
                $code='googleaudio';
                 $id=extractlink($new[$old['file'].'.mp3']);
                $old=array('id'=>$id);
            }
            break;
   case 'agal':
            if(key_exists($old['file'].'.mp3', $new)){
                if(key_exists($old['file'].'.pptx', $new)){
                $code='googleaudipresent';
                 $id=extractlink($new[$old['file'].'.mp3']);
                 $present=extractlink($new[$old['file'].'.pptx']);
                $old=array('id'=>$id, 'present'=>$present);
                }elseif(key_exists($old['file'].'.ppt', $new)){
                $code='googleaudipresent';
                 $id=extractlink($new[$old['file'].'.mp3']);
                 $present=extractlink($new[$old['file'].'.ppt']);
                $old=array('id'=>$id, 'present'=>$present);                    
                }else{
                    $code='googleaudio';
                 $id=extractlink($new[$old['file'].'.mp3']);
                $old=array('id'=>$id);  
                }
            }
            break;            
        case 'grezad':
        if(key_exists($old['img'].'.jpg', $new)){
                $code='newgre';
                $id=extractlink($new[$old['img'].'.jpg']);
                $old=array('img'=>$id);
            }              
        break;
          case 'awhk':
        if(key_exists($old['img'].'.jpg', $new)){
                $code='newhebrewassign';
                $id=extractlink($new[$old['img'].'.jpg']);
                $old=array('img'=>$id);
            }              
        break;
            case 'greframe':
                $grepar=array();
                for($i=1;$i<10;$i++){
                   $grepar[$i.'.flv']='1-0'.$i.'.flv';
                }
                for($i=10;$i<12;$i++){
                   $grepar[$i.'.flv']='1-'.$i.'.flv';
                }
                     for($i=12;$i<21;$i++){
                         $j=$i-11;                        
                   $grepar[$i.'.flv']='2-0'.$j.'.flv';
                }
                 for($i=21;$i<23;$i++){
                       $j=$i-11;      
                   $grepar[$i.'.flv']='2-'.$j.'.flv';
                }
           for($i=1;$i<10;$i++){
                                                 
                   $grepar['0'.$i.'.mp4']='3-0'.$i.'.mp4';
                }
                 $grepar['10.mp4']='3-10.mp4';
                
            if(key_exists($grepar[$old['file']], $new)){
                $code='newgrelect';
                 $id=extractlink($new[$grepar[$old['file']]]);
                $old=array('id'=>$id);
            }
            break;
        
    }
    
    
    
    return array($code, $old);
}              
              
      public function add(){
               $q="INSERT INTO `assignments` (`frame`, `code`, `params`,`auto`) VALUES('".$this->frame."','".$this->code."','".$this->supermes($this->params)."','".$this->auto."')";
          $this->query($q);
return true;
}
public function ini($ini){
        switch($ini){
            case'getskype':
                return 'Мой текущий Скайп: <b>'.$_SESSION['skype'].'</b><br/>Я могу сдать экзамен в следуещее время: (<u>укажите возможные дату и время</u>).<br/> Дополнительной информации нет.';
                break;
            default:
                return $ini;
               
            
        }
}
public function del(){
   $this->delete('grades','assignment',$this->id);
    $this->delete('assignments','id',$this->id);
    return true;
}
public function renew(){
$q="UPDATE `assignments` SET `auto`='".$this->auto."',`frame`='".$this->frame."', `code`='".$this->code."', `params`='".$this->supermes($this->params)."' WHERE `id`='".$this->id."';";
$this->query($q); 
return true;
}             
              

              
}
class assignmentlist extends db{
    public $list=array();
    public $number=0;
    public function __construct($frame){
        $q=$this->selectalllimited ('assignments','frame',$frame);
        while($r=$this->mfa($q)){
            $this->list[$r['id']]=array(
                'frame'=>$r['frame'],
                'code'=>$r['code'],
                'params'=>$r['params'],
                'auto'=>$r['auto'],
                            );
             $this->number++;
                    }    
                
    }
    
    
}

?>
