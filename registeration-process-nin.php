<?php
header('Access-Control-Allow-Origin: *');
 
 

include("config/DB_config.php");
 
 include("SendingSMS.php");
 include("view-application-details.php");
$referral_code = "";
$firstname = "";
$email = "";
$lastname = "";
$name = "";
$address = "";
$wynkid  = "";
$v_nin  = "";
$o_nin  = "";
include("class_file.php");
 $json =  json_decode(file_get_contents('php://input'), true);

 




if(isset($json['firstname']))
{
    
  $firstname = htmlspecialchars(trim($json['firstname']));  
}

if(isset($json['referral_code']))
{
    
$referral_code = htmlspecialchars(trim($json['referral_code']));    
}
if(isset($json['email']))
{
    
$email = htmlspecialchars(trim($json['email']));   
}
if(isset($json['lastname']))
{
    
  $lastname = htmlspecialchars(trim($json['lastname']));
}
if(isset($json['firstname']))
{
    
   $name = htmlspecialchars(trim($json['firstname']));
}
if(isset($json['address']))
{
    
  $address = htmlspecialchars(trim($json['address']));
}
if(isset($json['wynkid']))
{
    
  $wynkid =  $json["wynkid"];
}
if(isset($json['v_nin']))
{
    
  $v_nin =  $json["v_nin"];
}
if(isset($json['o_nin']))
{
    
  $o_nin =  $json["o_nin"];
}

/*
$wynkid = "WYNK74485060";
$v_nin = "WX3382653627623Y";
$o_nin = "63844179698";
$firstname = "DAMILARE";
$lastname = "OGUNWEHIN";
$name = "DAMILARE";
*/
 
 
 $myName = new Name();
 
     

     
if (empty($firstname) || empty($lastname) || empty($wynkid))
{
  
   
  
  	  
	echo json_encode(array("statusCode"=>201, "errorMessage"=>"Firstname, Lastname and Wynk Id are required fields. Please check and try again."));
	
}
else
{ 
 

 //echo "heere 1";

 
$state  = 0;
$lga    =0;
$number    = 0;
 
       //$pin2 =   rand(0, 8).rand(0, 8).rand(1, 9).rand(1, 9);	
	// $address= "";
	 $logo = "" ;
	   $account_number = $wynkid;		
	   $emailing = $wynkid;		
	 
       $phone = $myName->showName($conn, "SELECT `phone`  FROM `user_unit` WHERE   `account_number` = '$wynkid'");
       $verification_type = $myName->showName($conn, "SELECT `varify_type`  FROM `user_unit` WHERE   `account_number` = '$wynkid'");
       $id_number = $myName->showName($conn, "SELECT `id_number`  FROM `user_unit` WHERE   `account_number` = '$wynkid'");
       $verifyme_url = $myName->showName($conn, "SELECT  `verifyme_url` FROM `application` WHERE `status` = 1");
  $verifyme_api_key = $myName->showName($conn, "SELECT  `verifyme_api_key` FROM `application` WHERE `status` = 1");
	
	
	
	
	
 $identitypassapikey = $myName->showName($conn, "SELECT `identitypassapikey` FROM `application` WHERE 1");		
$identitypassbaseurl = $myName->showName($conn, "SELECT `identitypassbaseurl` FROM `application` WHERE 1");		
        
if(empty($phone))
{
    echo json_encode(array("statusCode"=>201, "errorMessage"=>"User information not found in the database. Please check and try again.")); 
			 
    
}
    else
    {
        
        
   // echo json_encode(array("statusCode"=>201, "errorMessage"=>"User information not found in the database. Please check and try again."));
    
     $new_number = str_replace('234', '0', $phone);
	 /* $value = dataVerification_nin($new_number,$identitypassbaseurl."/api/v2/biometrics/merchant/data/verification/phone_number/advance",$identitypassapikey);*/
		
	$value = dataVerification_nin($o_nin,$v_nin,$identitypassbaseurl."/api/v2/biometrics/merchant/data/verification/nin_wo_face", $identitypassapikey,"90eb1a16-d691-4597-a50f-c81fd99c08bd");		  
	  
 $resp = json_decode($value, true);
        
 //echo 	$value;
       
        $response_code = $resp['response_code'];
       
	  if($response_code == "00")
	  {
		   $detail = $resp['detail'];
		   $rmiddlename = $resp['nin_data']['middlename'];
        $rlastname = $resp['nin_data']['surname'];
        $rphone = $resp['nin_data']['telephoneno'];
        $rbirthdate = $resp['nin_data']['birthdate'];
        $rfirstname = $resp['nin_data']['firstname'];
        $rphoto = $resp['nin_data']['photo'];
        $rgender = $resp['nin_data']['gender'];
		  
		//  echo $rphone." rphone";
                if(!empty($rphone) or !is_null($rphone))
            {
                if(strtolower(trim($name))  != strtolower(trim($rfirstname)))
                {
                    
                  echo json_encode(array("statusCode"=>201, "errorMessage"=>"First Name Supplied Doesn't Match."));   
                }
            else  if(strtolower(trim($lastname))  != strtolower(trim($rlastname))) 
            {
                 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Last Name Supplied Doesn't Match."));   
                
            }
        /*    else if($phone != $rphone)
            {
                 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Phone Supplied Doesn't Match."));   
                
            }*/
            else{
         
 
  $extract_user = mysqli_query($conn, "SELECT `phone`  FROM `user_unit` WHERE `account_number` = '$account_number'") or die(mysqli_error($conn));
		$count = mysqli_num_rows($extract_user);
		 if($count < 0) {
	 	  
			 
 
			 
			echo json_encode(array("statusCode"=>201, "errorMessage"=>"This User information not found in the database. Please check and try again.")); 
			 
		 
 
		 }else
		 {
  
	 $name = $rfirstname. ' '.$rlastname;
             
             
             $passport = "picture/".$account_number."_2.png";
              $smallpassport = $account_number."_2.png";
        saveBase64ImagePng("data:image/png;base64,".$rphoto, "picture/", $account_number."_2");     
$sql = 	 "UPDATE `user_unit` SET `name` = '$name',`phone` = '$phone', `email` = '$email', `address` = '$address', `created_date` = '$datetime', 
`registeredby` = '$emailing', `status` = 1,`file` = '$rphoto', `password_update` = '1', `firstname` = '$rfirstname', `lastname` = '$rlastname',
`middlename` = '$rmiddlename', `gender` = '$rgender', `dob` = '$rbirthdate', `passport` = '$passport' WHERE `account_number` = '$account_number'";
 
 
 $process = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 $process = true;
	if ($process) {
		 
 
         	$rfirstname = $resp['nin_data']['firstname'];
             	$rlastname = $resp['nin_data']['lastname'];
             	$rmiddlename = $resp['nin_data']['middlename'];
                $rgender = $resp['nin_data']['gender'];
               $rphone = $resp['nin_data']['phone'];
               $rbirthdate = $resp['nin_data']['birthdate'];
               $rphoto = $resp['nin_data']['photo'];
       
        $full_passport = "http://wynk.ng/stagging-api/".$passport;
 echo json_encode(array("statusCode"=>200, 
 "message"=>"Welcome to ".$inst_name.". Sign up successful. Just one more step. Create your pin and you're good to go.", 
 "firstname"=>$rfirstname, "account_number"=>$account_number, "lastname"=>$rlastname, "middlename"=>$rmiddlename, "gender"=>$rgender, "phone"=>$rphone, "birthdate"=>$rbirthdate,"passport"=>$full_passport,"smallpassport"=>$smallpassport));   
        
        
              
            
        
        
    }
     else {
 
 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Information Not Submitted Successfully. Please try again later."));  
        
    
}
            
            
             
        
    }
     
         
        
   
            
            
            
            
     
        
         
    }
 
        
        
        
        
        
        
        
         
		
		
		
		 
		
		
	
		
			
		}
  else
            {
                
                echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: We can't verify user   at the moment. Please check back later." )); 
            }
		 
	  }
		else
		{
			
			
			   
                
                echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: We can't verify user at the moment. Please check back later." )); 
            
		}
		
		
		
		 

  
 
		
 
 }
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