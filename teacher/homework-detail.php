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

if (isset($_GET['h'])) {
    $homeworkID = $_GET['h'];
} else {
    header("location: homework.php");
}

// Prepare a select statement
$sql = "SELECT * FROM homework LEFT JOIN class ON homework.Class = class.ClassID WHERE HomeworkID = ".$homeworkID." AND TeacherID = ".$id.";";

$res = mysqli_query($conn, $sql);

$myrow = mysqli_fetch_assoc($res);

$class_name = $myrow['Tingkatan'] . $myrow['ClassName'];

if ($myrow != true) {
    header("location: homework.php");
}
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

    <title>Homework Detail</title>

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
                <h4 class="text-uppercase">Homework <?php echo $class_name;?></h4>
            </div>
        </section>
        <!--page title end-->

        <!--body content start-->
        <section class="body-content">
            <div class="page-content">

                <div class="container">
                    <div class="row">

                        <a href="homework-list.php?class=<?php echo $myrow['ClassID']; ?>"><< Back to class <?php echo $class_name; ?></a><br><br>
                        <div class="col-md-8">
                            <h4 class="text-uppercase"><strong><?php echo $myrow['HomeworkName']; ?></strong></h4>

                            <form class="contact-comments m-top-50" method="post" enctype="multipart/form-data">
                                <div class="row">

                                    <div class="col-md-6 form-group">
                                        <label for="form-field-name">Assigned date & time</label>
                                        <!-- Title -->
                                        <p><?php echo $myrow['DateTimes'];?></p>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label for="form-field-name">Due Date & Time</label>
                                        <!-- Due Date -->
                                        <p><?php echo $myrow['DueDate'];?></p>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="form-field-comments">Instructions</label>
                                        <!-- Instruction -->
                                        <textarea name="instruction" id="form-field-comments" class="cmnt-text form-control" disabled><?php echo $myrow['Instruction'];?></textarea>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="form-field-name">Attachment</label>
                                        <!-- File --><br>
                                        <a href="<?php echo $myrow['Attachment'];?>" style="color: gray; border: 1px solid; border-radius: 8px; padding: 5px;" target="_blank"><?php echo basename($myrow['Attachment']); ?></a>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="col-md-12 form-group">
                                        <label for="form-field-name">Submission</label>
                                        <br>
<?php
// Prepare a select statement
$sql1 = "SELECT * FROM homeworkdone LEFT JOIN student ON homeworkdone.StudentID = student.StudentID WHERE Homework = ".$homeworkID." ORDER BY Username ASC;";

$res1 = mysqli_query($conn, $sql1);

while ($myrow1 = mysqli_fetch_array($res1)){
?>
                                        <a href="homework-return.php?h=<?php echo $homeworkID;?>&s=<?php echo $myrow1['StudentID']; ?>" target="_blank">
                                            <div style="border: 2px solid; border-radius: 12px; padding-left: 15px; margin-bottom: 10px;">
                                                <div style="height: 30px;">
                                                    <h4 class="mb-0"><?php echo $myrow1['Username']."\t".$myrow1['Name'];?></h4>
                                                </div>
                                            </div>
                                        </a>
<?php }?>
                                    </div>
                                </div>
                            </form>
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