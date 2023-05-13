<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 //header('Access-Control-Allow-Origin: *');
  include("SendingSMS1.php");

 
 
 

  $message = "test from mine";

  
 	 $Sending = new SendingSMS(); 
  							 
		  
 $ra = 	$Sending->smsAPI("08035538658","WYNK",$message);
 echo $ra." mighty";


 
 

 


?>

