<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true){
    header("location: index.php");
    exit;
}

// Include config file
require_once "assets/db/config.php";

$link = "";

if ($_SESSION["user"] == 2) {
    $link = "teacher/";
} elseif($_SESSION["user"] == 1) {
    $link = "student/";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="corporate, creative, general, portfolio, photography, blog, e-commerce, shop, product, gallery, retina, responsive">
    <meta name="author" content="Mosaddek">

    <!--favicon icon-->
    <link rel="icon" type="image/png" href="#">

    <title>Homepage</title>

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
    <link rel="stylesheet" href="teacher/assets/css/list.css">
    <!-- endinject -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="assets/vendor/backward/html5shiv.js"></script>
    <script src="assets/vendor/backward/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!-- preloader start -->
    <div id="tb-preloader">
        <div class="tb-preloader-wave"></div>
    </div>
    <!-- preloader end -->

    <div class="wrapper">

        <!--header start-->
        <header class="l-header l-header_overlay">

            <div class="l-navbar l-navbar_expand l-navbar_t-light-trans js-navbar-sticky">
<!--                 <div class="container-fluid">
                    <nav class="menuzord js-primary-navigation" role="navigation" aria-label="Primary Navigation">
 -->
                        <!--mega menu start-->
                        <ul class="menuzord-menu menuzord-right c-nav_s-standard">
                            <li class="active"><a href="homepage.php">Home</a></li>
                            <li><a href="<?php echo $link ?>notes.php">Notes</a></li>
                            <li><a href="<?php echo $link ?>homework.php">Homework</a></li>
<?php if ($_SESSION["user"] == 2) {?>
                            <li><a href="teacher/forum-list.php">Forum</a>
                                <ul class="dropdown">
                                    <li><a href="teacher/forum-list.php">Teacher Forum</a></li>
                                    <li><a href="student/forum-list.php">Student Forum</a></li>
                            </li>
                                </ul>   
<?php } elseif($_SESSION["user"] == 1) { ?>
                            <li><a href="student/forum-list.php">Forum</a></li>
<?php } ?>
                            <li><a href="assets/db/logout.php">Log Out</a></li>
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
                <h4 class="text-uppercase">Past Announcements</h4>
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
                                <div><h3>Past Announcements</h3></div>
                            </div>
                            <div class="mt-3">
                                <ul class="list list-inline">

<?php 
// Prepare a select statement
$sql = "SELECT * FROM announcement ORDER BY DateTime DESC;";

$res = mysqli_query($conn, $sql);

$i = 0;
while ($myrow = mysqli_fetch_array($res)) {
$i++;?>
                                        <li class="d-flex justify-content-between">
                                            <div class="d-flex flex-row align-items-center">
                                                <div class="ml-2" style="padding: 20px;">
                                                    <h4 class="mb-0"><?php echo $i.". ".$myrow['Announcement'];?></h4>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center">
                                                <div class="d-flex flex-column mr-2" style="padding: 20px; min-width: 120px;">
                                                    <h3 class="date-time" style="text-align: center;"><?php echo $myrow['DateTime'];?></h3>
                                                </div>
                                            </div>
                                        </li>
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
</body>

</html>