<?
include('actuallist.php');
$listc=file_get_contents($list);
$listar=explode("^%%%%%%%^", $listc);
$aa=explode("\n", stripslashes($_POST['newlist']));
if($_GET['act']!='count'){
if(count($aa) ==1){if($aa[0]==''){
/*echo<<<a
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<form action="managelist.php?act=add" method="post">
<textarea name="newlist"></textarea>
<input type="submit" value="go" />
</form>
</body>
</html>

a;
*/
exit();
}}}
$mes='';
switch($_GET['act']){
case 'show':
foreach ($listar as $l){
$mes.=$l."\n";
}
break;
case 'add':
foreach($aa as $a){
$a=strtolower(trim($a));
if(preg_match("|^([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})|is",$a)){
array_push($listar, $a);
}
}
$mes="Адреса успешно добавлены";
break;
case 'count':
$count=count($listar);
if($count==1){if($listar[0]==''){$count=0;}}
 $mes='Количество адресов в рассылке '.$count;   
 break;
case 'remove':

foreach($aa as $a){
$a=strtolower(trim($a));
foreach($listar as $k=>$l){
if($l==$a){
unset($listar[$k]);
}
}
}
$mes="Адреса успешно удалены";
break;
}
$listar=array_unique($listar);
sort($listar);
$hist='';
foreach($listar as $ar){
if($ar!=''){
$hist.=trim($ar).'^%%%%%%%^';
}
}
$hist=substr($hist, 0, strrpos($hist, '^%%%%%%%^'));
file_put_contents($list, $hist);
echo $mes;

?>

