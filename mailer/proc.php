<?
include ('actuallist.php');
$ar=file("$list");
foreach($ar as $ar)
{  $hist.=trim($ar).'^%%%%%%%^';}
$hist=substr($hist, 0, strrpos($hist, '^%%%%%%%^'));
echo $hist;
file_put_contents("$list", $hist);

?>