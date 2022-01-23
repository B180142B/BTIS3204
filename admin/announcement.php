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

// Prepare a select statement
$sql1 = "SELECT * FROM announcement ORDER BY DateTime DESC LIMIT 1";

$res1 = mysqli_query($conn, $sql1);

$myrow1 = mysqli_fetch_assoc($res1);

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql2 = "INSERT INTO announcement (Announcement, Admin) VALUES (?, ?);";
    if($stmt = mysqli_prepare($conn, $sql2)){
        mysqli_stmt_bind_param($stmt, "ss", $param_Announcement, $param_Admin);
        $param_Announcement = $_POST['announcement'];
        $param_Admin = $_SESSION["admin_id"];

        if(mysqli_stmt_execute($stmt)) {
            echo '<script>alert("Announcement Updated.")</script>';
            echo("<script>window.location = 'announcement.php';</script>");
        } else {
            echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Announcement</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style2.css">
    <style>
        .flex-container {
            display: flex;
            flex-wrap: nowrap;
            display: inline-flex;
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
            <div style="text-align: center;">
                <form method="post">
                    <div class="flex-container">
                        <h2 style="width: 1000px;">Announcement</h2>
                    </div>
                    <div class="flex-container">
                        <textarea name="announcement" class="flex-container2" style="width: 1000px; height: 300px; padding: 0;"><?php echo $myrow1['Announcement']; ?></textarea>
                    </div>
                    <br>
                    <div class="flex-container">
                        <input type="submit" class="flex-container2" style="width: 200px; height: auto; ">
                    </div>
                </form>
            </div>
          </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>