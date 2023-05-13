<?php

  include_once('config.php'); 
  $conn = "";
  $conn = new mysqli(_DB_SERVER_, _DB_USER_,_DB_PASSWD_);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
  
 
 // Create connection
$conn = new mysqli(_DB_SERVER_, _DB_USER_,_DB_PASSWD_, _DB_NAME_);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

  date_default_timezone_set('Africa/Lagos');
 $datetime=date("Y-m-d G:i:s");
?>