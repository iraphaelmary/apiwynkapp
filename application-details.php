 
<?php
 header('Access-Control-Allow-Origin: *');
include ("config/DB_config.php"); 
 


 $query =  "SELECT    `id`, `name`, `phone`, `email`, `slogan`, `address`, `logo`, `ip`, `port`, `acct_num`, `bank_name`, `flutterapi`, `flutterapisecret`, `merchant_key`, `api_key`, `fee`, `googleapi`, `remita_username`, `remita_password`,   `remita_url`  FROM `application`  WHERE `status` = 1";	
  
 
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
		 	 $remita_username =$row_distance[17];
		 	 $remita_password =$row_distance[18];
		 	 $remita_url =$row_distance[19];
		 	 
		 
						 
				 

  echo json_encode(array("statusCode"=>200, "appname"=>$inst_name, "appphone"=>$inst_phone, "appemail"=>$inst_email, "appaddress"=>$inst_address, "googleapi"=>$googleapi));  			


 
											 
											     
									 
	 
}
 
						  
		} 
		 	 	
 
		   
	 
?>