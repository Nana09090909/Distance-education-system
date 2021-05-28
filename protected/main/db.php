<?php
class db{
   
public   function query($q){ 
set_time_limit(0);
$connect = new PDO(PATHTODATABASE);
$sth=$connect->query($q);
if($connect->errorCode() != "00000"){echo"Ошибка связи с базой данных";
$ea=$connect->errorInfo();
echo "Error: ".$ea[2]; die();
}
return $sth;
}
public function delete($where, $what, $value){
    
    return $this->query("DELETE FROM `$where` WHERE `$what`='$value';");   
}
public function selectall($table){
return $this->query("SELECT * FROM `$table`;");

}
public function selectalllimited($table, $where, $what){
    $q="SELECT * FROM `$table` WHERE `$where`='$what';";
return $this->query($q);

}
public function  mfa($r)// Ассоциированный массив строки результата запроса
{
return $result = $r->fetch(PDO::FETCH_ASSOC);
}

public function supermes($q){
if(!is_array($q)){
return   SQLite3::escapeString(trim($q));
} else{
foreach($q as $k=>$v){
$p[$k]=  SQLite3::escapeString(trim($v));
}
return $p;
}
}
public  function restore ($a){
$a=str_replace("\\n", "", $a);
$a=str_replace("\\r", "", $a);
$a=str_replace("\\\"", "\"", $a);
$a=str_replace("\\'", "'", $a);

$a=stripslashes($a);
return $a;
}
public function isthere($table, $what, $value){
    //var_dump($this->mfa($this->query( "SELECT COUNT(*)FROM '".$table."' WHERE `".$what."`='".$value."';")));
    $l=$this->mfa($this->query( "SELECT COUNT(*)FROM '".$table."' WHERE `".$what."`='".$value."';"));
    if($l['COUNT(*)']==0){
        return false;
    }else{ return true;}
    
    
}

}
?>