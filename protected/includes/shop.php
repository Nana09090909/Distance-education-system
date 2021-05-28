<?php
$shoparray=array( "1"=>'Спонсироваие курса',
  "2"=>'Спонсирование студента',
  "3"=>'Спонсирование создания курса',
  );
$cats='<option value="0">Выберите категорию товара</option>';
foreach($shoparray as $k=>$v){
    $cats.='<option value="'.$k.'">'.$v.'</option>';
    }

?>
