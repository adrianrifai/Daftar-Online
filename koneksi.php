<?php

// $host='127.0.0.1/3051:D:\FB_DATABASES\HIS\DB_HIS_NATALIA.FDB';
// $username='SYSDBA';
// $password='masterkey';
// $dbh=ibase_connect($host,$username,$password);



$servername = "112.78.43.162";
$username = "root";
$password = "12500103Lynx";
$dbname = "simrs_natalia";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn -> connect_errno) {
    echo "Failed to connect to MySQL: " . $conn -> connect_error;
    exit();
  }

?>


