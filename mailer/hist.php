<?
include ('actuallist.php');
if($_GET['act']=='start'){
file_put_contents('temp.txt',file_get_contents("$list"));
$sub=addslashes($_POST["sub"]);
$message=addslashes($_POST["message"]);
$histcont=<<<a
<?
\$status=0;
\$prev_sub="$sub";
\$prev_message="$message";
?>
a;
file_put_contents('report.php', $histcont);
}
if($_GET['act']=='finish'){
$message=addslashes(file_get_contents('template.html'));

$histcont=<<<a
<?
\$status=1;
\$prev_sub="";
\$prev_message="$message";

?>
a;
file_put_contents('report.php', $histcont);

}
if($_GET['act']=='save'){
$sub=addslashes($_POST["sub"]);
$message=addslashes($_POST["message"]);
$histcont=<<<a
<?
\$status=2;
\$prev_sub="$sub";
\$prev_message="$message";
?>
a;
file_put_contents('report.php', $histcont);
}


?>