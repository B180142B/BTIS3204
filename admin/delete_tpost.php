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

$sql = "UPDATE tpost SET Showed = \"0\" WHERE TPostID = \"".$tpost."\";";
if (mysqli_query($conn, $sql)) {
 	echo '<script>alert("Post deleted.")</script>';
	echo("<script>window.location = 'teacher_forum_list.php';</script>");
} else {
 	echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
	echo("<script>window.location = 'teacher_forum_list.php';</script>");
}
?>