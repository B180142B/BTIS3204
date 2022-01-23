<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true){
    header("location: ../index.php");
    exit;
}

if (!isset($_SESSION["user"]) || $_SESSION["user"] != 2) {
    header("location: ../index.php");
    exit;
}

// Include config file
require_once "../assets/db/config.php";

$id = $_SESSION['id'];

if (isset($_GET['class'])) {
    $class = $_GET['class'];
} else {
    header("location: homework.php");
}

// Prepare a select statement
$sql = "SELECT * FROM class WHERE ClassID = " . $class . " AND TeacherID = " .$id. ";";

$res = mysqli_query($conn, $sql);

$myrow = mysqli_fetch_assoc($res);

if ($myrow != true) {
    header("location: homework.php");
}

$class_name = $myrow['Tingkatan'] . $myrow['ClassName'];
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

    <title>Homework <?php echo $class_name;?></title>

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/list.css">
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
                            <li><a href="forum-list.php">Forum</a>
                                <ul class="dropdown">
                                    <li><a href="forum-list.php">Teacher Forum</a></li>
                                    <li><a href="../student/forum-list.php">Student Forum</a></li>
                            </li>
                                </ul>
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
                <h4 class="text-uppercase">Homework  <?php echo $class_name;?></h4>
            </div>
        </section>
        <!--page title end-->

        <!--body content start-->
        <section class="body-content">
            <div class="page-content">

                <div class="container mt-5">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center activity">
                                <div><h3><u>Assigned Homework</u></h3></div>
                                <div><a class="btn btn-small btn-theme-border-color" href="create-homework.php?class=<?php echo $class;?>"><h5>Add New Homework</h4></a></div>
                            </div>
                            <div class="mt-3">
                                <ul class="list list-inline">
                                    
<?php 
// Prepare a select statement
$sql = "SELECT * FROM homework WHERE Class = " . $class . " ORDER BY DateTimes ASC;";

$res = mysqli_query($conn, $sql);
while ($myrow = mysqli_fetch_array($res)) {?>

                                    <a href="homework-detail.php?h=<?php echo $myrow['HomeworkID']; ?>">
                                        <li class="d-flex justify-content-between">
                                            <div class="d-flex flex-row align-items-center">
                                                <div class="ml-2" style="padding: 20px;">
                                                    <h4 class="mb-0"><?php echo $myrow['HomeworkName'];?></h4>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center">
                                                <div class="d-flex flex-column mr-2" style="padding: 20px;">
                                                    <h3 class="date-time"><?php echo $myrow['DateTimes'] ." - ". $myrow['DueDate'];?></h3>
                                                </div>
                                            </div>
                                        </li>
                                    </a>
<?php }?>
                                </ul>
                            </div>
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

    <script>
        $(document).ready(function(){
            $("#grey-map").gMap({
                markers: [
                    {
                        latitude: 50.083,
                        longitude: 19.917,
                        html: '<div class="test_marker">marker 1</div>'

                    }
                ],
                zoom: 16,
                scrollwheel:false,
                styles: [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]
            })
        });
    </script>
</body>

</html>