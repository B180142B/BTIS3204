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

// Prepare a select statement
$sql = "SELECT * FROM admin WHERE AdminID = ".$_SESSION["admin_id"].";";

$res = mysqli_query($conn, $sql);

$myrow = mysqli_fetch_assoc($res);

$student = $_GET['s'];

// Prepare a select statement
$sql1 = "SELECT * FROM student WHERE StudentID = ".$student.";";

$res1 = mysqli_query($conn, $sql1);

$myrow1 = mysqli_fetch_assoc($res1);

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql2 = "UPDATE student SET Activated = 1 WHERE StudentID = ".$student.";";
    if (mysqli_query($conn, $sql2)) {
    	echo '<script>alert("Account Verified.")</script>';
    } else {
    	echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
    }
}
?>

<!doctype html>
<html lang="en">
<head>
	<title>Verify Student Account</title>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/style2.css">
	<style>
		.flex-container {
			display: flex;
			flex-wrap: nowrap;
			display: inline-flex;
			flex-flow: column;
		}

		.flex-container2 {
			background-color: #f1f1f1;
			width: 200px;
			margin: 10px;
			text-align: center;
			line-height: 75px;
			font-size: 30px;
			margin: 50px;
			border: solid purple 2px;
			border-radius: 5px;
			font-size: 20px;
		}
		/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

/* Set a style for all buttons */
button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.disabledd {
	background-color: grey;
}

.disabledd:hover {
	background-color: grey;
	opacity: 1;
}

/* Extra styles for the cancel button */
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

/* Center the image and position the close button */
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
  position: relative;
}

img.avatar {
  width: 40%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* The Modal (background) */
.modal {
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button (x) */
.close {
  position: absolute;
  right: 25px;
  top: 0;
  color: #000;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: red;
  cursor: pointer;
}

/* Add Zoom Animation */
.animate {
  -webkit-animation: animatezoom 0.6s;
  animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
  from {-webkit-transform: scale(0)} 
  to {-webkit-transform: scale(1)}
}
  
@keyframes animatezoom {
  from {transform: scale(0)} 
  to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
	</style>
</head>
<body>

	<div class="wrapper d-flex align-items-stretch">
		<nav id="sidebar">
			<div class="custom-menu">
				<button type="button" id="sidebarCollapse" class="btn btn-primary">
					<i class="fa fa-bars"></i>
					<span class="sr-only">Toggle Menu</span>
				</button>
			</div>
			<div class="p-4 pt-5">
				<h1 style="color: white;">Welcome</h1>
				<h2 style="color: white;"><?php echo $myrow['Name']; ?></h2>
				<ul class="list-unstyled components mb-5">
					<li>
						<a href="homepage.php">Home</a>
					</li>
					<li class="active">
						<a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">User Account</a>
						<ul class="collapse list-unstyled" id="homeSubmenu">
							<li>
								<a href="admin_list.php">Admin</a>
							</li>
							<li>
								<a href="teacher_list.php">Teacher</a>
							</li>
							<li>
								<a href="student_list.php">Student</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="announcement.php">Announcement</a>
					</li>

					<li>
						<a href="class.php">Student Class</a>
					</li>
					<li>
						<a href="class_teacher.php">Class Teacher</a>
					</li>
					<li>
						<a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Forum</a>
						<ul class="collapse list-unstyled" id="pageSubmenu">
							<li>
								<a href="teacher_forum_list.php">Teacher Post</a>
							</li>
							<li>
								<a href="student_forum_list.php">Student Post</a>
							</li>
						</ul>
						<li>
							<a href="assets/db/logout.php">Log Out</a>
						</li>
					</li>
				</ul>

			</div>
    	</nav>
    	
    	<!-- Page Content  -->
    	<div id="content" class="p-4 p-md-5 pt-5">
    		<div style="text-align: center; margin-top: 100px;">
      			<div class="">

      				<form class="modal-content animate" method="post">
      					<div class="imgcontainer">

      						<img src="<?php echo "../".$myrow1['ID_Card']; ?>" alt="ID card" class="avatar">
      					</div>

      					<div class="container">
      						<label><b>Student ID</b></label>
      						<input type="text" placeholder="<?php echo $myrow1['Username']; ?>" disabled>

      						<label><b>Name</b></label>
      						<input type="text" placeholder="<?php echo $myrow1['Name']; ?>" disabled>

      						<label><b>Phone Number</b></label>
      						<input type="text" placeholder="<?php echo $myrow1['PhoneNo']; ?>" disabled>
      						
      						<label><b>Email</b></label>
      						<input type="text" placeholder="<?php echo $myrow1['Email']; ?>" disabled>

<?php if ($myrow1['Activated'] == 1) {?>
									<button type="submit" class="disabledd" disabled>Verified</button>
<?php } else { ?>
									<button type="submit">Verify</button>
<?php }?>

      					</div>
      				</form>
      			</div>
	      	</div>
	    </div>
	</div>

	<script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>