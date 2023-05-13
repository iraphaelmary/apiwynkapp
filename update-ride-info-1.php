 
<?php

header('Access-Control-Allow-Origin: *');
include ("config/DB_config.php"); 
include ("class_file.php");
include("view-application-details.php");
 include("SendingSMS.php");


 $myName = new Name();
  $difference = "Not Ended Yet!";


$json =  json_decode(file_get_contents('php://input'), true);

 

 


$username = $json['wynkid'];







 if(!empty($username))
 {
  $id = $json["ride_code"];
  $ride_code = $json["ride_code"];
	 $columnValue2 = "";
      $columnValue3 = 1;
	$columnValue = $json["ride_status"];  
	$emailing = $json["wynkid"];  
	$lati = $json["currentLat"];  
	$longi = $json["currentLong"];  
     
     
     $currentLat = $json['currentLat'];
	$currentLong = $json['currentLong'];
    
 
     

            
                                                    $statusParam = "";
                                                    if($columnValue == 8)
                                                    {
                                                        $columnValue2 = 8;
                                                         $statusParam = "Trip Started";
                                                         $columnValue3 = 8;
                                                    }
                                                    else  if($columnValue == 9)
                                                    {
                                                        $columnValue2 = 9;
                                                         $statusParam = "Trip Ended";
                                                         $columnValue3 = 1;
                                                    }else  if($columnValue == 7)
                                                    {
                                                        $columnValue2 = 7;
                                                         $statusParam = "Arrived";
                                                         $columnValue3 = 7;
                                                    }else  if($columnValue == 3)
                                                    {
                                                        $columnValue2 = 3;
                                            $statusParam = "Trip Cancelled";
														
 $captain = $myName->showName($conn, "SELECT  `truck_owner` FROM `search_result`  WHERE `code` = '$id'"); 
 
														
							//SELECT  `account_number` FROM `online_status` WHERE `status`							
														                                                       
       $sqlnot ="UPDATE `online_status` SET `status` = 1, `created_date` = '$datetime'  WHERE `account_number` = '$captain'";
mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));	                                                     
                                                       
 //truck_owner	
 
 
                                                         $columnValue3 = 1;
                                                    }
                                                   else  if($columnValue == 4)
                                                    {
                                                        $columnValue2 = 4;
 $statusParam = "Trip Accepted";
                                                        $columnValue3 = 4;
                                                       
                                                       // Trip Accepted
                                                       
                             
//$statement = "select * from `trip_otp` where `order_id` = '$id' AND `status` = '0'";
	
$customer_account = $myName->showName($conn, "SELECT  `registeredby` FROM `search_result`  WHERE `code` = '$id'");

  $extract_user = mysqli_query($conn, "select * from `trip_otp` where `order_id` = '$id'  AND `account_number` = '$customer_account'") or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_user);
		 if($count > 0) {
	 	   
}
else{
                                                                                          

$customer_name = $myName->showName($conn, "SELECT  `name` FROM  `user_unit` WHERE  `account_number` = '$customer_account'");
$customer_phone = $myName->showName($conn, "SELECT  `phone` FROM  `user_unit` WHERE  `account_number` = '$customer_account'");
$customer_email = $myName->showName($conn, "SELECT  `email` FROM  `user_unit` WHERE  `account_number` = '$customer_account'");      
   
                                                       
                                                       
                                       
 $truck_id = $myName->showName($conn, "SELECT  `truck_id` FROM `search_result`  WHERE `code` = '$id'"); 
 

                                        
                                        
$truck_plate_number = $myName->showName($conn, "SELECT  `truck_plate_number` FROM `truck`  WHERE `id` = '$truck_id'");
                                        
                                        
                                        
                                        
 $driver_account_number = $myName->showName($conn, "SELECT  `account_number` FROM `truck`  WHERE `id` = '$truck_id'");                                                       
 //$driver_account_number = $myName->showName($conn, "SELECT  `account_number` FROM `truck`  WHERE `id` = '$truck_id'");                                                       
                                                       
        $otp =  rand(0, 9).rand(1, 8).rand(2, 9).rand(0, 8);	                                                         
                                        
  $subject = "Trip Accepted" ; 
         		  
$message = "Hi ".$customer_name.",
".$statusParam." by captain
Trip Start OTP: ".$otp."
Please give captain to start the trip.
Order ID:".$id.".
Thank You.";
 $Sending = new SendingSMS(); 
 $Sending->smsAPI($customer_phone,"Wynk",$message);
                                                       
                                                       //SELECT  `id`, `account_number`, `captain`, `otpnumber`, `status_value` FROM `trip_otp` WHERE 1
                                                       
                                                           
       $sqlnot1 ="INSERT INTO `trip_otp`(`account_number`, `captain`, `otpnumber`, `status_value`, `order_id`, `truck_id`) VALUES
('$customer_account','$driver_account_number','$otp','0','$id','$truck_id')";
mysqli_query($conn, $sqlnot1) or die(mysqli_error($conn));
                                                       
         $subject = "Trip Start OTP";
                                                       
       $sqlnot ="INSERT INTO `notification`(`code`,`title`,`message`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`) VALUES
('$id','$subject','$message','$emailing', '$customer_account', '1', '1','$datetime' )";
mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));	                                                     
                                                       
                     
                                                       
                                                       
 $sendEmail = ' 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Simple Transactional Email</title>
    <style>
@media only screen and (max-width: 620px) {
  table.body h1 {
    font-size: 28px !important;
    margin-bottom: 10px !important;
  }

  table.body p,
table.body ul,
table.body ol,
table.body td,
table.body span,
table.body a {
    font-size: 16px !important;
  }

  table.body .wrapper,
table.body .article {
    padding: 10px !important;
  }

  table.body .content {
    padding: 0 !important;
  }

  table.body .container {
    padding: 0 !important;
    width: 100% !important;
  }

  table.body .main {
    border-left-width: 0 !important;
    border-radius: 0 !important;
    border-right-width: 0 !important;
  }

  table.body .btn table {
    width: 100% !important;
  }

  table.body .btn a {
    width: 100% !important;
  }

  table.body .img-responsive {
    height: auto !important;
    max-width: 100% !important;
    width: auto !important;
  }
}
@media all {
  .ExternalClass {
    width: 100%;
  }

  .ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
    line-height: 100%;
  }

  .apple-link a {
    color: inherit !important;
    font-family: inherit !important;
    font-size: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
    text-decoration: none !important;
  }

  #MessageViewBody a {
    color: inherit;
    text-decoration: none;
    font-size: inherit;
    font-family: inherit;
    font-weight: inherit;
    line-height: inherit;
  }

  .btn-primary table td:hover {
    background-color: #34495e !important;
  }

  .btn-primary a:hover {
    background-color: #34495e !important;
    border-color: #34495e !important;
  }
}
</style>
  </head>
  <body style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
    <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">Ride Starter OTP .</span>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" width="100%" bgcolor="#f6f6f6">
      <tr>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td>
        <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;" width="580" valign="top">
          <div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">

            <!-- START CENTERED WHITE CONTAINER -->
            <table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;" width="100%">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top">
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
                    <tr>
                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Hi '.$customer_name.',</p>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">'.$statusParam.' by captain. Trip Start OTP:</p>
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: border-box; width: 100%;" width="100%">
                          <tbody>
                            <tr>
                              <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;" valign="top">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                                  <tbody>
                                    <tr>
                                      <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; border-radius: 5px; text-align: center; background-color: #3498db;" valign="top" align="center" bgcolor="#3498db"> <a href="" target="_blank" style="border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-decoration: none; text-transform: capitalize; background-color: #3498db; border-color: #3498db; color: #ffffff;">#'.$otp.'</a> </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Please give captain to start the trip. <br>
Order ID:'.$id.'.</p>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Good luck! Thank you.</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

            <!-- END MAIN CONTENT AREA -->
            </table>
            <!-- END CENTERED WHITE CONTAINER -->

            <!-- START FOOTER -->
            <div class="footer" style="clear: both; margin-top: 10px; text-align: center; width: 100%;">
              <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
                <tr>
                  <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;" valign="top" align="center">
                    <span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">'.$inst_name.', '.$inst_address.'</span>
                    
                  </td>
                </tr>
                <tr>
                  <td class="content-block powered-by" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;" valign="top" align="center">
                    Powered by <a href="" style="color: #999999; font-size: 12px; text-align: center; text-decoration: none;">'.$inst_name.' '.$inst_slogan.'</a>.
                  </td>
                </tr>
              </table>
            </div>
            <!-- END FOOTER -->

          </div>
        </td>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">&nbsp;</td>
      </tr>
    </table>
  
';
                                      
                                                       
                                                       $newEmail= $inst_email;
	
	
	 					$headers = "From: " .($newEmail) . "\r\n";
                        $headers .= "Reply-To: ".($newEmail) . "\r\n";
                        $headers .= "Return-Path: ".($newEmail) . "\r\n";;
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        $headers .= "X-Priority: 3\r\n";
                        $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
  $emailSend = mail($customer_email,"Start Trip OTP  for: ".$customer_name,$sendEmail,$headers);    
                                                           
                                                       }
 
                                                                                      
      
                                                       
                                                       
                                                    }
                                                    else{
                                                        
                                                        $columnValue2 = 1;
                                                    }
                                                
                                                   
                                                     
 $query =  "UPDATE  `online_status`  SET   `status` = '$columnValue3', `created_date` = '$datetime', `lati` = '$lati', `longi` = '$longi'   WHERE `account_number` = '$emailing'";
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));	                
       
 
                                                    
$query =  "UPDATE  `transaction_information`  SET `trip_status` = '$columnValue' , `status` = '$columnValue2'  WHERE `code` = '$id'";
                  $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));	
                                                    
                                                    
  $query =  "UPDATE  `search_result`  SET `trip_status` = '$columnValue', `status` = '$columnValue2'   WHERE `code` = '$id'";
                  $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));	      
     
                                             
                 
                                                              
                                    if($extract_distance)                
                                    {
                                        
 
 $driver_name = $myName->showName($conn, "SELECT  `name` FROM  `user_unit` WHERE  `account_number` = '$emailing'");
 $driver_phone = $myName->showName($conn, "SELECT  `phone` FROM  `user_unit` WHERE  `account_number` = '$emailing'");
                                        
                                        
$customer_account = $myName->showName($conn, "SELECT  `registeredby` FROM `search_result`  WHERE `code` = '$id'");

$customer_name = $myName->showName($conn, "SELECT  `name` FROM  `user_unit` WHERE  `account_number` = '$customer_account'");
$customer_phone = $myName->showName($conn, "SELECT  `phone` FROM  `user_unit` WHERE  `account_number` = '$customer_account'");
$customer_email = $myName->showName($conn, "SELECT  `email` FROM  `user_unit` WHERE  `account_number` = '$customer_account'");                                      
                                        
 $truck_id = $myName->showName($conn, "SELECT  `truck_id` FROM `search_result`  WHERE `code` = '$id'"); 
 //$$truck_id = $myName->showName($conn, "SELECT  `truck_id` FROM `search_result`  WHERE `code` = '$id'"); 

                                        
                                        
$truck_plate_number = $myName->showName($conn, "SELECT  `truck_plate_number` FROM `truck`  WHERE `id` = '$truck_id'");
                                        
                                        
                                        
                                        
 $account_number = $myName->showName($conn, "SELECT  `account_number` FROM `truck`  WHERE `id` = '$truck_id'");
 $owner_name = $myName->showName($conn, "SELECT  `name` FROM  `user_unit` WHERE  `account_number` = '$account_number'");
 $owner_phone = $myName->showName($conn, "SELECT  `phone` FROM  `user_unit` WHERE  `account_number` = '$account_number'");
 $owner_email = $myName->showName($conn, "SELECT  `email` FROM  `user_unit` WHERE  `account_number` = '$account_number'");
             
                                        
                                        
                                        
                                        
                                        
  $subject = "Wybk Trip Info" ; 
         		  
$message = "Hi ".$customer_name.",
".$statusParam." by captain
Driver Name: ".$driver_name."
Driver Phone: ".$driver_phone."
Order ID:".$id.".
Car:".$truck_plate_number."
Date/Time:".$datetime."
Thank You.";
 $Sending = new SendingSMS(); 
 $Sending->smsAPI($customer_phone,"Wynk",$message);
                                        
                                        if($columnValue2 == 9)
                                        {
                                            
 $sqlnot ="INSERT INTO `notification`(`code`,`title`,`message`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`, `truck_id`) VALUES
('$id','$subject','$message','$emailing', '$customer_account', '1', '1','$datetime', '$truck_id')";
mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));	      
                                        }
                                        else{
                                            
               $sqlnot ="INSERT INTO `notification`(`code`,`title`,`message`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`, `truck_id`) VALUES
('$id','$subject','$message','$emailing', '$customer_account', '1', '1','$datetime', '$truck_id')";
mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));	                             
                                        }
	
                                          

         
                                          
                                        
  $subject = "Wynk Trip Info!!!" ; 
         		  
$message = "Hi ".$owner_name.",
".$statusParam." by captain
Driver Name: ".$driver_name."
Driver Phone: ".$driver_phone."
Order ID:".$id.".
Car:".$truck_plate_number."
Date/Time:".$datetime."
Thank You.";
 $Sending = new SendingSMS(); 
 $Sending->smsAPI($owner_phone,"Wynk",$message);
$sqlnot ="INSERT INTO `notification`(`code`,`title`,`message`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`) VALUES
('$id','$subject','$message','$emailing', '$account_number', '1', '1','$datetime')";
mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));                                             

                                        
                                        
                                        

                                        
/*SELECT  `id`, `code`, `lati`, `longi`, `status`, `trip_started`, `trip_ended`, `created_date`, `registeredby` FROM `trip_record` WHERE 1*/                                        
if($columnValue2 == 8)
{
    
  $sqlnot ="INSERT INTO `trip_record`(`code`, `lati`, `longi`, `status`, `trip_started`, `trip_ended`, `created_date`, `registeredby` ) VALUES
('$id','$currentLat','$currentLong','1', '$datetime', '', '$datetime','$emailing')";
mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));    
}
 else if($columnValue2 == 9)
{
                                            //stop 
 $sqlnot ="UPDATE `trip_record` SET  `trip_ended` = '$datetime'  WHERE `code` = '$id'";
mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));   
     
     
 $trip_started = $myName->showName($conn, "SELECT  `trip_started` FROM `trip_record` WHERE   `registeredby` = '$emailing' and `code` = '$id'");        
 $trip_ended = $myName->showName($conn, "SELECT  `trip_ended` FROM `trip_record` WHERE   `registeredby` = '$emailing' and `code` = '$id'"); 
     
     
     
 $start_lat = $myName->showName($conn, "SELECT  `lati` FROM `trip_record` WHERE   `registeredby` = '$emailing' and `code` = '$id'");        
 $start_long = $myName->showName($conn, "SELECT  `longi` FROM `trip_record` WHERE   `registeredby` = '$emailing' and `code` = '$id'");   
        
      $road_maintenance_charge = $myName->showName($conn, "SELECT  `road_maintenance_charge` FROM `search_result` WHERE  `code` = '$id'");      
     
      
      $dist2 = GetDrivingDistance($start_lat, $currentLat,$start_long,$currentLong);
	//echo '<span  class="btn btn-danger btn-block"> Bad address. Please re-enter the address </span>';
    $kilo_value2 = $dist2['distance'];
 $min_value2 = $dist2['time'];
 $distance2 = trim(substr($dist2['distance'],0,-2));
 $distance_real2 = trim(substr($dist2['distance'],0,-2));
 
 
 //$minutes_cal2= trim(substr($dist2['value']/60,0,-2)).$lati1."/".$longi2;
 $minutes_cal2= trim(substr($dist2['value']/60,0,-2));
 
    	// $distance_o = round($distance_real, 2).$currentLat."/".$currentLong;
 $distance = round($distance_real2, 2);
         
      
     
     
     
     
        
        $first_date = new DateTime($trip_started);
$second_date = new DateTime($trip_ended);

$difference12 = $first_date->diff($second_date);

$difference12 =  format_interval($difference12);
        
        
        
        
        
        $dateTimeObject1 = date_create($trip_started); 
$dateTimeObject2 = date_create($trip_ended); 
  
$difference = date_diff($dateTimeObject1, $dateTimeObject2); 
        
        $minutes = $difference->days * 24 * 60;
$minutes += $difference->h * 60;
$minutes += $difference->i;
        
      
           $base_fare = $myName->showName($conn, "SELECT  `amount` FROM  `base_fare` WHERE  ( `status` = 1)");
		    $price_per_km = $myName->showName($conn, "SELECT  `amount` FROM  `price_per_km` WHERE  (`status` = 1)");
         
      
		    $truck_capacity_charge = $myName->showName($conn, "SELECT  `amount` FROM  `truck_capacity_charge` WHERE  (`status` = 1)");
	$total_price_pertime = 	 $truck_capacity_charge * $minutes;
      $convinience_fee = $myName->showName($conn, "SELECT `fee` FROM `application` WHERE 1");
     
         $total_price_per_km = $price_per_km * (int)str_replace(',', '', $distance);
 $estimated = $total_price_per_km + ($truck_capacity_charge * $minutes) + $base_fare + $road_maintenance_charge;
 
      $total_amount = number_format($estimated + $convinience_fee);
         $total =  $estimated + $convinience_fee ;
     
                                        //stop 
 $sqlnot ="UPDATE `trip_record` SET  `base_price` = '$base_fare', `distance` = '$total_price_per_km', `time` = '$total_price_pertime', `road_maintenance` = '$road_maintenance_charge', `trip_amount` = '$total',  `end_longi` = '$currentLong', `end_lati` = '$currentLat'  WHERE `code` = '$id'";
mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));   
     
     
     
     
       $query =  "UPDATE  `search_result`  SET `amount` = '$total'   WHERE `code` = '$id'	ORDER BY `id` DESC";
  
  $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));		
   
   
   
   $dest_long = $myName->showName($conn, "SELECT  `longi2` FROM  `search_result` WHERE  (`code` = '$id')"); 
  $dest_lat = $myName->showName($conn, "SELECT  `lati2` FROM  `search_result` WHERE  (`code` = '$id')");  
  
  
  
  $pick_long = $myName->showName($conn, "SELECT  `longi1` FROM  `search_result` WHERE  (`code` = '$id')"); 
  $pick_lat = $myName->showName($conn, "SELECT  `lati1` FROM  `search_result` WHERE  (`code` = '$id')");  
 }
                 //SELECT `longi1`, `lati1`, `longi2`, `lati2` FROM `search_result` WHERE 1                     
                                        
        
   $dest_long = $myName->showName($conn, "SELECT  `longi2` FROM  `search_result` WHERE  (`code` = '$id')"); 
  $dest_lat = $myName->showName($conn, "SELECT  `lati2` FROM  `search_result` WHERE  (`code` = '$id')");  
  
  
  
  $pick_long = $myName->showName($conn, "SELECT  `longi1` FROM  `search_result` WHERE  (`code` = '$id')"); 
  $pick_lat = $myName->showName($conn, "SELECT  `lati1` FROM  `search_result` WHERE  (`code` = '$id')");                                
     
     echo json_encode(array("statusCode"=>200, "errorMessage"=>"-".$statusParam." Successfully. Thank You.", "dest_long"=>$dest_long, "dest_lat"=>$dest_lat, "pick_long"=>$pick_long, "pick_lat"=>$pick_lat));
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                    }
                                                    else
                                                    {
                                                        
 
                                                        
                                                        
 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Oooop. Something went wrong. Please try agai later."));
                                                    }
                                                    
                                                    
                                                    
                                                    
                                                    
                                                }
											
						   
function format_interval(DateInterval $interval) {
    $result = "";
    if ($interval->y) { $result .= $interval->format("%y years "); }
    if ($interval->m) { $result .= $interval->format("%m months "); }
    if ($interval->d) { $result .= $interval->format("%d days "); }
    if ($interval->h) { $result .= $interval->format("%h hours "); }
    if ($interval->i) { $result .= $interval->format("%i minutes "); }
    if ($interval->s) { $result .= $interval->format("%s seconds "); }

    return $result;
}


function returnLocation($lat, $long) {
    $location = "";
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($long).'&key=AIzaSyCaSn2IGtrwVyG05swNh2HLFch3YI3_QvM';
    $json = @file_get_contents($url);
    $data = json_decode($json);
    $status = $data->status;
    
    //if request status is successful
    if($status == "OK"){
        //get address from json data
        $location = $data->results[0]->formatted_address;
    }else{
       $location =  '';
    } 
    return $location;
}



function GetDrivingDistance($lat1, $lat2, $long1, $long2)
{
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=en-EN&departure_time=now&key=AIzaSyCaSn2IGtrwVyG05swNh2HLFch3YI3_QvM";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
	  $dist_value = $response_a['rows'][0]['elements'][0]['distance']['value'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
	$value = $response_a['rows'][0]['elements'][0]['duration']['value'];

    return array('distance' => $dist,'distanceval' => $dist_value, 'time' => $time, 'value' => $value);
} 
					  	
				 
			 
					 
		   
	 
?>