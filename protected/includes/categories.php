<?php
$cats=array(
'bibliology'=>'Библиология',
'theology'=>'Систематическое богословие',
'law'=>'Юриспруденция',  
'lang'=>'Библейские языки',  
'hist'=>'История церкви',  
'couns'=>'Душепопечительство',  
'pract'=>'Практическое богословие',  
'edu'=>'Христианское образование',  
 'dev'=>'Развитие личности',
    
);
$categories='';
asort($cats);
foreach($cats as $k=>$v){
$categories.="<option value=\"$k\">$v</option>\n";
}
    
    
?>
