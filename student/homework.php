<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true){
    header("location: ../index.php");
    exit;
}

if (!isset($_SESSION["user"]) || $_SESSION["user"] != 1) {
    header("location: ../index.php");
    exit;
}

// Include config file
require_once "../assets/db/config.php";

$id = $_SESSION['id'];

// Prepare a select statement
$sql = "SELECT * FROM homework LEFT JOIN student ON homework.Class = student.Class LEFT JOIN homeworkdone ON student.StudentID = homeworkdone.StudentID AND homework.HomeworkID = homeworkdone.Homework WHERE student.StudentID = " .$id. ";";
$res = mysqli_query($conn, $sql);

// Prepare a select statement
$sql1 = "SELECT * FROM homeworkdone LEFT JOIN homework ON homework.HomeworkID = homeworkdone.Homework LEFT JOIN homeworkreturn ON homeworkreturn.HomeworkDoneID = homeworkdone.HomeworkDoneID WHERE StudentID = " .$id. ";";
$res1 = mysqli_query($conn, $sql1);

// Prepare a select statement
$sql2 = "SELECT * FROM homeworkreturn LEFT JOIN homeworkdone ON homeworkreturn.HomeworkDoneID = homeworkdone.HomeworkDoneID LEFT JOIN homework ON homework.HomeworkID = homeworkdone.Homework WHERE StudentID = " .$id. ";";
$res2 = mysqli_query($conn, $sql2);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">

    <!--favicon icon-->
    <link rel="icon" type="image/png" href="#">

    <title>Homework</title>

    <!--common style-->
    <link href='http://fonts.googleapis.com/css?family=Abel|Source+Sans+Pro:400,300,300italic,400italic,600,600italic,700,700italic,900,900italic,200italic,200' rel='stylesheet' type='text/css'>

    <!-- inject:css -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/animate/animate.css">
    <link rel="stylesheet" href="assets/vendor/elasic-slider/elastic.css">
    <link rel="stylesheet" href="assets/vendor/iconmoon/linea-icon.css">
    <link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="assets/vendor/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="assets/vendor/owl-carousel/owl.theme.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/shortcodes.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/default-theme.css">
    <!-- endinject -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="assets/vendor/backward/html5shiv.js"></script>
    <script src="assets/vendor/backward/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <!--  preloader start -->
    <div id="tb-preloader">
        <div class="tb-preloader-wave"></div>
    </div>
    <!-- preloader end -->


    <div class="wrapper">

       <!--header start-->
        <header class="l-header l-header_overlay">

            <div class="l-navbar l-navbar_expand l-navbar_t-light-trans js-navbar-sticky">
                <div class="container-fluid">
                    <nav class="menuzord js-primary-navigation" role="navigation" aria-label="Primary Navigation">

                        <!--mega menu start-->
                        <ul class="menuzord-menu menuzord-right c-nav_s-standard">
                            <li><a href="../homepage.php">Home</a></li>
                            <li><a href="notes.php">Notes</a></li>
                            <li class="active"><a href="homework.php">Homework</a></li>
                            <li><a href="forum-list.php">Forum</a></li>
                            <li><a href="../assets/db/logout.php">Log Out</a></li>
                        </ul>
                        <!--mega menu end-->

                    </nav>
                </div>
            </div>

        </header>
        <!--header end-->

        <!--page title start-->
        <section class="page-title">
            <div class="container">
                <h4 class="text-uppercase">Homework</h4>
            </div>
        </section>
        <!--page title end-->

        <!--body content start-->
        <section class="body-content ">


            <div class="page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-1">

                            <section class="normal-tabs line-tab">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#tab-assigned">Assigned</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#tab-submitted">Submitted</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#tab-returned">Returned</a>
                                    </li>

                                </ul>
                                <div class="panel-body">
                                    <div class="tab-content">
                                        <div id="tab-assigned" class="tab-pane active">
                                            <div class="login register ">
                                                <div class=" btn-rounded">
                                                    <h3>LIST OF ASSIGNED HOMEWORK</h3>
<?php

while ($myrow = mysqli_fetch_array($res)) {
    
    if ($myrow['HomeworkDoneID'] == null) {?>
        <a class="btn btn-medium btn-theme-border-color" href="homework-submit.php?h=<?php echo $myrow['HomeworkID']; ?>"><?php echo $myrow['HomeworkName']; ?></a>

<?php }}?>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="tab-submitted" class="tab-pane">
                                            <div class=" btn-rounded">
                                                    <h3>LIST OF SUBMITTED HOMEWORK</h3>
<?php

while ($myrow1 = mysqli_fetch_array($res1)){
    if ($myrow1['HomeworkReturnID'] == null) {?>
                                                    <a class="btn btn-medium btn-theme-border-color" href="homework-detail.php?h=<?php echo $myrow1['Homework']; ?>"><?php echo $myrow1['HomeworkName']; ?></a>
<?php }}?>
                                            </div>
                                        </div>
                                        <div id="tab-returned" class="tab-pane">
                                            <div class=" btn-rounded">
                                                    <h3>LIST OF RETURNED HOMEWORK</h3>
<?php

while ($myrow2 = mysqli_fetch_array($res2)){?>

                                                    <a class="btn btn-medium btn-theme-border-color" href="homework-return.php?h=<?php echo $myrow2['HomeworkReturnID']; ?>"><?php echo $myrow2['HomeworkName']; ?></a>
<?php }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--body content end-->
    </div>

    <script src="http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyBvoxNVNChCmTJqmmLFKEu_QyakDi5wOds"></script>
     <!-- inject:js -->
    <script src="assets/vendor/modernizr/modernizr.js"></script>
    <script src="assets/vendor/jquery/jquery-1.10.2.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/vendor/bootstrap-validator/validator.min.js"></script>
    <script src="assets/vendor/breakpoint/breakpoint.js"></script>
    <script src="assets/vendor/count-to/jquery.countTo.js"></script>
    <script src="assets/vendor/countdown/jquery.countdown.js"></script>
    <script src="assets/vendor/easing/jquery.easing.1.3.js"></script>
    <script src="assets/vendor/easy-pie-chart/jquery.easypiechart.min.js"></script>
    <script src="assets/vendor/elasic-slider/jquery.eislideshow.js"></script>
    <script src="assets/vendor/flex-slider/jquery.flexslider-min.js"></script>
    <script src="assets/vendor/gmap/jquery.gmap.min.js"></script>
    <script src="assets/vendor/images-loaded/imagesloaded.js"></script>
    <script src="assets/vendor/isotope/jquery.isotope.js"></script>
    <script src="assets/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="assets/vendor/mailchimp/jquery.ajaxchimp.min.js"></script>
    <script src="assets/vendor/menuzord/menuzord.js"></script>
    <script src="assets/vendor/nav/jquery.nav.js"></script>
    <script src="assets/vendor/owl-carousel/owl.carousel.min.js"></script>
    <script src="assets/vendor/parallax-js/parallax.min.js"></script>
    <script src="assets/vendor/smooth/smooth.js"></script>
    <script src="assets/vendor/sticky/jquery.sticky.min.js"></script>
    <script src="assets/vendor/touchspin/touchspin.js"></script>
    <script src="assets/vendor/typist/typist.js"></script>
    <script src="assets/vendor/visible/visible.js"></script>
    <script src="assets/vendor/wow/wow.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <!-- endinject -->
</body>

</html>