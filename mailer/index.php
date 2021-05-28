<? 
//ini_set('session.save_path', $_SERVER['DOCUMENT_ROOT'] .'/protected/sessions/');
session_name('musia');
session_start();
error_reporting(E_ERROR | E_PARSE);
//var_dump($_SESSION);
if($_SESSION['status']!='3'){ die('&nbsp;&nbsp;X&nbsp;&nbsp;X <br>&nbsp;&nbsp; L &nbsp;  <br/>&nbsp;&nbsp;&nbsp;()  ');}
require_once("config.php");


if(isset($_POST['chooselist'])){
$chooselist=<<<a
<?
\$list='{$_POST['chooselist']}';
?>
a;
file_put_contents('actuallist.php',$chooselist);
echo <<<a
<script>location.replace('index.php')</script> 
a;
}
if(isset($_FILES["pics"])){
include("../protected/lib/class_upload/class.upload.php");
$handle = new Upload($_FILES['pics']);
$newname=translitIt($_FILES['pics']['name']);
$newname=substr($newname,0 ,strrpos($newname,'.'));
$handle->file_new_name_body=$newname;
if($handle->uploaded){$handle->process('../mailpics');
$handle->image_resize            = true;
$handle->image_ratio_x           = true;
$handle->image_y                 = 250;
$handle->file_new_name_body = 'tn_'.$newname;
$handle->process('../mailpics');
}
echo <<<a
<script>location.replace('index.php')</script>
    
a;
}
if(isset($_GET['newlist']) && $_GET['newlist']!=''){
$newlistname=substr(md5(time()), 0, 6).'.txt';
$f=fopen($newlistname, 'w');
$getconfig=file_get_contents('config.php');
$getconfig=str_replace(');', '\''.$newlistname.'\'=>\''.$_GET['newlist']."',\n);", $getconfig);  
file_put_contents('config.php', $getconfig);
echo <<<a
<script>alert('Новый список успешно создан');location.replace('index.php')</script>
    
a;
}

if(isset($_FILES["attachment"])){
include("../protected/lib/class_upload/class.upload.php");
$handle = new Upload($_FILES['attachment']);
$newname=translitIt($_FILES['attachment']['name']);
$handle->file_new_name_body= substr($newname,0 ,strrpos($newname,'.'));
if($handle->uploaded){$handle->process('attach');}
}
if(isset($_GET[delete])){
unlink('attach/'.$_GET[delete]);
echo <<<a
<script>location.replace('index.php')</script>
a;
}
if(isset($_GET['deletepic'])){
unlink('../mailpics/'.$_GET[deletepic]);
unlink('../mailpics/tn_'.$_GET[deletepic]);
echo <<<a
<script>location.replace('index.php')</script>
a;
}
include('report.php');
include('actuallist.php');
$prev_sub=stripslashes($prev_sub);
$prev_message=stripslashes($prev_message);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Рассылка</title>
<script src="http://yandex.st/jquery/1.8.1/jquery.min.js"></script>
<script src="http://yandex.st/jquery-ui/1.8.23/jquery-ui.min.js"></script>
<script src="../js/tiny_mce/tiny_mce.js"></script>
<script src="js.js"></script>
<link rel="stylesheet" href='jquery.ui.all.css'">
    <style>	.ui-progressbar .ui-progressbar-value { background-image: url(pbar-ani.gif); }	</style>
<style type="text/css">
body{  background-image:url(happymail.jpg); background-repeat:repeat;}
.editor{ position:absolute; left:10%; top:40px; width:80%; background-color:#FFFFFF; padding:40px;}
.sender{ width:100%; position:absolute; top:0; left:0; display:none; background:#EEEEEE; height:100%; z-index:5;}
.list{ width:100%; position:absolute; top:0; left:0; display:none; background:#EEEEEE; height:100%; z-index:5;}
.pics{ float:left; padding:5px; text-indent:5px;}
.pics1{ z-index:1}
.delattach{color:red; cursor:pointer; margin-left:20px}
#wrapper{ position:absolute; left:10%; top: 40px; width:80%; background-color:#000000}
#diagram{background-color:#FFFFFF; font-size:24px; color:#FF0000; font-weight:bold}
#wrapper1{ position:absolute; left:10%; top: 40px; padding:40px; width:80%; background-color:#FFFFFF}
#header{ text-align:center; font-weight:bold; color:#FFFFFF;font-size:24px; font-family:Arial, Helvetica, sans-serif; padding-top:20px}
#message{ height:200px; background-color:#CCCCCC; text-align:center; padding-top:100px;}


</style>
</head>

<body>
<!-- TinyMCE -->
<script type="text/javascript">
function tmce(){
tinyMCE.init({
		// General options
	    mode : "specific_textareas",
        editor_selector : "myTextEditor",
		language : "ru",
		id:"main",
  relative_urls : false,
   remove_script_host : false,  
		theme : "advanced",
	

		plugins : "autolink,lists,save,pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
	

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'blue header', block : 'h1', styles : {color : '#0000ff'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
	
	});
	
}
tmce();
</script>
<div class="sender">
<div id="wrapper">
<div id="header">ИДЕТ ОТПРАВКА ПОЧТЫ <br/><img src="r11.gif"/></div>
<div id="diagram"></div>
<div id="progressbar"></div>
<div id="message">
</div>
</div>

</div>
<div class="list">

<div id="wrapper1">
<button onClick="location.reload();" >Закончить редактирование</button>
 <h3>Управление списком адресов</h3>
<p> Сейчас рабочий список: <? echo $lists[$list]; ?></p>
<input type="button"  style="float:right" id="newlistbutton" onClick="shownewlist()" value="Создать новую рассылку"/>
<input id="newlist" style="display:none; float:right" type="text" placeholder="Название рассылки"/>


<?
if($status==1){
 foreach($lists as $k=>$v){
$select.=$k==$list?'<option value="'.$k.'" selected>'.$v.'</option>':'<option value="'.$k.'">'.$v.'</option>';
}
echo<<<a
<br/> <form action='index.php' method='post'><select name='chooselist'>
 $select</select><input type='submit' value='Изменить'/></form>

a;
 }
?>

</p>
 <textarea id="addresses"  style="aria-hidden:false; display:block" cols="100" rows="20">Введите адреса в столбик</textarea><br/>
<button onClick="managelist('add')" > Добавить адреса</button><button onClick="managelist('remove')">Убрать адреса</button>
<button onClick="managelist('count')"> Посчитать адреса</button><button onClick="managelist('show')"> Показать адреса</button>
</div>
</div>

<div class="editor">
<img style=" width:15%; float: right"  src="logo.jpg"/>

<h2><?  echo $title; ?></h2>
<p> Сейчас рабочий список: <? echo $lists[$list]; ?>

<p style="color:red"><? 
$resetb="<button onclick=\"$.ajax({url:'hist.php?act=finish', success:function(e){
    tinyMCE.activeEditor.remove(); location.reload();}})\">Сброс</button>";
$saveb="<button onclick=\"save()\">Сохранить</button>";
if($status==0){
echo "Предыдущая рассылка не завершена! <button onclick=\"start('repeatthis')\">Завершить</button> $resetb ";}
if($status==2){echo "Это черновик не разосланой рассылки! $resetb $saveb ";}  
if($status==1){ echo $saveb;}
?>
</p>
<div style="float:right"><button onClick="$('.list').fadeIn('slow'); $('.editor').fadeOut('slow');"><small>Управление списком</small></button></div>


<div>Тема <br/>
<input type="text" size="80" id="theme" value="<? echo $prev_sub; ?>"/><br/>
</div><br/>

<textarea  class="myTextEditor"  id="artbody" name="content" cols="100" rows="20"> <? echo $prev_message; ?>
</textarea><br/>
<button id="remove" onClick="tinyMCE.activeEditor.remove(); $('#show').show(); $(this).hide(); $('#test').hide(); ">Убрать редактор</button>

<button style="display:none" id="show" onClick="tmce(); $('#remove').show(); $(this).hide(); $('#test').show();">Добавить редактор</button>


<table><tr><td style="width:500px"><h3>Файлы приложения</h3><table>
<?
$attach = scandir('attach'); //Includin
//
//
//
//g files from the objects directory
foreach($attach as $attach){
if (($attach !== ".")&&($attach !== "..")){echo "<tr><td>".$attach."</td><td><input type='checkbox' value='".$attach."'/></td><td> <span filename='".$attach."'  onclick=\"delattach($(this).attr('filename'))\" class='delattach'>X</span></td></tr>";}
}

?>
</table><form enctype="multipart/form-data" onSubmit="" method="post" action="">
   <input type="file" size="32" name="attachment" value=""/>
   <input type="submit" name="Submit" value="Загрузить приложение"/>
 </form></td><td></td></tr></table>
 
 
<br/>
 
<hr/><hr/>
<div id="test">
<h3>Рассылка</h3>
<input id="tempaddress" type="text"  placeholder="адрес для тестирования"/>
<button onClick="start('trythis')">Тестировать рассылку</button>
<button onClick="start('dothis')">Начать рассылку</button>
<hr/><hr/>
<h3>Галерея</h3>
<small style="color:red">Удаление картинки влечет невозможность ее отображения в письмах!!!</small>
<br/><br/>
<?
$pics = scandir('../mailpics'); //Including files from the objects directory
foreach($pics as $pics){
if (($pics !== ".")&&($pics !== "..")){
if(!strpos($pics,"n_")){
echo "<div class=\"pics\"><img width='50px' class='pics1' src='".$maindir."/mailpics/tn_".$pics."'/><br/><input filename='".$pics."' type='button' onclick=\"addill($(this).attr('filename'),'".$maindir."' )\" value=\"Вставить\"/><br/><span filename='".$pics."'  onclick=\"delpics($(this).attr('filename'))\"  class='delattach'>X</span></div>";
}
}
}
?>



<form enctype="multipart/form-data" method="post" action="">
  <input type="file" size="32" name="pics" value=""/>
   <input type="submit" name="Submit" value="Загрузить картинку"/>
 </form>
 <div style="height:200px"></div>
 
</div>
<a style="display: block; float:right; font-size:10px; color:red" href="mailto:mail@popov.es" >Разработка А.Попов</a>
</div>
<?
if($key!=""){
echo<<<a
<small><a href="index.php?exit=true"><img src="key_small.gif"/></a></small>
a;
}
?>
</body>
</html>
