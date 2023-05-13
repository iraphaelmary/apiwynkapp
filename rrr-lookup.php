<?php 
header('Access-Control-Allow-Origin: *');
   date_default_timezone_set('Africa/Lagos');
	
 require_once('config/DB_config.php');
require_once('class_file.php');

$myName = new Name();


$json =  json_decode(file_get_contents('php://input'), true);

 
$rrr = $json['rrr']; 
// $channel = "9 mobile"; 


//$rrr = '160800168011';
 

//$clientReference = date('dmY').rand(234,62662);
if(!empty($rrr))
{
	
	 
        
       $remita_url = $myName->showName($conn, "SELECT `remita_url` FROM `application` WHERE 1");	
       $remita_username = $myName->showName($conn, "SELECT `remita_username` FROM `application` WHERE 1");		
       $remita_password = $myName->showName($conn, "SELECT `remita_password` FROM `application` WHERE 1");		
     //  $pin = $myName->showName($conn, "SELECT `pin` FROM `user_unit` WHERE `account_number` = '$wynkid'");		
    //   $wynk_name = $myName->showName($conn, "SELECT `name` FROM `user_unit` WHERE `account_number` = '$wynkid'");		
       
     

   $remita_scheme = $myName->showName($conn, "SELECT `remita_scheme` FROM `application` WHERE 1");	
	
	
	 /*$remita_url= "https://walletdemo.remita.net/api";
      $remita_username= "+2348160921372";
      $remita_password= "aLLahuakbar#1";
      $remita_scheme= "53797374656d73706563732077616c6c6574";*/
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
  "scheme": "$remita_scheme" 

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
        
        //echo $resp;
        $message = $resp['message'];
     
        if($message == "Login success")
        { $token = $resp['token'];
             //$pin = $resp['user']['pin'];
           $id = $resp['user']['id'];
           $profileID = $resp['user']['profileID'];
 
 $url =  $remita_url."/pay-billers/rrr/details?rrr=".$rrr;
 



$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "accept: application/json",
   "Authorization: Bearer ".$token,
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
		 
		 //echo $resp;
curl_close($curl);
//var_dump($resp);
		 if($err){
 
     echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$err."."));  
}
    else
    {
        
        
        $resp = json_decode($resp, true);
        
        //echo $resp;
		
		
		/*billerId: "FUTOWERRI",
billerName: "FEDERAL UNIVERSITY OF TECHNOLOGY, OWERRI ",
productName: "DEVELOPMENT LEVY",
categoryId: "6",
categoryName: "Educational Institutions",
name: "Akah Favour Ngozi",
phoneNumber: "08035500222",
email: "akahchiamakagoodness@gmail.com",
amount: 52661.25,
fee: 161.25,
rrrAmount: 52500,
rrr: "160800168011",
currency: "NGN",
description: "FEDERAL UNIVERSITY OF TECHNOLOGY, OWERRI - DEVELOPMENT LEVY",
vtu: false,
rrrType: "PY",
status: "paid",*/
        $message = $resp['message'];
        $code = $resp['code'];
     
        if($code == "00")
        {  
           $billerId = $resp['data']['billerId'];
           $billerName = $resp['data']['billerName'];
           $productName = $resp['data']['productName'];
           $categoryId = $resp['data']['categoryId'];
           $categoryName = $resp['data']['categoryName'];
           $name = $resp['data']['name'];
           $phoneNumber = $resp['data']['phoneNumber'];
           $email = $resp['data']['email'];
           $amount = $resp['data']['amount'];
           $fee = $resp['data']['fee'];
           $rrrAmount = $resp['data']['rrrAmount'];
           $rrr = $resp['data']['rrr'];
           $description = $resp['data']['description'];
           $rrrType = $resp['data']['rrrType'];
			
		 echo json_encode(array("statusCode"=>200, "billerId"=>$billerId, "billerName"=>$billerName, "productName"=>$productName, "categoryId"=>$categoryId, "categoryName"=>$categoryName, "name"=>$name, "phoneNumber"=>$phoneNumber, "email"=>$email, "amount"=>$amount, "fee"=>$fee, "rrrAmount"=>$rrrAmount, "rrr"=>$rrr, "description"=>$description, "rrrType"=>$rrrType));  	
			
			
			
 
		}
		else{
			
			 echo json_encode(array("statusCode"=>201, "errorMessage"=>"Error Occured: ".$message."."));  
		}
	}
 

 
  
            
            
             
        
    } else
							  {
								  
					echo json_encode(array("statusCode"=>201, "errorMessage"=>"Server Cannot Be Reached At This Moment. Please try again later."));  			  
							  }
    }















}
  else
							  {
								  
					echo json_encode(array("statusCode"=>201, "errorMessage"=>"Important Field Left Empty."));  			  
							  }

?>

