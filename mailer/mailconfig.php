<?

 $mail->IsSMTP(); // telling the class to use SMTP
 $mail->SMTPDebug  =$SMTPdebug;                     
 $mail->SMTPAuth   = $SMTPAuth;                 
 $mail->CharSet = $CharSet;
 $mail->SMTPSecure = $SMTPSecure;                 
 $mail->Host       = $hostsmtp;      
 $mail->Port       = $port;      
 $mail->Username   = $Username ; 
 $mail->Password   = $Password;
 $mail->AddReplyTo($AddReplyTo, $AddReplyToname);
 
 $mail->From=$From;
 $mail->FromName=$FromName;
?>

