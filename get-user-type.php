	 <?php
	header('Access-Control-Allow-Origin: *');
include ("config/DB_config.php"); 


include("class_file.php");
 
 //include("SendingSMS.php");

 $today=date("Y-m-d");
  $myName = new Name();
 $counting = 0;
 

 





$json =  json_decode(file_get_contents('php://input'), true);



$wynkid =  $json["wynkid"];

 
 if(!empty($wynkid))
 { 
   
  
		 
    

    
    
     $usertype = $myName->showName($conn, "SELECT `usertype` FROM `user_unit` WHERE `account_number` = '$wynkid'");
 
    $user_type_name = "Patron";
	 
	 if($usertype == 2)
	 {
		 
		 $user_type_name = "Captain";
	 }
	 else{
		 
		     $user_type_name = "Patron";
	 }
    
    
     echo json_encode(array("statusCode"=>200, "message"=>$user_type_name, "usertype"=>$usertype));  
 	
 
}
 
 

//echo $query;





	 

	   
?>
 









<?php
/*header('Access-Control-Allow-Origin: *');
	include("config/DB_config.php");
















$publish_coordinate = "-33.91721, 151.2263*"."-33.91539, 151.2282";


	 

///echo $publish_coordinate;

	































echo json_encode(array("statusCode"=>200, "errorMessage"=>"Success", "inst_name"=>$publish_coordinate));  		
 
 
	
		//exit;
		 */
 

?>