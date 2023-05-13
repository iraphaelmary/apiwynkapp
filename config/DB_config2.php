<?php

  include_once('config2.php'); 
  $conn2 = "";
  $conn2 = new mysqli(_DB_SERVER2_, _DB_USER2_,_DB_PASSWD2_);
// Check connection
if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
} 
  
 
 // Create connection
$conn2 = new mysqli(_DB_SERVER2_, _DB_USER2_,_DB_PASSWD2_, _DB_NAME2_);
// Check connection
if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
} 

  date_default_timezone_set('Africa/Lagos');
 $datetime=date("Y-m-d G:i:s");
?>