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

if (isset($_GET['post'])) {
	$post = $_GET['post'];
} else {
    header("location: forum-list.php");
}

// Prepare a select statement
$sql1 = "SELECT * FROM tpost LEFT JOIN Teacher ON tpost.Teacher = teacher.TeacherID WHERE TPostID = " .$post. " AND Showed = 1;";
$res1 = mysqli_query($conn, $sql1);
$myrow1 = mysqli_fetch_assoc($res1);

if ($myrow1 != true) {
    header("location: forum-list.php");
}

$i = 0;

// Prepare a select statement
$sql = "SELECT * FROM tcomment WHERE TPostID = " .$post. " AND Showed = 1;";
$res = mysqli_query($conn, $sql);
while ($myrow = mysqli_fetch_array($res)){
    $i++;
}

$total = ceil($i / 8);

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if ($page > $total) {
        header("location: forum-comment.php?post=".$post);
    }
} else {
    $page = 1;
}

$pagesize = $page * 8;
$offset = $pagesize - 8;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql = "INSERT INTO tcomment (TComment, TPostID, Teacher) VALUES (?, ?, ?);";
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "sss", $param_Comment, $param_PostID, $param_Uploader);
        $param_Comment = $_POST['comment'];
        $param_PostID = $post;
        $param_Uploader = $id;

        if(mysqli_stmt_execute($stmt)) {
            echo '<script>alert("Submitted new comment.")</script>';
            if ($total == 0) {
                header("location: forum-comment.php?post=".$post."&page=1");
            } else {
                header("location: forum-comment.php?post=".$post."&page=".$total);
            }
            
        } else {
            echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
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

    <title>Teacher Forum</title>

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
                            <li><a href="homework.php">Homework</a></li>
                            <li class="active"><a href="../teacher/forum-list.php">Forum</a>
                                <ul class="dropdown">
                                    <li><a href="../teacher/forum-list.php">Teacher Forum</a></li>
                                    <li><a href="forum-list.php">Student Forum</a></li>
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
                <h4 class="text-uppercase">Teacher Forum</h4>
            </div>
        </section>
        <!--page title end-->

        <!--body content start-->
        <section class="body-content">
            <div class="page-content" style="padding-bottom: 0px;">
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center activity">
                                <div><h1><?php echo $myrow1['TPost'];?></h1></div>
                                <div class="d-flex justify-content-between align-items-center activity" style="text-align: right;">
                                    <div><h5 style="color: grey; margin-top: 10px;">By <?php echo "Cik. ".$myrow1['Name'];?><br><?php echo $myrow1['DateTime'];?></h5></div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center activity" style="margin-bottom: 50px;">
                                <p style="font-size: 20px;"><?php echo $myrow1['Content'];?></p>
                            </div>
                            <div class="mt-3">
                                <ul class="list list-inline">
<?php 
// Prepare a select statement
$sql2 = "SELECT * FROM tcomment LEFT JOIN teacher ON tcomment.Teacher = teacher.TeacherID WHERE TPostID = " .$post. " AND Showed = 1 LIMIT ".$offset.", ".$pagesize.";";
$res2 = mysqli_query($conn, $sql2);
while ($myrow2 = mysqli_fetch_array($res2)) {?>

                                    <a disabled>
                                        <li class="d-flex justify-content-between">
                                            <div class="d-flex flex-row align-items-center">
                                                <div class="ml-2" style="padding: 20px;">
                                                    <h4 class="mb-0"><?php echo $myrow2['TComment'];?></h4>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-row align-items-center" style="text-align: right;">
                                                <div class="d-flex flex-column mr-2" style="padding: 20px;">
                                                    <h3 class="date-time">By <?php echo "Cik. ".$myrow2['Name'];?><br><?php echo $myrow2['DateTime'];?></h3>
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




<div class="container">

        <!--body content start-->
        <section class="ftco-section">
            
<?php if ($total < 11) {?>
            <!--pagination-->
            <div class="text-center page-content" style="padding-top: 0px; padding-bottom: 0px;">
                <ul class="pagination custom-pagination">
<?php
for ($i=1; $i <= $total; $i++) {
    if ($i == $page) {
?>
                    <li class="active"><a disabled><?php echo $i; ?></a></li>
<?php } else{?>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
<?php }}?>
                </ul>
            </div>
            <!--pagination-->

<?php } else {?>
            <!--pagination-->
            <div class="text-center page-content">
                <ul class="pagination custom-pagination">
<?php if ($page > 4 && $page < $total - 3) {?>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>">1</a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page - 2; ?>"><?php echo $page - 2;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page - 1; ?>"><?php echo $page - 1;?></a></li>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page + 1; ?>"><?php echo $page + 1;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page + 2; ?>"><?php echo $page + 2;?></a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $total; ?>"><?php echo $total; ?></a></li>
<?php } elseif ($page == 1) {?>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page + 1; ?>"><?php echo $page + 1;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page + 2; ?>"><?php echo $page + 2;?></a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $total; ?>"><?php echo $total; ?></a></li>
<?php } elseif ($page == 2) {?>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>">1</a></li>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page + 1; ?>"><?php echo $page + 1;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page + 2; ?>"><?php echo $page + 2;?></a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $total; ?>"><?php echo $total; ?></a></li>
<?php } elseif ($page == 3) {?>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page - 2; ?>"><?php echo $page - 2;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page - 1; ?>"><?php echo $page - 1;?></a></li>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page + 1; ?>"><?php echo $page + 1;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page + 2; ?>"><?php echo $page + 2;?></a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $total; ?>"><?php echo $total; ?></a></li>
<?php } elseif ($page == 4) {?>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page - 3; ?>"><?php echo $page - 3;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page - 2; ?>"><?php echo $page - 2;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page - 1; ?>"><?php echo $page - 1;?></a></li>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page + 1; ?>"><?php echo $page + 1;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page + 2; ?>"><?php echo $page + 2;?></a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $total; ?>"><?php echo $total; ?></a></li>
<?php } elseif ($page == $total) {?>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>">1</a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page - 2; ?>"><?php echo $page - 2;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page - 1; ?>"><?php echo $page - 1;?></a></li>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
<?php } elseif ($page == $total - 1) {?>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>">1</a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page - 2; ?>"><?php echo $page - 2;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page - 1; ?>"><?php echo $page - 1;?></a></li>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page + 1; ?>"><?php echo $page + 1;?></a></li>
<?php } elseif ($page == $total - 2) {?>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>">1</a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page - 2; ?>"><?php echo $page - 2;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page - 1; ?>"><?php echo $page - 1;?></a></li>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page + 1; ?>"><?php echo $page + 1;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page + 2; ?>"><?php echo $page + 2;?></a></li>
<?php } elseif ($page == $total - 3) {?>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>">1</a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page - 2; ?>"><?php echo $page - 2;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page - 1; ?>"><?php echo $page - 1;?></a></li>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page + 1; ?>"><?php echo $page + 1;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page + 2; ?>"><?php echo $page + 2;?></a></li>
                    <li><a href="forum-comment.php?post=<?php echo $post; ?>&page=<?php echo $page + 3; ?>"><?php echo $page + 3;?></a></li>
<?php }?>
                </ul>
            </div>
            <!--pagination-->
<?php }?>
            <div class="page-content" style="padding-top: 0px;">

                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="contact-comments" method="post">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="form-field-comments" style="font-size: 16px;">Leave your comment</label>
                                        <!-- Instruction -->
                                        <textarea name="comment" id="form-field-comments" class="cmnt-text form-control" required data-error="You must enter your Instructions" rows="8" maxlength="400" style="font-size: 16px;"></textarea>
                                    </div>

                                    <!-- Send Button -->
                                    <div class="form-group col-md-12" style="text-align: right; ">
                                        <button type="submit" class="btn btn-small btn-dark-solid" style="font-size: 16px; border: solid 2px;">Submit</button>
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