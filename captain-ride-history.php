 
<?php
header('Access-Control-Allow-Origin: *');
 include ("config/DB_config.php"); 

include("class_file.php");
  $value_value = "";
  $code = "";
  $truck_id = "";
  $amount = "";
  $total = "";
 include("SendingSMS.php");
  $myName = new Name();

$json =  json_decode(file_get_contents('php://input'), true);

 
$otp = 0;
 


$username = $json['captain_wynkid'];


 
    if(!empty($username))
    {
     
        
   $emailing =      $json['captain_wynkid'];;
   
$query =  "SELECT  `id`, `code`, `loading`, `destination`, `pick_up_date`, `product`, `truck_type`, `truck_capacity`, `status`, `created_date`, `registeredby`,  `amount`, `truck_id`, `distance` FROM `search_result` WHERE  `truck_owner` = '$emailing' AND `status` = '1' ORDER BY `id` DESC";
 
  $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
		
		 $json2 = '[';
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {
  						  	$id =$row_distance[0];
  						  	$id123 =$row_distance[0];
						   	$code =$row_distance[1];
					  		$loading =$row_distance[2];
					  		$destination =$row_distance[3];
						   	$pick_up_date =$row_distance[4];
					  		$product =$row_distance[5];
					  		$truck_type =$row_distance[6];
						   	$truck_capacity =$row_distance[7];
						   	$status =$row_distance[8];
						   	$created_date =$row_distance[9];
						   	$registeredby =$row_distance[10];
						   	$amount =$row_distance[11];
						   	$truck_id =$row_distance[12];
						   	$distance =$row_distance[13];
         
 
         
         
           $truck_plate_number = $myName->showName($conn, "SELECT  `truck_plate_number` FROM `truck` WHERE `id` = '$truck_id'"); 
           $front_view_1 = $myName->showName($conn, "SELECT  `front_view_1` FROM `truck` WHERE `id` = '$truck_id'"); 
           $truck_type = $myName->showName($conn, "SELECT   `truck_type` FROM `truck` WHERE `id` = '$truck_id'"); 
           $total_capacity = $myName->showName($conn, "SELECT  `total_capacity` FROM `truck` WHERE `id` = '$truck_id'"); 
           $account_number = $myName->showName($conn, "SELECT  `account_number` FROM `truck` WHERE `id` = '$truck_id'"); 
          
         
         
         $truck_type = $myName->showName($conn, "SELECT `name` FROM `truck_type` WHERE  `id` = '$truck_type'"); 
         $total_capacity = $myName->showName($conn, "SELECT  `capacity` FROM `truck_capacity` WHERE   `id` = '$total_capacity'"); 
         $truck_owner = $myName->showName($conn, "SELECT  `name` FROM `user_unit` WHERE   `account_number` = '$account_number'"); 
         $patron_name = $myName->showName($conn, "SELECT  `name` FROM `user_unit` WHERE   `account_number` = '$registeredby'"); 
         $patron_phone = $myName->showName($conn, "SELECT  `phone` FROM `user_unit` WHERE   `account_number` = '$registeredby'"); 
         
    /*     $search_value =  	strtr(base64_encode($code),'-_,', '+/=');
         $search_value2 =  	strtr(base64_encode($code),'+/=****', '-_,****');*/
          
         
                 
 $negotiate = $myName->showName($conn, "SELECT  `negotiate` FROM `negotiation_criterai` WHERE   `registeredby` = '$account_number' and `truck` = '$truck_id'");
          $negotiate_button = "";
          $payment_button = "";
         
        /*status = 0 = Active
   status = 1 = Paid
   status = 2 = Waiting Approval
   status = 3 = Rejected Offer
   status = 4 = Order Accepted
   status = 5 = Completed
   status = 6 = Negotiation Approved
   status = 7 = Arrived
   status = 8 = Trip Started
   status = 9 = Trip Ended*/
         
         
         
         
        $value_super = ""  ;
          $statusCSS = "";
$statusParam = "";
if($status == 1)
{
 $statusCSS = "alert alert-success";
$statusParam = "Paid";
}			
else  if($status == 0)
{
 $statusCSS = "alert alert-danger";
$statusParam = "Pending";
}else  if($status == 2)
{
 $statusCSS = "alert alert-danger";
$statusParam = "Waiting Acceptance";
}
 else  if($status == 4)
{
 $statusCSS = "label label-info m-b-5";
$statusParam = "Delivered";
} 
else  if($status == 3)
{
 $statusCSSe= "alert alert-danger";
$statusParam = "Captain  Rejected Offer";
   
    
}
 else  if($status == 4)
{
 $statusCSS= "alert alert-success";
$statusParam = "Ride Accepted";
     
 if(!empty($negotiate) and $negotiate == "Yes")
         {
             
             $negotiation_status = "Yes";
             
             $negotiate_button = '<button type="button" class="btn btn-primary w-100 box-shadow-0 font-weight-light text-uppercase" onClick="negotiate()">Negotiate </button>';
         }     
      $payment_button = '<button type="button" name="pay" class="btn btn-primary w-100 box-shadow-0 font-weight-light text-uppercase" onClick="payWithRave()">Pay Now </button>';
     
       
/* $value_super = '<h4><a class="label"   onClick="return confirm(\'Are you sure you want to continue?\')" href="payment-proceed?payment='.$search_value2.'">   <span class="icon fa fa-credit-card">  </span>   <strong>Make Payment </strong> 
(Flutterwaves)</a> </h4><a class="label"   onClick="return confirm(\'Are you sure you want to continue?\')" href="payment-proceed?payment='.$search_value2.'">   <img src="images/RAVE.png" width="150px" height="60px"></a>';*/
      
   
    
}else  if($status == 6)
{
 $statusCSS= "alert alert-success";
$statusParam = "Negotiation Approved";
   
    
} 
         else  if($status == 5)
{
 $statusCSS= "alert alert-success";
$statusParam = "Trip Completed";
   
    
}      else  if($status == 7)
{
 $statusCSS= "alert alert-success";
$statusParam = "Captain Arrived";
   
    
} 
             else  if($status == 8)
{
 $statusCSS= "alert alert-success";
$statusParam = "Trip Started";
   
    
}  else  if($status == 9)
{
 $statusCSS= "alert alert-success";
$statusParam = "Trip Ended";
   
    
} 
    else  if($status == 10)
{
 $statusCSS= "alert alert-success";
$statusParam = "Unconfirmed Cash Payment";
   
    
} 
    
      
         
         
          
         
          
        $rating = $myName->showName($conn, "SELECT  `ratings_score` FROM `ratings` WHERE  `rideid` = '$code' AND `status` = '2'");      
      
         $today =	date("d-m-Y", strtotime($created_date));
        // strtotime('Y-m-d', $created_date);
    	      
		 //SELECT `lati`, `longi`, `end_longi`, `end_lati` FROM `trip_record` WHERE  `code`
		 
		 $start_lat = $myName->showName($conn, "SELECT  `lati` FROM `trip_record` WHERE  `code` = '$code'"); 
		 $start_long = $myName->showName($conn, "SELECT  `longi` FROM `trip_record` WHERE  `code` = '$code'"); 
		 $end_lati = $myName->showName($conn, "SELECT  `end_lati` FROM `trip_record` WHERE  `code` = '$code'"); 
		 $end_longi = $myName->showName($conn, "SELECT  `end_longi` FROM `trip_record` WHERE  `code` = '$code'"); 
		 
		 
$json2 .= '{
    "ride_code": "'.$code.'",
    "pick_up": "'.$loading.'",
    "destination": "'.$destination.'",
    "pickup_date": "'.$today.'",
    "amount": "'.number_format($amount,2).'",
    "patron_name": "'.$patron_name .'",
    "patron_wynkid": "'.$registeredby .'",
    "start_lat": "'.$start_lat .'",
    "start_long": "'.$start_long .'",
    "end_lati": "'.$end_lati .'",
    "end_longi": "'.$end_longi .'",
    "rating": "'.$rating .'"
},'; 
		     
         
         
         
         
         
          
}
        
 
        
  
	$json2 .= "]";
	
	//echo $json2;
	 
	 $json1 = '{
    "statusCode": 200,
    "message": '.$json2.'}';
	 
	  
 $json1 = substr_replace($json1, '', strrpos($json1, ','), 1);
  echo trim($json1);
		
		
		
//	 echo json_encode(array("statusCode"=>200, "errorMessage"=>$value_value, "code"=>$code, "truck"=>$truck_id, "flutterapi"=>$flutterapi, "totalamount"=>$total, "inst_name"=>$inst_name, "inst_slogan"=>$inst_slogan, "logo"=>$logo));  					  
		}	
else{
    
 
    
    
    echo json_encode(array("statusCode"=>201, "errorMessage"=>"There is nothing to see here yet. Please check back later. Thank you."));  
}
				 
			 
			 
	}	
else
{
    
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Invalid Input Paramater. Please check and try again."));  
}
	 
?>