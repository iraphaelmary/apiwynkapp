<?php
header('Access-Control-Allow-Origin: *');
 
 

include("config/DB_config.php");
 
 include("SendingSMS.php");
 include("view-application-details.php");
 
 
$picture = "";
$wynkid  = "";
$account_number  = "";
include("class_file.php");
 $json =  json_decode(file_get_contents('php://input'), true);

 




 
    
  $account_number =  $json['wynkid'];  
 
    
$picture = $json['picture'];    
 
 


 
 
 $myName = new Name();
 
     
             
             
             $passport = "picture/".$account_number.".png";
              $smallpassport = $account_number.".png";
	
	
	
        saveBase64ImagePng("data:image/png;base64,".$picture, "picture/", $account_number);   
	
	
	
$sql = 	 "UPDATE `user_unit` SET  `picture` = '$picture', `picture_png` = '$smallpassport' WHERE `account_number` = '$account_number'";
 
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 $process = true;
	if ($process) {
		 
  
       
        $full_passport = "http://wynk.ng/stagging-api/".$passport;
 echo json_encode(array("statusCode"=>200, 
 "message"=>"Picture Captured Sucessfully. Thank You.", "passport"=>$full_passport,"smallpassport"=>$smallpassport));   
        
        
              
            
        
        
    }
     else {
 
 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Information Not Submitted Successfully. Please try again later."));  
        
    
}
            
            
             
 
         
        
   
            
            
            
            
     
        
   
 
        
        
        
        
 

function saveBase64ImagePng($base64Image, $imageDir, $filename)
{
    //set name of the image file

    $fileName =  $filename.'.png';

    $base64Image = trim($base64Image);
    $base64Image = str_replace('data:image/png;base64,', '', $base64Image);
    $base64Image = str_replace('data:image/jpg;base64,', '', $base64Image);
    $base64Image = str_replace('data:image/jpeg;base64,', '', $base64Image);
    $base64Image = str_replace('data:image/gif;base64,', '', $base64Image);
    $base64Image = str_replace(' ', '+', $base64Image);

    $imageData = base64_decode($base64Image);
    //Set image whole path here 
    $filePath = $imageDir . $fileName;


   file_put_contents($filePath, $imageData);


}











?>