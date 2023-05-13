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
 
$sent_to_email = "olumide.ogundele@tinuten.org";
			if(!empty($sent_to_email))
			{
				
				
				//echo $sent_to_email." <p>";
				 
				
	 $send =    '<!DOCTYPE html>
<!-- saved from url=(0014) about:internet -->
<html lang="en" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; scroll-behavior: smooth;">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <title>Wynk Email Template</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600&family=Poppins:wght@200;300;400;500;600;700;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="icon" href="https://wynk.ng/stagging-api/email-temp/assets/TheWynkLogo.png">
    <link rel="stylesheet" href="style.css" media="all" type="text/css" />
</head>
<body style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none;">
    <div class="wrapper" style="box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; width: 100%; max-width: 1920px;  margin: 0 auto; display: grid; place-items: center;">
        <div class="mail__container" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; height: 100vh;">
            <header style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; position: relative; background: url(\'https://wynk.ng/stagging-api/email-temp/assets/BlueBackground.png\'); background-repeat: none; background-position: center; background-size: cover; display: flex; justify-content: center; object-fit: cover;">
                <h4 style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; position: absolute; right: 3rem; padding-top: 1rem; color: whitesmoke; font-size: 1.3rem;">Welcome to Wynk</h4>
                <div class="mail__box" style="margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; padding: 2rem 0 0 0;">
                    <img class="wynkmail" src="https://wynk.ng/stagging-api/email-temp/assets/wynkmail.png" alt="mail-box" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; position: absolute; top: 50%; left: 50%; right: 50%; transform: translate(-50%, -50%); width: 35px;" width="35">
                    <img class="mail" src="https://wynk.ng/stagging-api/email-temp/assets/opened.png" alt="mail-box" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; width: 190px;" width="190">
                </div>
            </header>
            <main style="margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; padding: 2rem 7rem;">
                <section class="welcome__section" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; border-bottom: 1px solid rgba(128, 128, 128, 0.158); padding-bottom: 1rem;">
                    <aside style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; display: grid; place-items: center;">
                        <h3 style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; font-weight: bold; font-size: 2rem; margin-bottom: .75rem;">Hi Jerry,</h3>
                        <p style="padding: 0; margin: 0; box-sizing: border-box; list-style-type: none; text-decoration: none; font-weight: 400; line-height: 170%; width: 540px; height: 96px; text-align: center; font-family: \'Poppins\'; font-size: 0.9rem;">Welcome to <a href="##" target="_blank" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none;">Wynk Lifestyle Super App.</a> Before we get started, we need to verify your details. Please use the code below to verify your email / phone number. This code is valid for 48 hours.</p>  
                    </aside>                  
                    <div class="uuid" style="padding: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; display: grid; place-items: center; margin: 0.3rem 0 2.8rem 0;">
                        <span class="uuid__num" style="margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; text-align: center; border: 1px solid rgba(128, 128, 128, 0.384); padding: .3rem 3rem; font-weight: bold; font-size: 30px; letter-spacing: 0.205em; text-align: center;">26914</span>
                    </div>
                    <p style="padding: 0; margin: 0; box-sizing: border-box; list-style-type: none; text-decoration: none; font-weight: 400; line-height: 170%; width: 440px; height: 96px; font-family: \'Poppins\'; font-size: 0.9rem;">We Wynk you the best!</p>
                    <div class="signature" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; margin-top: -3rem;">
                        <p style="padding: 0; margin: 0; box-sizing: border-box; list-style-type: none; text-decoration: none; font-weight: 400; line-height: 170%; font-family: \'Poppins\'; font-size: 0.9rem;">Team Wynk</p>
                        <p style="padding: 0; margin: 0; box-sizing: border-box; list-style-type: none; text-decoration: none; font-weight: 400; line-height: 170%; font-family: \'Poppins\'; font-size: 0.9rem;"><a href="https://www.wynk.ng" target="_blank" class="wynk__weblink" rel="noopener" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; color: unset;">www.wynk.ng</a></p>
                    </div>
                </section>
                <section class="social__media" style="margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; display: grid; place-items: center; border-bottom: 1px solid rgba(128, 128, 128, 0.158); padding: 1.5rem 0;">
                    <div style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none;">
                        <img src="https://wynk.ng/stagging-api/email-temp/assets/TheWynkLogo3.png" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; width: 160px;" alt="Wynk Logo" width="160">
                    </div>
                    <ul style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; display: flex;">
                        <li style="padding: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; margin: 10px 5px 0 5px;">
                            <a href="https://web.facebook.com/wynknigeria/" target="_blank" rel="noopener" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none;">
                                <img src="https://wynk.ng/stagging-api/email-temp/assets/Facebook svg.png" alt="facebook logo" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; width: 50px;" width="50">
                            </a>
                        </li>
                        <li style="padding: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; margin: 10px 5px 0 5px;">
                            <a href="https://www.instagram.com/wynk.ng/" target="_blank" rel="noopener" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none;">
                                <img src="https://wynk.ng/stagging-api/email-temp/assets/Instagram.svg" alt="facebook logo" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; width: 50px;" width="50">
                            </a>
                        </li>
                        <li style="padding: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; margin: 10px 5px 0 5px;">
                            <a href="https://twitter.com/LimitedWynk" target="_blank" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none;">
                                <img src="https://wynk.ng/stagging-api/email-temp/assets/Twitter.svg" alt="facebook logo" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; width: 50px;" width="50">
                            </a>
                        </li>
                    </ul>
                </section>
                <section class="subscribe" style="margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; display: grid; place-items: center; padding: 1.5rem 0;">
                    <div style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; width: 45%; text-align: center;">
                        <p style="padding: 0; margin: 0; box-sizing: border-box; list-style-type: none; text-decoration: none; font-weight: 400; line-height: 170%; font-family: \'Poppins\'; font-size: 0.9rem;">You are receiving this mail because you registered a wynk account. Update your preferences or <a href="##" target="_blank" rel="noopener" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none;">Unsubscribe</a> from all emails.</p>
                    </div>
                </section>
            </main>
            <footer class="footer" style="margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; display: grid; place-items: center; padding: 3rem 0; background-image: url(\'https://wynk.ng/stagging-api/email-temp/assets/Blue2background.png\'); background-position: center; background-size: cover; object-fit: cover;">
                <div class="download" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none;">
                    <ul style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; display: flex;">
                        <li style="padding: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; margin: 10px 5px 5px 5px;">
                            <a href="https://play.google.com/store/apps/details?id=ng.wynk.wynksupappsupapp" target="_blank" rel="noopener" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none;">
                                <img src="https://wynk.ng/stagging-api/email-temp/assets/Googleplay.png" alt="facebook logo" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; width: 160px;" width="160">
                            </a>
                        </li>
                        <li style="padding: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; margin: 10px 5px 5px 5px;">
                            <a href="https://apps.apple.com/us/app/wynk-app/id1668382143" target="_blank" rel="noopener" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none;">
                                <img src="https://wynk.ng/stagging-api/email-temp/assets/Applestore.png" alt="facebook logo" style="padding: 0; margin: 0; box-sizing: border-box; font-family: \'Poppins\', \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif; list-style-type: none; text-decoration: none; width: 160px;" width="160">
                            </a>
                        </li>
                    </ul>
                </div>
                <p style="padding: 0; margin: 0; box-sizing: border-box; list-style-type: none; text-decoration: none; line-height: 170%; color: whitesmoke; font-weight: 600; font-family: \'Poppins\'; font-size: 0.9rem;">Rides.Pay.Lifestyle</p>
            </footer>
        </div>
    </div>   
</body>
</html>';	
				
				
				
				echo $send;
		
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
	//$mail->msgHTML(file_get_contents('email-temp/index.html'));
	 $mail->Body =  $send;
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
	
			}

 
?>

