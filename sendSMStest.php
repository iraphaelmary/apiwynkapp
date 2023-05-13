<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 //header('Access-Control-Allow-Origin: *');
  include("SendingSMS1.php");

 
 
 

  $message = "Hi MIGHTY! Your OcxvxcvxcTP #23434.";

  
 	 $Sending = new SendingSMS(); 
  							 
		  
 $ra = 	$Sending->smsAPI("08035538658","WYNK",$message);
 echo $ra." mighty";


 
 

 


?>

