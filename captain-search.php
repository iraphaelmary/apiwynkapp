<?php
	header('Access-Control-Allow-Origin: *');
include ("config/DB_config.php"); 
/* ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1); */

include("class_file.php");
$road_maintenance_charge = 0;
 
 include("SendingSMS.php");
  $myName = new Name();



$coordinates1 = true;
$coordinates2= true;
$value_value = "";
$json =  json_decode(file_get_contents('php://input'), true);
require_once('fcm-send-function.php');
require_once('view-application-details.php');
 $Sending = new SendingSMS(); 
 


$fcm = new FCM(); 
$fcmSend = new fcm();

 

 


$start_long = $json['loading_long']; 
 $start_lat = $json['loading_lat']; 
  $stop_long = $json['destination_long']; 
  $stop_lat = $json['destination_lat']; 
$user = $json['wynkid'];
$username = $json['wynkid'];
     $emailing = $json['wynkid']; 
     $mode = $json['payment_mode']; 
     $destination = $json['destination']; 
     $pickup = $json['pickup']; 
     $stops =  $json['stops']; 
     $share_with =  $json['share_with']; 
     $stops2 = json_encode($json['stops'], true); 
     
    /* 
    
$start_long = "3.8309133"; 
 $start_lat = "7.3420367"; 
  $stop_long = "3.8605551"; 
  $stop_lat = "7.3667024"; 
$user = "WYNK61362372";
$username = "WYNK61362372";
     $emailing = "WYNK61362372";
     $mode = "cash"; 
     $destination ="Mobil Ring Road"; 
     $pickup ="Mercy Cres"; 
     $stops =  []; 
     $share_with =  1; 
     $stops2 =[]; 
      */
    
     
     
  
     $payment_status = 0;
     
     $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
     //, `remita_username`, `remita_password`, `, `remita_url` 
       $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
       


  //$accountNumber = $myName->showName($conn, "SELECT `accountNumber` FROM //`wallet_info` WHERE `registeredby` = '$user'");	
  
  $accountNumber = $myName->showName($conn, "SELECT `accountNumber` FROM `wallet_info` WHERE `registeredby` = '$emailing'   AND `primary_wallet` = 1 AND `accountNumber` != ''");	 


$wallet_number = $myName->showName($conn, "SELECT `accountNumber` FROM `wallet_info` WHERE `registeredby` = '$emailing'   AND `primary_wallet` = 1 AND `accountNumber` != ''");	  
  
  
  
  
      // $token = $myName->showName($conn, "SELECT `token` FROM `remita_setup` WHERE 1");		    

   $remita_scheme = $myName->showName($conn, "SELECT `remita_scheme` FROM `application` WHERE 1");	  
     
     
 if(!empty($emailing))
 { 
     
       $radius = $myName->showName($conn, "SELECT  `radius` FROM `radius` WHERE `status` = 1");
     
  $today=date("Y-m-d");
 
     
   
$codec =  "WYNK-RIDE-".date("Ymd").rand(34,2536);
 
     
	 
 
	 
	 
     $id2="";
     
 //$startcity =returnCity($start_lat, $start_long);
 $start =$pickup;
 $stop = $destination;
 
    $loading_state1 = $startcity['state'];
    $loading_county1 = $startcity['country'];  
     $loading_region = $startcity['region'];  
 
  $coordinates1 =  $start;
 $coordinates2 =  $stop;
     
 $trip_status_charge = 0;
 
     
     
 if(empty($start_lat) or empty($stop_lat))
{
  
  echo json_encode(array("statusCode"=>201, "errorMessage"=>"Bad Coordinate. Please re-enter the coordinates."));  
	
}
else
{    
     
 
 $dist = GetDrivingDistance($start_lat, $stop_lat, $start_long, $stop_long,$googleapi);
	//echo '<span  class="btn btn-danger btn-block"> Bad address. Please re-enter the address </span>';
    $kilo_value = $dist['distance'];
 $min_value = $dist['time'];
 $distance = trim(substr($dist['distance'],0,-2));
 $distance_real = trim(substr($dist['distance'],0,-2));
 
 
 $minutes_cal = trim(substr($dist['value']/60,0,-2));
 
 
 
    
      $code =   "WYNK-RIDE-".date("Gis").rand(87, 373);  
      
      
      
	 
  
      
      
 
//$user = "Annonymous";
    
    $lat1 = $start_lat;
	$long1 = $start_long;
	
	$lat2 = $stop_lat;
	$long2 = $stop_long;
    
 
	 
 $query =  "SELECT `id`, `account_number`, `truck_plate_number`, `location`, `lati`, `longi`, `status`, `created_date`, distance
  FROM (
 SELECT 
 z.id,
 z.account_number,
 z.truck_plate_number,
 z.location,
      z.lati, 
		z.longi,
        z.status,
        z.created_date,
	    p.radius,
        p.distance_unit
                 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(p.latpoint))
                 * COS(RADIANS(z.lati))
                 * COS(RADIANS(p.longpoint - z.longi))
                
                + SIN(RADIANS(p.latpoint))
                
                 * SIN(RADIANS(z.lati))))) AS distance
  FROM online_status AS z
  JOIN (
        SELECT  ".$lat1."  AS latpoint,  ".$long1." AS longpoint,
                 ".$radius .".0 AS radius,      111.045 AS distance_unit
    ) AS p ON 1=1
  WHERE  ((z.status = '1' or z.status = '9') AND (z.created_date LIKE '%".$today."%') AND z.usertype = 2 ) AND (z.account_number != '$username')AND z.lati
     BETWEEN p.latpoint  - (p.radius / p.distance_unit)
         AND p.latpoint  + (p.radius / p.distance_unit)
    AND z.longi
     BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
         AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint))))
 ) AS d
 WHERE distance <= radius
 ORDER BY distance 
 LIMIT 1";
	 
 
	
  //echo $query."<p>";
 

$value1 = "";
	
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {
      				  	  
 
    //SELECT  `id`, `account_number`, `truck_plate_number`, `location`, `lati`, `longi`, `status`, `created_date` FROM `online_status` WHERE 1
          					$id =$row_distance[0];
                            $_SESSION['truck_id_2'] =$row_distance[0];
						   	$account_number =$row_distance[1];
						   	$listing_code =$row_distance[1];
					  		$truck_plate_number =$row_distance[2];
					  		$location =$row_distance[3];
						   	$lati =$row_distance[4];
					  		$longi =$row_distance[5];
					  		$status =$row_distance[6];
						   	$created_date =$row_distance[7];
						    $distance_unit =$row_distance[8];
						   //	$distance_unit =$row_distance[9];
					  		 
		 
		 
		 
		
		 
          
             $truck_type = $myName->showName($conn, "SELECT `truck_type` FROM `truck` WHERE `truck_plate_number` = '$truck_plate_number' AND `account_number` = '$account_number'");
         $truck_id = $myName->showName($conn, "SELECT `id` FROM `truck` WHERE `truck_plate_number` = '$truck_plate_number'  AND `account_number` = '$account_number'");
         $truck_brand_value_2 = $myName->showName($conn, "SELECT `truck_brand` FROM `truck` WHERE `truck_plate_number` = '$truck_plate_number'  AND `account_number` = '$account_number' ");
         $truck_color = $myName->showName($conn, "SELECT `color` FROM `truck` WHERE `truck_plate_number` = '$truck_plate_number'  AND `account_number` = '$account_number'");
         $total_capacity = $myName->showName($conn, "SELECT `total_capacity` FROM `truck` WHERE `truck_plate_number` = '$truck_plate_number'  AND `account_number` = '$account_number'");
        
       /*  $truck_type = $myName->showName($conn, "SELECT `truck_type` FROM `truck` WHERE `truck_plate_number` = '$truck_plate_number'");
         $truck_id = $myName->showName($conn, "SELECT `id` FROM `truck` WHERE `truck_plate_number` = '$truck_plate_number'");
         $truck_brand = $myName->showName($conn, "SELECT `truck_brand` FROM `truck` WHERE `truck_plate_number` = '$truck_plate_number'");*/
        // $truck_brand_value_2 = $myName->showName($conn, "SELECT `name` FROM `truck_type` WHERE `id` = '$truck_brand'"); 
         
         
         $truck_model_value = $myName->showName($conn, "SELECT `truck_type` FROM `truck` WHERE `truck_plate_number` = '$truck_plate_number'");
         //$truck_model_value = $myName->showName($conn, "SELECT `name` FROM `model` WHERE `id` = '$model'");
         
         
         //$truck_brand = $myName->showName($conn, "SELECT `truck_brand` FROM `truck` WHERE `truck_plate_number` = '$truck_plate_number'");
         
     
                  
   $km =  trim(substr($dist['distance'],0,-2));
		  /*  $base_fare = $myName->showName($conn, "SELECT  `amount` FROM  `base_fare` WHERE  (`truck_type` = '$truck_type'   AND `status` = 1)");
		    $price_per_km = $myName->showName($conn, "SELECT  `amount` FROM  `price_per_km` WHERE  (`truck_type` = '$truck_type' AND `status` = 1)");
         $truck_capacity_charge = $myName->showName($conn, "SELECT  `amount` FROM  `truck_capacity_charge` WHERE  (`truck_type` = '$truck_type'   AND `status` = 1)"); */
         
         
         
         $base_fare = $myName->showName($conn, "SELECT  `amount` FROM  `base_fare` WHERE  ( `status` = 1)");
		    $price_per_km = $myName->showName($conn, "SELECT  `amount` FROM  `price_per_km` WHERE  ( `status` = 1)");
         $truck_capacity_charge = $myName->showName($conn, "SELECT  `amount` FROM  `truck_capacity_charge` WHERE  (`status` = 1)");
		 
       
         
         //$total_capacity = $myName->showName($conn, "SELECT  `capacity` FROM `truck_capacity` WHERE `id` = '$total_capacity'"); 
         
          $truck_type = $myName->showName($conn, "SELECT  `name` FROM  `truck_type` WHERE  `id` = '$truck_type'");
          $owner = $myName->showName($conn, "SELECT  `name` FROM  `user_unit` WHERE  `account_number` = '$account_number'"); 
          $registeredby = $myName->showName($conn, "SELECT  `account_number` FROM  `user_unit` WHERE  `account_number` = '$account_number'"); 
         $driver_fname = $myName->showName($conn, "SELECT  `firstname` FROM  `user_unit` WHERE  `account_number` = '$account_number'");
         $driver_phone = $myName->showName($conn, "SELECT  `phone` FROM  `user_unit` WHERE  `account_number` = '$account_number'");
          $owner_passport = $myName->showName($conn, "SELECT  `file` FROM  `user_unit` WHERE  `account_number` = '$account_number'");
         
          $truck_color = $myName->showName($conn, "SELECT `color` FROM `truck` WHERE `truck_plate_number` = '$truck_plate_number'");
     
    $distance_o = round($distance_real, 2);
         
     
           $trip_count = $myName->showName($conn, "SELECT  COUNT(`code`) FROM  `search_result` WHERE  `truck_id` = '$truck_id' AND `status` = '5'");
 
             
            
                 $dist2 = GetDrivingDistance($lat1, $lati,$long1,$longi,$googleapi);
	//echo '<span  class="btn btn-danger btn-block"> Bad address. Please re-enter the address </span>';
    $kilo_value2 = $dist['distance'];
 $min_value2 = $dist['time'];
 $distance2 = trim(substr($dist['distance'],0,-2));
 $distance_real2 = trim(substr($dist['distance'],0,-2));
 
 
 $minutes_cal2= trim(substr($dist['value']/60,0,-2));
        
    	 $distance_o = round($distance_real, 2);
         
         
         
         
          $cityRetuning1 = returnCity($lat1, $long1,$googleapi);
          $cityRetuning2 =  returnCity($lati, $longi,$googleapi);
	
    $loading_state1 = $cityRetuning1['state'];
    $loading_county1 = $cityRetuning1['country'];  
     $loading_region = $cityRetuning1['region'];     
         
         
    $loading_state2 = $cityRetuning2['state'];
    $loading_county2 = $cityRetuning2['country'];
    $detination_region2 = $cityRetuning2['region'];
      //  $extract_user = mysqli_query($conn, "SELECT * FROM `road_maintenance_charge` WHERE  `state` = '$state' AND `country` = '$country'") or die(mysqli_error($conn));
         
         if( $loading_region ==  $detination_region2 and $loading_county2 == $loading_county1)
         {
             
 $road_maintenance_charge = $myName->showName($conn, "SELECT `amount` FROM  `road_maintenance_charge` WHERE  `state` LIKE '%".$detination_region2."%' AND `country` = '$loading_county2'");
			 
			 
          
	 
			 
         }
         else{
             
           $road_maintenance_charge1 = $myName->showName($conn, "SELECT `amount` FROM  `road_maintenance_charge` WHERE  `state` LIKE '%".$detination_region."%' AND `country` = '$loading_county1'");  
             
                   $road_maintenance_charge2 = $myName->showName($conn, "SELECT `amount` FROM  `road_maintenance_charge` WHERE  `state` LIKE '%".$detination_region2."%' AND `country` = '$loading_county2'");  
             
             $road_maintenance_charge = $road_maintenance_charge1 + $road_maintenance_charge2;
			 
			 
             
         }
         
         
          // $total_price_per_km = $price_per_km *  (int)str_replace(',', '', $km);
           $total_price_per_km = floatval($price_per_km) * floatval($distance2) ;
         
         $estimated = $total_price_per_km + ($truck_capacity_charge*$minutes_cal2) + $base_fare + $road_maintenance_charge;
 
    $twnetypercent = 0;
		 $currentBalance = 0;
		  if($mode == "wallet")
		 {
			 $currentBalance = getCaptainDetail($remita_url, $remita_username,$remita_password,$wallet_number,$remita_scheme);
			  
			  $twnetypercent = (($estimated/100) * 20) + $estimated;
				  
				  if($currentBalance < $twnetypercent)
				  {
					  $payment_status = 0;
					  
				  }
			  else
			  {
				  $payment_status = 1;
				  
			  }
			 
		 }
		 else if($mode == "cash")
		 {
			 
			 $payment_status = 1;
		 }
		 else if($mode == "walletcash"){
			 
			  $payment_status = 1;
		 }
		 
		 
		 
		 
		 
		 
		 
		 
		 
		if($payment_status == 0) 
		{
			
	  echo json_encode(array("statusCode"=>202, "errorMessage"=>"Insufficient wallet balance.", "ride_amount" => $twnetypercent, "wallet_balance"=>$currentBalance));  	
			
			
			
						
 $device_token=$myName->showName($conn, "SELECT `device_token` FROM `device_token` WHERE `account_number` = '$username'"); 	
 	
			$message = "Insufficient wallet balance. Ride Amount: ".$twnetypercent." Wallet Balance: ".$currentBalance;
			
			
		 
			if(!empty($device_token))
			{
				
				$fcmSend->sendFCM($device_token, "Insufficient wallet balance",$message, "2", $message);
			}			
		
			
				
		}else
		{
		 
	//	echo "start:  ".$start."<p>"; 
 if(!empty($start))
{
 
 $stoping = $stops2;

 
      $sql = mysqli_query($conn,"INSERT INTO `search_result`(`code`, `loading`, `destination`, `pick_up_date`, `product`, `truck_type`, `truck_capacity`, `status`, `created_date`, `registeredby`, `longi1`, `lati1`, `longi2`, `lati2`, `distance`, `truck_id`, `amount`, `truck_owner`, `minutes`,`loadingcity`, `destinationcity`, `loadingcountry`,`destinationcountry`, `loadingregion`, `destinationregion`, `road_maintenance_charge`, `stop`,`ride_share`) VALUES('$code','$start','$stop', '$datetime','-','$truck_brand','-','2','$datetime','$user','$long1','$lat1','$long2','$lat2','$distance2','$truck_id', '$estimated', '$account_number', '$min_value2', '$loading_state1', '$loading_state2', '$loading_county1', '$loading_county2', '$loading_region', '$detination_region2', '$road_maintenance_charge', '$stoping', '$share_with')") or die("ERROR OCCURED: ".mysqli_error($conn)); 

     //$query =  "UPDATE  `search_result`  SET `status` = '2'   WHERE `code` = '$code'";
       // $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));	
       
 	 $data = json_decode($stops2, true);


foreach ($data as $item) {
  	$stop_lati = $item['stops_lat'];
		$stop_longi = $item['stops_lng'];
		$stop_desc = $item['stops_desc'];
		
$sql = 	mysqli_query($conn,"INSERT INTO `ride_stops`(`stop_lat`, `stop_long`,`stop_desc`, `status`, `created_date`, `registeredby`, `ride_code` ) VALUES('$stop_lati','$stop_longi','$stop_desc','1','$datetime', '$emailing', '$code') ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	

}    
 
 
	 
	 
  
    
    
         
    
         
          $truck_owner = $myName->showName($conn, "SELECT  `account_number` FROM `truck` WHERE `id` =  '$truck_id'");  
          $truck_plate_number = $myName->showName($conn, "SELECT  `truck_plate_number` FROM `truck` WHERE `id` =  '$truck_id'");  
          $truck_owner_name = $myName->showName($conn, "SELECT  `name` FROM `user_unit` WHERE `account_number` =  '$truck_owner'");  
          $truck_owner_phone = $myName->showName($conn, "SELECT  `phone` FROM `user_unit` WHERE `account_number` =  '$truck_owner'");  
          $truck_owner_email = $myName->showName($conn, "SELECT  `email` FROM `user_unit` WHERE `account_number` =  '$truck_owner'");  

          
    
    
    
         $customer_name = $myName->showName($conn, "SELECT  `name` FROM `user_unit` WHERE `account_number` =  '$emailing'");  
          $customer_email = $myName->showName($conn, "SELECT  `email` FROM `user_unit` WHERE `account_number` =  '$emailing'");  
          $customer_phone = $myName->showName($conn, "SELECT  `phone` FROM `user_unit` WHERE `account_number` =  '$emailing'");  
         
     $add_message = "";    
	 
	 //if(isset($json['share_with']) and $share_with >= 1)
	 if($share_with >= 1)
	 {
		 
		 
 $sql12 = mysqli_query($conn,"INSERT INTO `ride_share`(`ride_code`, `number_of_patron`, `status`, `created_date`, `registeredby`) VALUES('$code','$share_with','1', '$datetime','$emailing')") or die("ERROR OCCURED: ".mysqli_error($conn)); 

      
     // $extract_distance = mysqli_query($conn, $sql12) or die(mysqli_error($conn));	
$add_message = "Please note that this ride
may be shared by ".$share_with." other patron(s)";    
		 
	 }
	 
          
         
         		  
$message = "Hi ".$truck_owner_name.",
Ride Booking Request!
Order ID:".$code.".
Car:".$truck_plate_number."
Pickupdate:".$datetime."
Pick Up:".$start."
Destination:".$stop."
Patron Name:".$customer_name."
Patron Phone:".$customer_phone."
Patron Email:".$customer_email."
Estimated Fare:".$estimated."
".$add_message."
View detail to accept/reject
Thank You.";
 $Sending = new SendingSMS(); 
  							 
	//	echo $message;
		
		// 	$Sending->smsAPI($truck_owner_phone,"WYNK",$message);
         
         
      //    $sqlnot ="INSERT INTO `notification`(`code`,`title`,`message`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`, `truck_id`, `trip`) VALUES
//('$code','New Booking Alert','$message','$user', '$truck_owner', '1', '1','$datetime', '$truck_id', '1')";

    $sqlnot ="INSERT INTO `notification`(`code`,`title`,`message`, `registeredby`, `sent_to`, `status`, `read_status`, `created_at`, `truck_id`, `trip`,`ride_share`) VALUES
('$code','New Booking Alert','$message','$user', '$truck_owner', '1', '1','$datetime', '$truck_id', '1', '$share_with')";


  $extract_distance = mysqli_query($conn, $sqlnot) or die(mysqli_error($conn));    
				
		 	
	
	 
	 
 						
		 			
 $device_token=$myName->showName($conn, "SELECT `device_token` FROM `device_token` WHERE `account_number` = '$truck_owner'"); 	
 	
		 
			
			
		 
			if(!empty($device_token))
			{
				
				$fcmSend->sendFCM($device_token, "Ride Booking Request",$message, "1", $message);
			}		
		
            
         
         
	$sendEmail =  '<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<table width="538">
  <tr>
    <th colspan="2">Ride Booking Request! </th>
  </tr> 
  <tr>
    <th colspan="2">Hi '.$truck_owner_name.' </th>
  </tr>
  <tr>
    <td width="223" height="18">Order ID</td>
    <td width="303">'.$code.'</td>
  </tr>
  <tr>
    <td>Amount</td>
    <td>'.number_format($estimated).'</td>
  </tr>
  <tr>

    <td>Car Detail Number</td>
    <td>'.$truck_plate_number.'</td>
  </tr>
  <tr> <td>PickUp</td>
    <td>'.$start.' </td>
  </tr>
  <tr>
    <td>Destination</td>
    <td>'.$stop.'; </td>
  </tr>
  <tr>
    <td>Patron Name </td>
    <td> '.$customer_name.'</td>
  </tr><tr>
    <td>Patron Phone </td>
    <td> '.$customer_phone.'</td>
  </tr>
  <tr>
    <td>Patron Email </td>
    <td> '.$customer_email.'</td>
  </tr>
  <tr>
    <td>Pick Up Date </td>
    <td> '.$datetime.'</td>
  </tr> 
  <tr>
    <td colspan = "2">'.$add_message.' </td>
    
  </tr> 
   
</table>
';
         
         
	$newEmail= "wynkrides@wynk.ng";
	
	
	 					$headers = "From: " .($newEmail) . "\r\n";
                        $headers .= "Reply-To: ".($newEmail) . "\r\n";
                        $headers .= "Return-Path: ".($newEmail) . "\r\n";;
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        $headers .= "X-Priority: 3\r\n";
                        $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
 $emailSend = mail($truck_owner_email,"Ride Order Request for: ".$truck_plate_number,$sendEmail,$headers);
         
    }      
             //echo json_encode(array("statusCode"=>200, "errorMessage"=>"Your booking has been submitted, please hold on a minute for the Captain  acceptance."));
         
    
    
    
    
    
$status = $myName->showName($conn, "SELECT  `status` FROM  `search_result` WHERE  `code` = '$code' OR `code` = '$codec'");
    
    
    
        
         
    //     SELECT  `id`, `captain`, `patron`, `review`, `ratings_score`, `created_date`, `status`, `rideid` FROM `ratings` WHERE 1
         		 
  $avg = $myName->showName($conn, "SELECT AVG(ratings_score) FROM `ratings` WHERE `captain` = '$listing_code'"); 
 $counter = $myName->showName($conn, "SELECT count(ratings_score) FROM `ratings` WHERE `captain` = '$listing_code'"); 
 
		 
	 
		 
		 
		 
		 if($avg  == "")
		 {
			  $avg = 0;
		 }
		 
 
		 
	 
         
         
$star = "";

 $query12 =  "SELECT `id`, `captain`, `patron`, `review`, `ratings_score`, `created_date`, `status` FROM `ratings` WHERE `status` = 1 AND `captain` = '$listing_code' ORDER  BY `id` DESC";	
 $extract_distance12 = mysqli_query($conn, $query12) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance12);
    if ($count > 0)
		  {
 	 while ($row_distance12=mysqli_fetch_row($extract_distance12))
    {
  						  	$id =$row_distance12[0];
						   	$captain =$row_distance12[1];
					  		$seeker =$row_distance12[2];
					  		$review =$row_distance12[3];
						   	$ratings_score =$row_distance12[4];
						   	$created_date =$row_distance12[5];
					  		 
 
		 
 
		 
		 for($i = 1; $i <= $ratings_score;$i++)
		 {
			 
			 $star .= ' <i class="bx bxs-star"></i>';
		 }
		 
	  
	 
	 
}
 
						  
				 	
				 
			 
					}

         
          /*
         $new_star = 5 - $ratings_score;
          $star_new = "";
          

		 for($i = 1; $i <= $new_star;$i++)
		 {
			 
			 $star_new .= '<i class="bx bxs-star icon-color"></i>';
		 }
		 
       
         
         */
         
         
      	 
           $t_id =  $myName->showName($conn, "SELECT `id` FROM `transaction_information` WHERE `code` ='$code'"); 
         
         if(empty($t_id) or $t_id == "")
         {
              $sql = 	mysqli_query($conn,"INSERT INTO `transaction_information`(`code`,   `truck_owner`,  `amount`, `commissiononfee`,  `registeredby`, `created_date`, `message`, `status`, `customer` ,  `owners_share`, `means`) VALUES('$code','$truck_owner','$estimated','$estimated','$emailing', '$datetime','','0', '$emailing', '0','$mode') ")or die("ERROR OCCURED: ".mysqli_error($conn)); 	
             
         }
			
			   
			
			
			
		
			
			
         
         
         
         
         $value_value = "Captain Found";
         
         
         //SELECT `lati`, `longi` FROM `online_status` WHERE `account_number`
         
         $lati = $myName->showName($conn, "SELECT  `lati` FROM  `online_status` WHERE  `account_number` = '$truck_owner'");
         
         
          $longi = $myName->showName($conn, "SELECT  `longi` FROM  `online_status` WHERE  `account_number` = '$truck_owner'");
    
     echo json_encode(array("statusCode"=>200, "message"=>$value_value, "code"=>$code, "min"=>$min_value2, "distance"=>$distance2, "brand"=>$truck_brand_value_2, "model"=>$truck_model_value, "estimated"=>number_format($estimated),"captain_fname"=>$driver_fname ,"color"=>$truck_color,"status"=>$status,"phone"=>$driver_phone,"car_plate_number"=>$truck_plate_number,"captain_wynkid"=>$truck_owner,"capacity"=>$total_capacity,"patron_wynkid"=>$emailing,"lat"=>$lati,"long"=>$longi)); 
     
     
    } 
    // echo json_encode(array("statusCode"=>201, "errorMessage"=>"Invalid Input Paramater. Please check and try again."));  
	 
}
 
}
else
{ 
    echo json_encode(array("statusCode"=>201, "errorMessage"=>"Wynk: Sorry we are not able to find any captain yet."));    
       
        
   
}

 
}
 
 }
else
{
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Invalid Input Paramater. Please check and try again."));  
    
    
}






	/*
		   
function get_coordinates($address)
{
    $address = urlencode($address);
    $url = "https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=Poland&key=AIzaSyCckE5OPITrw2kfYM6PWO6uuovAlqQqvTE";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response);


    $status = $response_a->status;

    if ( $status == 'ZERO_RESULTS' )
    {
        return FALSE;
    }
    else
    {
 $return = array('lat' => $response_a->results[0]->geometry->location->lat, 'long' => $long = $response_a->results[0]->geometry->location->lng);
        return $return;
    }
}*/

 
function GetDrivingDistance($lat1, $lat2, $long1, $long2,$googleapi)
{
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=en-EN&departure_time=now&sensor=false&key=".$googleapi;
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


function returnCity($lat, $long,$googleapi)
{
$url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&key=".$googleapi;	
    $json = url_get_contents($url);
    $data = json_decode($json);
    $status = $data->status;
    if($status=="OK") {
     
    
                  
        for ($j=0;$j<count($data->results[0]->address_components);$j++) {
            $cn=array($data->results[0]->address_components[$j]->types[0]);
            if(in_array("locality", $cn)) {
                $city= $data->results[0]->address_components[$j]->long_name;
            }
        } 
        
        for ($j=0;$j<count($data->results[0]->address_components);$j++) {
            $cn=array($data->results[0]->address_components[$j]->types[0]);
            if(in_array("country", $cn)) {
                $country= $data->results[0]->address_components[$j]->short_name;
            }
        }
             for ($j=0;$j<count($data->results[0]->address_components);$j++) {
            $cn=array($data->results[0]->address_components[$j]->types[0]);
            if(in_array("administrative_area_level_1", $cn)) {
                $region= $data->results[0]->address_components[$j]->long_name;
            }
        }
            
       
     } else{
      // echo 'Location Not Found';
     }
     //Print city 
    // return $city; 
     return array('state' => $city,'country' => $country,'region' =>  $region);
}

function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
} 

function getAddress($lat, $long,$googleapi)
{
    //send request and receive json data by latitude and longitude
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($long).'&key='.$googleapi;
	
	 

//$json = url_get_contents($url, false, stream_context_create($arrContextOptions));
	
$json =url_get_contents ($url);
	
	//echo $json." migty";
	
    //$json = url_get_contents($url);
    $data = json_decode($json);
    $status = $data->status;
	
  
     
    //if request status is successful
    if($status == "OK"){
        //get address from json data
        $location = $data->results[0]->formatted_address;
    }else{
        $location =  'Unnamed Address';
    }
 
    return $location;
}
 



 
function getCaptainDetail($remita_url, $remita_username,$remita_password,$accountNumber,$remita_scheme)

{
	
	  // $token = $myName->showName($conn, "SELECT `token` FROM `remita_setup` WHERE 1");		    

  // $remita_scheme = $myName->showName($conn, "SELECT `remita_scheme` FROM `application` WHERE 1");	
$url = $remita_url."/authenticate";

        
       
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "accept: application/json",
   "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = <<<DATA
{
  "password": "$remita_password",
  "rememberMe": true,
  "username": "$remita_username",
  "scheme": "$remita_scheme",
  "deviceId": "64784844-hhhd748849-g7378382"

}
DATA;
        
     
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
 
 //echo  $resp;
$err = curl_error($curl);
curl_close($curl);
if($err){
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$err."."));  
}
    else
    {
        
        
        $resp = json_decode($resp, true);
        
       // echo $resp;
        $message = $resp['message'];
     
        if($message == "Login success")
        { 
			$token = $resp['token'];
             $pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
  
	
		 
curl_close($ch);

			
			
			
        
    }
		
		
		
		
		
		
			
	//echo $accountNumber."<p>";	 

		$url = $remita_url."/get-account-details/".$accountNumber; 
		 
// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Authorization: Bearer '.$token;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);


//echo $result;

if (curl_errno($ch)) {
  echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".curl_error($ch)."."));  
}else{
	
$resp1 = json_decode($result, true);	
	
	 //var_dump($resp1);
        $status = false;
    //  echo $resp1['code'].".... Coded";
        if(isset($resp1['code']) == "success")
        {
     
/*    $status = $resp1['data']['status'];     
        $id = $resp1['data']['id'];
 $accountNumber = $resp1['data']['accountNumber'];
 $currentBalance = $resp1['data']['currentBalance'];
 $dateOpened = $resp1['data']['dateOpened'];
 $schemeId = $resp1['data']['schemeId'];
 $schemeName = $resp1['data']['schemeName'];
 $walletAccountTypeId = $resp1['data']['walletAccountTypeId'];
 $accountOwnerId = $resp1['data']['accountOwnerId'];
 $accountOwnerName = $resp1['data']['accountOwnerName'];
 $accountOwnerPhoneNumber = $resp1['data']['accountOwnerPhoneNumber'];
 $accountName = $resp1['data']['accountName'];*/
 $actualBalance = $resp1['data']['actualBalance'];
/* $trackingRef = $resp1['data']['trackingRef'];
 $walletLimit = $resp1['data']['walletLimit'];
 $nubanAccountNo = $resp1['data']['nubanAccountNo'];
 $accountFullName = $resp1['data']['accountFullName'];
 $totalCustomerBalances = $resp1['data']['totalCustomerBalances']; 
			*/
			
			
			//echo  $accountOwnerName." / ".$currentBalance." / ".$accountName."<p>";
  
 
			
			
			return($actualBalance);
			
		}
	
	
}
		 
		 
		
		
		
		
    }
	
}

	   
?>
 

