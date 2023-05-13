<?php 
 
/* ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);  */
header('Access-Control-Allow-Origin: *');
 
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');
require_once('SendingSMS.php');
require_once('fcm-send-function.php');
require_once('view-application-details.php');
 $Sending = new SendingSMS(); 
$myName = new Name(); 



$fcm = new FCM(); 
$fcmSend = new fcm();
 

 
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
 
$sent_to_email = "olumideogundele@gmail.com";
			if(!empty($sent_to_email))
			{
				
				
				//echo $sent_to_email." <p>";
				 
				
	//echo $email_message." <p> Creditted ";		
		
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.wynk.ng';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'noreply@wynk.ng';                     //SMTP username
    $mail->Password   = 'hollywood2019';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
	$mail->SMTPDebug = false;
	$mail->do_debug = 0;//TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('noreply@wynk.ng', 'WYNK');
    $mail->addAddress($sent_to_email, $sent_to_fname);     //Add a recipient
    
  //  $mail->addCC('olumideogundele@gmail.com');
  //  $mail->addBCC('olumideogundele@gmail.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'WYNK VAULT CREDIT ALERT';
    //$mail->Body    = $email_message ;
    //$mail->AltBody = $message ;
	$mail->msgHTML(file_get_contents('email-temp/index.html'));
	 $mail->Body = file_get_contents('email-temp/index.html');
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
	
			}

 
?>

