<?
//ini_set('session.save_path', $_SERVER['DOCUMENT_ROOT'] .'/protected/sessions/');
session_name('musia');
session_start();
error_reporting(E_ERROR | E_PARSE);
if($_SESSION['status']!='3'){die('&nbsp;&nbsp;X&nbsp;&nbsp;X <br>&nbsp;&nbsp; L &nbsp;  <br/>&nbsp;&nbsp;&nbsp;()  ');}
require_once('../protected/lib/phpmailer/class.phpmailer.php');

//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
if(isset($_POST["message"])){
$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
try {
     include('config.php');
   include('mailconfig.php');  
$mail->AddAddress($_POST["to"]);
  //$mail->AddReplyTo('name@yourdomain.com', 'First Last');
  $mail->Subject = $_POST["sub"];
  //$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML(stripslashes ($_POST["message"]));
  if($_POST["attach"] !=""){
$atts=explode("/",$_POST["attach"]);
foreach($atts as $a){
$a=trim($a);
if($a != ""){
$mail->AddAttachment('attach/'.$a);
}
}
  
  }
  //$mail->AddAttachment('images/phpmailer.gif');      // attachment
  //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
  $mail->Send();
   $hist=file_get_contents('temp.txt');
  $hist=str_replace('^%%%%%%%^'.$_POST["to"], '', $hist );
  $hist=str_replace( $_POST["to"], '', $hist );
  
file_put_contents('temp.txt', $hist);  
  echo "Письмо отослано успешно".$_POST["to"];
} catch (phpmailerException $e) {
   echo "Maillist_Error:<br/>".$e->errorMessage().'<br/>'. $mail->Username; //Pretty error messages from PHPMailer
} catch (Exception $e) {
 echo $e->getMessage(); //Boring error messages from anything else!
}
}
/*
echo<<<a
<form method='post' action=''>

address<br/>
<input type="text" size="80" name="to"/><br/>

<div>subject
 <br/>
<input type="text" size="80" name="sub"/><br/>
</div><br/>
<div>
<textarea  class="myTextEditor" id="artbody" name="message" cols="100" rows="20">
</textarea></div><br/>
<input type="submit" size="80" value="Send"/><br/>

</form>
a;
*/

?>
