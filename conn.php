<?php

 // db connetion to xampp localhost
 $servername = "localhost"; $usrname = "root"; $pass = ""; $dbname = "WaterDistrict";

 // connection
 
 $conn = new mysqli($servername, $usrname, $pass, $dbname); 
 
 // checking conn
 if ($conn->connect_error) { die ("Connecting failed to process: " . $conn->connect_error); }


?>
