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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wynk Lifestyle</title>
   <!-- <link rel="stylesheet" href="https://wynk.ng/stagging-api/email-temp/style.css" media="all" type="text/css" />-->
    <link rel="icon" href="https://wynk.ng/stagging-api/email-temp/assets/WynkLogo.png" />
    <meta name="robots" content="follow,index" />
    <meta name="author" content="ralp.devops" />
    <meta name="revised" content="27/04/2023" />
	<style>
	
	@import url(\'https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600&family=Poppins:wght@200;300;400;500;600;700;800&family=Roboto:wght@400;500;700&display=swap\');

:root {
    --bg: #f5f5f5;
    --text-color: #030303;
    --link-color: #1877f2;
    --subscribe-color: #7b7b7b;
    --title-bg: #eeeeee;
    --value-bg: #f7f7f7;
}

ul {
    display: flex;
}

ul li {
    padding: .3rem .1rem;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    text-decoration: none;
    list-style: none;
    font-family: \'Poppins\', \'Roboto\', \'Nunito\', \'Lucida Sans\', \'Lucida Sans Regular\', \'Lucida Grande\', \'Lucida Sans Unicode\', Geneva, Verdana, sans-serif;
}

html {
    scroll-behavior: smooth;
}

p {
    font-family: \'Poppins\' !important;
    font-size: .85rem;
    line-height: 175%;
}

a {
    color: var(--link-color);
}

.wrapper {
    width: 100%;
    max-width: 1920px;
    margin: 0 auto;
    padding: 0 1rem;
}

.container {
    width: 100%;
    height: 100vh;
}

header {
    width: 100%;
    width: 100%;
    height: 248px;
    background-image: url(\'https://wynk.ng/stagging-api/email-temp/assets/BlueBackground.png\');
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    object-fit: cover;
    display: flex;
    align-items: center;
    justify-content: center;
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: -35px;
}

.header-content h2 {
    font-size: 20px;
    font-family: \'Poppins\' !important;
    font-weight: 700;
    color: #fff;
    margin: -15px 0 0 -10px;  
}

main {
    width: 100%;
    display: grid;
    place-items: center;
    margin-top: -85px;
    padding: 0 10px;
}

.main__content {
    width: 620px;
    background-color: #fff;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
}

.welcome__info {
    padding: 1.5rem 0 0 1.5rem;
    width: 332px;
}

.welcome__info > h2 {
    font-size: 1.7rem;
    font-weight: 700;
    font-family: \'Poppins\' !important;
    padding-bottom: 1rem;
}

.transaction__info {
    display: grid;
    place-items: center;
    margin-top: 2rem;
}

.transaction__info span {
    width: 200px;
    height: 1px;
    background-color: rgba(0, 0, 0, 0.582);
    display: block;
    text-align: center;
    border-radius: 50%;
    margin: 1.5rem 0;
}

section > aside {
    display: flex;
    justify-content: space-around;
    align-items: stretch;
}

section > aside h2 {
    border-bottom: 1px solid rgb(255, 255, 255);
    width: 100%;
    padding: 1.5rem;
    font-size: 0.85rem;
    display: flex;
}

.subscribe {
    width: 100%;
    padding: 2rem 6rem;
}

.subscribe p {
    color: var(--subscribe-color);
    font-weight: 400;
    font-size: .8rem;
    text-align: center;
}

section > aside h2:nth-child(1){
    background-color: var(--title-bg);
}

section > aside h2:nth-child(2){
    background-color: var(--value-bg);
    font-weight: unset;
}

footer {
    /* background-color: #000; */
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    background-image: url(\'https://wynk.ng/stagging-api/email-temp/assets/BlueBackground.png\');
    background-position: center;
    background-size: cover;
    object-fit: cover;
}

footer p {
    color: white;
    font-weight: 700;
    font-size: .85rem;
    text-align: center;
}

/* ipad*/
@media screen and (max-width: 920px) {
    .wrapper {
        padding: 0;
    }

    .container {
        width: 100%;
    }

    .header-content {
        width: 100%;
        padding: 0 1rem;
    }

    .header-content h2 {
        font-size: 1.2rem;
    }

    main {
        width: 100%;
    }

    
    p {
        font-size: 0.80rem;
        line-height: 195%;
    }

    .welcome__info {
        padding: 1rem 0 0 1rem;
    }
    
    section > aside h2 {
        padding: 1rem;
        font-size: 0.80rem;
    }

    .subscribe {
        padding: 1.3rem;
    }

    footer {
        justify-content: center;
        padding: 3rem 1rem;
    }

    footer section {
        text-align: center;
    }

    footer section:nth-child(2){
        margin-top: 1rem;
    }

}

/*iphone 12 pro max*/

@media screen and (max-width: 520px) {
    
    .main__content {
        width: 100%;    
    }

}

/* iphone xr*/

@media screen and (max-width: 320px){

    .header-content h2 {
        font-size: 1rem; 
    }

    .main__content {
        width: 100%;
    }
    
    .welcome__info {
        width: 100%;
    }

    .transaction__info {
        font-size: .8rem;
    }

    footer section:nth-child(2) img {
        width: 140px;
    }
}
	
	
	</style>
	
	
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <header>
                <div class="header-content">
                    <img src="https://wynk.ng/stagging-api/email-temp/assets/emailenvelop.png" style="width: 120px" alt="wynk-mail-envelop" loading="lazy" />
                    <h2>Wynk Lifestyle Super App</h2>
                </div>
            </header>
            <main>
                <div class="main__content">
                    <section>
                        <div class="welcome__info">
                            <h2>Hi jerry igwilo,</h2>
                            <p>Your WYNKVAULT 420****70 was credited. Please find information below.</p>
                        </div>
                        <div class="transaction__info">
                            <h2>Transaction Information</h2>
                            <span></span>
                        </div>
                    </section>
                    <section>
                        <aside>
                            <h2>Amount:</h2>
                            <h2>NGN100.0</h2>
                        </aside>
                        <aside>
                            <h2>WYNK VaultID:</h2>
                            <h2>420******70</h2>
                        </aside>
                        <aside>
                            <h2>Vault Balance:</h2>
                            <h2>NGN2,59900</h2>
                        </aside>
                        <aside>
                            <h2>Transaction ID:</h2>
                            <h2>WYNK-20230418169174</h2>
                        </aside>
                        <aside>
                            <h2>Transaction Date:</h2>
                            <h2>2023-04-18 20:34:44</h2>
                        </aside>
                        <aside>
                            <h2>Narration:</h2>
                            <h2>V2V TXN from JERRY IGWILO to jerry igwilo </h2>
                        </aside>
                    </section>
                    <section class="subscribe">
                        <p>You are receiving this mail because you conducted a transaction with wynk super app. Update your preferences or <a href="##" target="_blank" rel="noopener noreferrer">Unsubscribe</a> from all emails.</p>
                    </section>
                    <footer>
                        <section>
                            <img src="https://wynk.ng/stagging-api/email-temp/assets/Orange _ White Wynk Logo 2.png" style="width:70px;" alt="WynkLogo" />
                            <ul>
                                <li>
                                    <a href="https://web.facebook.com/wynknigeria/" target="_blank" rel="noopener noreferrer">
                                        <img src="https://wynk.ng/stagging-api/email-temp/assets/facebooklogo.png" alt="wynk-facebook" width="40" />
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/wynk.ng/" target="_blank" rel="noopener noreferrer">
                                        <img src="https://wynk.ng/stagging-api/email-temp/assets/instagramlogo.png" alt="wynk-Instagram" width="40" />
                                    </a>
                                </li>
                                <li>
                                    <a href="##" target="_blank" rel="noopener noreferrer">
                                        <img src="https://wynk.ng/stagging-api/email-temp/assets/tiktoklogo.png" alt="wynk-facebook" width="40" />
                                    </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/LimitedWynk" target="_blank" rel="noopener noreferrer">
                                        <img src="https://wynk.ng/stagging-api/email-temp/assets/twitterlogowynk.png" alt="wynk-Twitter" width="40" />
                                    </a>
                                </li>
                                <li>
                                    <a href="##" target="_blank" rel="noopener noreferrer">
                                        <img src="https://wynk.ng/stagging-api/email-temp/assets/linkedinlogo.png" alt="wynk-linkedIn" width="40" />
                                    </a>
                                </li>
                            </ul>
                        </section>
                        <section>
                            <ul>
                                <li style="margin-right: 5px">
                                    <a href="https://play.google.com/store/apps/details?id=ng.wynk.wynksupappsupapp" target="_blank">
                                        <img src="https://wynk.ng/stagging-api/email-temp/assets/Googleplay.png" alt="wynk-facebook" width="140" />
                                    </a>
                                </li>
                                <li>
                                    <a href="https://apps.apple.com/us/app/wynk-app/id1668382143" target="_blank">
                                        <img src="https://wynk.ng/stagging-api/email-temp/assets/Applestore.png" alt="wynk-facebook" width="140" />
                                    </a>
                                </li>
                            </ul>
                            <p>Rides. Pay. Lifestyle</p>
                        </section>
                    </footer>
                </div>
            </main>
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

