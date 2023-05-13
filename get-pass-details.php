 
<?php
 header('Access-Control-Allow-Origin: *');
  include("SendingSMS.php");

  include("config/DB_config.php");
 
require_once('view-application-details.php');
include("class_file.php");
 $myName = new Name();





$json =  json_decode(file_get_contents('php://input'), true);



$username =  $json["wynkid"];


if(!empty($username))
{



//$captain_type = $myName->showName($conn, "SELECT `captain_type` FROM `user_unit` WHERE  (`account_number` = '$username')"); 

$captain_type = $myName->showName($conn, "SELECT `association` FROM `user_unit` WHERE  (`account_number` = '$username')"); 

if($captain_type != 0 and !empty($captain_type) or $captain_type != 'normal')
{
	
 $query =  "SELECT  `id`, `pass_name`, `pass_type`, `pass_duration`, `payment`, `percentage_wynk`, `percentage_welfare`, `created_date`, `registeredby`, `status` FROM `captain_pass_setup`  WHERE `status` = 1 ORDER BY `pass_type`, `pass_name`";		
}
else
{
 $query =  "SELECT  `id`, `pass_name`, `pass_type`, `pass_duration`, `payment`, `percentage_wynk`, `percentage_welfare`, `created_date`, `registeredby`, `status` FROM `captain_pass_setup`  WHERE `status` = 1 AND `pass_type` = 1 ORDER BY `payment`";	
	
}



  
 
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
		
		    $json2 = '[';
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {
  						    $id1 =$row_distance[0];
						      $pass_name =$row_distance[1];
					           $pass_type =$row_distance[2];
		                          $pass_duration =$row_distance[3];
						   $payment =$row_distance[4]; 
					       $percentage_wynk =$row_distance[5];
		                      $percentage_welfare =$row_distance[6];
                            $created_date =$row_distance[7];
					        $registeredby =$row_distance[8];
		      $status =$row_distance[9];
		     
		 
						 
					 $pass_type_name = "";
         if($pass_type == 1)
         {
             $pass_type_name = "Pre-Paid";
             
         }
         else  if($pass_type == 2)
         {
             $pass_type_name = "Post-Paid";
             
         } 
         
         
         $pass_duration_name = "";
         if($pass_duration == 1)
         {
             $pass_duration_name = "1 month";
             
         }
         else  if($pass_duration == 2)
         {
             $pass_duration_name = "7 days";
             
         } 
         else  if($pass_duration == 3)
         {
             $pass_duration_name = "1 day";
             
         } 
		 
		 
		 				 
			
$json2 .= '{
    "pass_id": "'.$id1.'",
    "pass_name": "'.$pass_name.'",
    "amount": "'.$payment.'",
     "pass_type": "'.$pass_type.'",
       "pass_type_name": "'.$pass_type_name.'",
    "duration": "'.$pass_duration_name.'"
},'; 
		 
		 
     
      /*   
        $value .= ' <div class="col-12 col-md-6 col-lg-4">
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header" style="background-color: #211E8A; color: white;">
                            <h4 class="my-0 font-weight-normal">'.$pass_name.'</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title"><img src="https://softnoche.com/wynk/mobile/whatsapp.png" style="width: 100px; height: 100px;"></h1>
                            <h1 class="card-title pricing-card-title">&#8358; '.number_format($payment,2).' <small class="text-muted"></small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>Valid for '.$pass_duration_name.'</li>
                                
                            </ul>
                            <button type="button" class="btn btn-rounded btn-block shadow btn-outline-default" style="background-color: #211E8A; color: white;" onClick="payForPass(\'' . $pass_name . '\', \'' . $id1 . '\', \'' . $pass_type_name . '\', \'' . $pass_duration_name . '\')">Subscribe</button>
                        </div>
                    </div>
                </div>
                ';
         
         
	 */
 
 




 
											 
											     
									 
	 
}
 
		$json2 .= "]";
	
	//echo $json2;
	 
	 $json1 = '{
    "statusCode": 200,
    "message": '.$json2.'}';
	 
	  
 $json1 = substr_replace($json1, '', strrpos($json1, ','), 1);
  echo trim($json1);
		
		
//echo json_encode(array("statusCode"=>200, "errorMessage"=>"Success", "details"=>$value));  								  
		}else
    {
        
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: Information not retrieved successfully."));  		
    
    }
		 	 	
 
}		   
	 else
    {
        
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"User Information Not Available..."));  		
    
    }
?>