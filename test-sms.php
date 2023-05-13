<?php
 header('Access-Control-Allow-Origin: *');
  include("SendingSMS.php");

 $Sending = new SendingSMS(); 
  							
  							
  							$message = "Wynk registeration OTP! Your OTP #8840. Please use it within 3 minutes." ;
  							 
			$sendSMS =	 $Sending->smsAPI("2348091009866","WynksupApp",$message);
			
			
			
			echo $sendSMS;
			
			
			?>