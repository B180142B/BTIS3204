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
?>

<!doctype html>
<html lang="en">
<head>
	<title>Teacher Post</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/style2.css">
	<style>
		table, th, td {
	  		border:1px solid black;
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
      			<div>
      				<table  style="width:100%">
      					<h2>Teacher Post</h2>
      					<tr>
      						<th>Post</th>
      						<th>Author</th>
      						<th>Uploaded Time</th>
      						<th>Function</th>
      					</tr>

<?php
// Prepare a select statement
$sql1 = "SELECT * FROM tpost LEFT JOIN teacher ON tpost.Teacher = teacher.TeacherID ORDER BY DateTime DESC;";

$res1 = mysqli_query($conn, $sql1);

while ($myrow1 = mysqli_fetch_array($res1)) {?>
						<tr>
							<td style="color: <?php if($myrow1['Showed'] == 1){ echo "purple";} else { echo "grey";}?>; text-align: left; padding-left: 10px;"><b><?php echo $myrow1['TPost']; ?></b></td>
							<td><?php echo $myrow1['Username']; ?><br><?php echo "Cik. ".$myrow1['Name']; ?></td>
							<td><?php echo $myrow1['DateTime']; ?></td>
							<td><a href="tcomment.php?tp=<?php echo $myrow1['TPostID']; ?>">View comments</a><br><?php if($myrow1['Showed'] == 1){?><a href="delete_tpost.php?tp=<?php echo $myrow1['TPostID']; ?>" onclick="return confirm('Do you confirm to delete the post?')">Delete</a><?php } else {?><a href="undelete_tpost.php?tp=<?php echo $myrow1['TPostID']; ?>">Undelete</a><?php }?></td>
<?php } ?>
						</tr>
      				</table>
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