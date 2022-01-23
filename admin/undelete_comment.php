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

$post = $_GET['p'];
$comment = $_GET['c'];

$sql = "UPDATE comment SET Showed = \"1\" WHERE CommentID = \"".$comment."\";";
if (mysqli_query($conn, $sql)) {
 	echo '<script>alert("Comment restored.")</script>';
	echo("<script>window.location = 'comment.php?p=".$post."';</script>");
} else {
 	echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
	echo("<script>window.location = 'comment.php?p=".$post."';</script>");
}
?>