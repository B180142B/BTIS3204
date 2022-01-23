<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "finalproject";
 
// Attempt to connect to MySQL database
$conn = mysqli_connect($servername, $username, $password, $dbName);

// check the connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}