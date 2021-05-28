<?php
class library{
    
    public function index(){
        $list='';
        $la=new liblist();
        
        foreach($la->list as $k=>$v){
         $list.=<<<a
         <div>{$v['title']} <br/>Файл: {$v['file']}"<button onclick="display('editbook','$k')"  class="edit"></button><button onclick="if(confirm('Подтвердите удаление записи')){display('delbook','$k')}" class="del" ></button></div>
a;

            
            
        }
        $list=$list==''?'Книг пока нет':$list;
        return array('layer'=>'lib', 'list'=>$list);
        
    }
    
    public function newbook(){
        if(!isset($_POST['code'])){
            return array('view'=>'administration/error', 'error'=>'Не верное обращение к странице');}
        $v=explode('%%SEPARATOR%%', $_POST['code']);
        $lib=new lib;
        $lib->title=$v[0];
        $lib->file=$v[1];
        if($lib->file==''||$lib->title=='' ){return array('view'=>'administration/error', 'error'=>'Поля новой записи нельзя оставлять пустыми');
        }
        if($lib->add()){
        return array('view'=>'administration/newcreated', 'newcreated'=>'Новая запись создана');}
        else{
          return array('view'=>'administration/error', 'error'=>'Новая запись не создана');
        
        }
        
        
        }
        public function delbook(){
        if(!isset($_POST['code'])){
            return array('view'=>'administration/error', 'error'=>'Не верное обращение к странице');}
                   $lib=new lib($_POST['code']);
        if($lib->del()){
        return array('view'=>'administration/newcreated', 'newcreated'=>'Запись удалена');}
        else{
          return array('view'=>'administration/error', 'error'=>'Запись не удалена');
        
        }
        
            
        }
        public function editbook(){
        if(!isset($_POST['code'])){
            return array('view'=>'administration/error', 'error'=>'Не верное обращение к странице');}
                   $lib=new lib($_POST['code']);
                  
         $file=$lib->file;
         $title=$lib->title;
         return array('file'=>$file, 'title'=>$title, 'id'=>$_POST['code']);
        
            
        }
        public function saveedit(){
            
        if(!isset($_POST['code'])){
          
            return array('view'=>'administration/error', 'error'=>'Не верное обращение к странице');}
             $v=explode('%%SEPARATOR%%', $_POST['code']);
              $lib=new lib($v[2]);
        $lib->title=$v[0];
        $lib->file=$v[1];
         if($lib->file==''||$lib->title=='' ){return array('view'=>'administration/error', 'error'=>'Поля новой записи нельзя оставлять пустыми');}
        if($lib->renew()){
        return array('view'=>'administration/newcreated', 'newcreated'=>'Запись изменена');}
        else{
          return array('view'=>'administration/error', 'error'=>'Запись не изменена');
            
        }
        
        }
  
    
    
}

?>
