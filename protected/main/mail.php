<?php
/*Класс для отсылки почты
 * Настройка в файле mailconfig.php
 * Аттачменты добавлять в виде полного пути с разделителем %ATTACH%
 * 
 */

class mailer {
public static function send($address, $subject, $message, $attach='',$toname='', $AddReplyTo='', $AddReplyToname='' ){
    include('protected/mailconfig.php');
    $AddReplyTo=$AddReplyTo===""?$From:$AddReplyTo; 
    $AddReplyToname=$AddReplyToname===""?$FromName:$AddReplyToname; 
 $toname= $toname==''?$address:$toname;   
switch($mailmode){
    case "smtp":
        if(!$address){echo'Нет информации об адресе электронной почты!';return false;}
        if(self::sendSMTP($address, $subject, $message, $attach, $toname, $AddReplyTo, $AddReplyToname)){
            return true;}
        else{
              echo 'Все под контролем!<br/> Письмо отсылается с альтернативного почтового ящика! <br/>';
            return self::sendSMTP($address, $subject, $message, $attach, $toname, $AddReplyTo, $AddReplyToname, 2);
        }
        
        break;
      case "sendmail":
        return self::sendSendmail($address, $subject, $message, $attach, $toname, $AddReplyTo, $AddReplyToname);
        break;
    default :
        return true;
}
    
    
}

private static function sendSMTP($address, $subject,$message,  $attach, $toname, $AddReplyTo, $AddReplyToname, $server=1){
require_once('protected/lib/phpmailer/class.phpmailer.php');
$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
try {
    $configplace=$server==1?'protected/mailconfig.php':'protected/mailconfig1.php';
include($configplace);
 
 $mail->From=$From;
 $mail->FromName=$FromName;
 
 $mail->IsSMTP();
$mail->Host       = $hostsmtp;      
$mail->SMTPDebug=$SMTPdebug; 
$mail->SMTPAuth=$SMTPAuth;
$mail->CharSet = $CharSet;
$mail->SMTPSecure = $SMTPSecure;
$mail->Port       = $Port;
$mail->Username   = $Username;
$mail->Password   = $Password;
$mail->From=$From;
$mail->FromName=$FromName;
$mail->Sender=$From;
$mail->ReturnPath=$_SESSION['email'];
$mail->AddAddress($address, $toname);
$mail->AddReplyTo($AddReplyTo, $AddReplyToname);
$mail->Subject = stripslashes($subject);
  $mail->MsgHTML(stripslashes ($message));
  if($attach !=""){
$atts=explode("%ATTACH%",$attach);
foreach($atts as $a){
$a=trim($a);
if($a != ""){
$mail->AddAttachment($a);
}
}
  
  }
  //var_dump($mail);
  $mail->Send();
  return true;
} catch (phpmailerException $e) {
 echo 'Произошла ошибка отправки почты через сайт. Пожалуйста, сообщите об этом сисадмину.'.$e->errorMessage(); //Pretty error messages from PHPMailer
  return false;
} catch (Exception $e) {
 echo $e->getMessage(); //Boring error messages from anything else!
 return false;
}
}

private static function sendSendmail($address, $subject,$message, $attach, $toname, $AddReplyTo, $AddReplyToname){
require_once('protected/lib/phpmailer/class.phpmailer.php');

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
try {
include('protected/mailconfig.php');
$mail->IsSendmail(); 
$mail->From=$From;
$mail->FromName=$FromName;
$mail->Host       = $hostsmtp;      
$mail->SMTPDebug=$SMTPdebug; 
$mail->CharSet = $CharSet;
$mail->From=$From;
$mail->FromName=$FromName;
$mail->AddAddress($address, $toname);
$mail->AddReplyTo($AddReplyTo, $AddReplyToname);
$mail->Subject = stripslashes($subject);
$mail->MsgHTML(stripslashes ($message));
if($attach !=""){
$atts=explode("%ATTACH%",$attach);
foreach($atts as $a){
$a=trim($a);
if($a != ""){
$mail->AddAttachment($a);
}
}
  
  }

  $mail->Send();
  return true;
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
  return false;
} catch (Exception $e) {
 echo $e->getMessage(); //Boring error messages from anything else!
 return false;
}
}


 
 


    
    
    
}

?>