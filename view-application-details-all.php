 
<?php
header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Origin: *');
include ("config/DB_config.php"); 
 


 $query =  "SELECT    `id`, `name`, `phone`, `email`, `slogan`, `address`, `logo`, `ip`, `port`, `acct_num`, `bank_name`, `flutterapi`, `flutterapisecret`, `merchant_key`, `api_key`, `fee`, `googleapi`  FROM `application`  WHERE `status` = 1";	
  
 
 $extract_distance = mysqli_query($conn, $query) or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_distance);
    if ($count > 0)
		  {
 	 while ($row_distance=mysqli_fetch_row($extract_distance))
    {
  						    $id1 =$row_distance[0];
						      $inst_name =$row_distance[1];
					           $inst_phone =$row_distance[2];
		                          $inst_email =$row_distance[3];
						   $inst_slogan =$row_distance[4]; 
					       $inst_address =$row_distance[5];
		                      $inst_logo =$row_distance[6];
                               // $inst_ip =$row_distance[7];
					         //  $inst_port =$row_distance[8];
		      $inst_acct_num =$row_distance[9];
		      $inst_bank_name =$row_distance[10];
		 	 $inst_flutterapi =$row_distance[11];
		 	 $inst_flutterapisecret =$row_distance[12];
		 	 $inst_merchant_key =$row_distance[13];
		 	 $inst_api_key =$row_distance[14];
		 	 $inst_fee =$row_distance[15];
		 	 $googleapi =$row_distance[16];
		 	 
		 
						 
					  
     
	 echo json_encode(array("statusCode"=>200, "errorMessage"=>"Success", "inst_name"=>$inst_name, "inst_phone"=>$inst_phone, "inst_email"=>$inst_email, "inst_slogan"=>$inst_slogan, "inst_address"=>$inst_address, "inst_logo"=>$inst_logo, "inst_acct_num"=>$inst_acct_num, "inst_bank_name"=>$inst_bank_name, "inst_flutterapi"=>$inst_flutterapi, "inst_flutterapisecret"=>$inst_flutterapisecret, "inst_fee"=>$inst_fee, "googleapi"=>$googleapi));  		
 
 




 
											 
											     
									 
	 
}
 
						  
		}else
    {
        
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: Information not retrieved successfully."));  		
    
    }
		 	 	
 
		   
	 
?>