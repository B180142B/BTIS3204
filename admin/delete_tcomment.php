<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["admin_loggedin"]) && $_SESSION["admin_loggedin"] != true){
    header("location: index.php");
    exit;
}

// Include config file
require_once "../assets/db/config.php";

$tpost = $_GET['tp'];
$tcomment = $_GET['tc'];

$sql = "UPDATE tcomment SET Showed = \"0\" WHERE TCommentID = \"".$tcomment."\";";
if (mysqli_query($conn, $sql)) {
 	echo '<script>alert("Comment deleted.")</script>';
	echo("<script>window.location = 'tcomment.php?tp=".$tpost."';</script>");
} else {
 	echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
	echo("<script>window.location = 'tcomment.php?tp=".$tpost."';</script>");
}
?>