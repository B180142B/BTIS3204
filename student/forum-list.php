<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true){
    header("location: ../index.php");
    exit;
}

// Include config file
require_once "../assets/db/config.php";

$i = 0;

$sql1 = "SELECT * FROM post LEFT JOIN student ON post.Student = student.StudentID WHERE Showed = 1 ORDER BY `DateTime` DESC;";
$res1 = mysqli_query($conn, $sql1);
while ($myrow = mysqli_fetch_array($res1)){
    $i++;
}

$total = ceil($i / 15);

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    if ($page > $total) {
        header("location: forum-list.php");
    }
} else {
    $page = 1;
}

$pagesize = $page * 15;
$offset = $pagesize - 15;
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

    <title>Student Forum</title>

    <!--common style-->
    <link href='http://fonts.googleapis.com/css?family=Abel|Source+Sans+Pro:400,300,300italic,400italic,600,600italic,700,700italic,900,900italic,200italic,200' rel='stylesheet' type='text/css'>

    <!-- inject:css -->
    <link rel="stylesheet" href="../assets/css/table.css">
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
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    

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
                            
<?php if ($_SESSION["user"] == 2) {?>
                            <li><a href="../teacher/notes.php">Notes</a></li>
                            <li><a href="../teacher/homework.php">Homework</a></li>
                            <li class="active"><a href="../teacher/forum-list.php">Forum</a>
                                <ul class="dropdown">
                                    <li><a href="../teacher/forum-list.php">Teacher Forum</a></li>
                                    <li><a href="forum-list.php">Student Forum</a></li>
                            </li>
                                </ul>   
<?php } elseif($_SESSION["user"] == 1) { ?>
                            <li><a href="notes.php">Notes</a></li>
                            <li><a href="homework.php">Homework</a></li>
                            <li class="active"><a href="forum-list.php">Forum</a></li>
<?php } ?>
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
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-uppercase">Student Forum</h4>
                    </div>
                </div>
            </div>
        </section>
        <!--page title end-->

    </div>

    <div class="container">

        <!--body content start-->
        <section class="ftco-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- <div class="table-wrap"> -->
<?php if ($_SESSION["user"] == 1) {?>
                            <a href="forum.php" style="border: 1px solid; border-radius: 8px; padding: 5px;" class="pull-right">Add New Post</a>
<?php }?>
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Topic</th>
                                        <th>Uploaded on</th>
                                        <th>Author</th>
                                    </tr>
                                </thead>
                                <tbody>

<?php
// Prepare a select statement
$sql = "SELECT * FROM post LEFT JOIN student ON post.Student = student.StudentID WHERE Showed = 1 ORDER BY `DateTime` DESC LIMIT ".$offset.", ".$pagesize.";";
$res = mysqli_query($conn, $sql);
while ($myrow = mysqli_fetch_array($res)){
?>
                                    <tr class="alert" role="alert">
                                        <td><a href="forum-comment.php?post=<?php echo $myrow['PostID']; ?>" style="color: black;"><?php echo $myrow['Post'];?></a></td>
                                        <td><?php echo $myrow['DateTime'];?></td>
                                        <td><?php echo $myrow['Name'];?></td>
                                    </tr>
<?php }?>

                                </tbody>
                            </table>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
<?php if ($total < 11) {?>
            <!--pagination-->
            <div class="text-center page-content">
                <ul class="pagination custom-pagination">
<?php
for ($i=1; $i <= $total; $i++) {
    if ($i == $page) {
?>
                    <li class="active"><a disabled><?php echo $i; ?></a></li>
<?php } else{?>
                    <li><a href="forum-list.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
<?php }}?>
                </ul>
            </div>
            <!--pagination-->

<?php } else {?>
            <!--pagination-->
            <div class="text-center page-content">
                <ul class="pagination custom-pagination">
<?php if ($page > 4 && $page < $total - 3) {?>
                    <li><a href="forum-list.php">1</a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-list.php?page=<?php echo $page - 2; ?>"><?php echo $page - 2;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page - 1; ?>"><?php echo $page - 1;?></a></li>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page + 1; ?>"><?php echo $page + 1;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page + 2; ?>"><?php echo $page + 2;?></a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-list.php?page=<?php echo $total; ?>"><?php echo $total; ?></a></li>
<?php } elseif ($page == 1) {?>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page + 1; ?>"><?php echo $page + 1;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page + 2; ?>"><?php echo $page + 2;?></a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-list.php?page=<?php echo $total; ?>"><?php echo $total; ?></a></li>
<?php } elseif ($page == 2) {?>
                    <li><a href="forum-list.php">1</a></li>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page + 1; ?>"><?php echo $page + 1;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page + 2; ?>"><?php echo $page + 2;?></a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-list.php?page=<?php echo $total; ?>"><?php echo $total; ?></a></li>
<?php } elseif ($page == 3) {?>
                    <li><a href="forum-list.php?page=<?php echo $page - 2; ?>"><?php echo $page - 2;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page - 1; ?>"><?php echo $page - 1;?></a></li>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page + 1; ?>"><?php echo $page + 1;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page + 2; ?>"><?php echo $page + 2;?></a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-list.php?page=<?php echo $total; ?>"><?php echo $total; ?></a></li>
<?php } elseif ($page == 4) {?>
                    <li><a href="forum-list.php?page=<?php echo $page - 3; ?>"><?php echo $page - 3;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page - 2; ?>"><?php echo $page - 2;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page - 1; ?>"><?php echo $page - 1;?></a></li>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page + 1; ?>"><?php echo $page + 1;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page + 2; ?>"><?php echo $page + 2;?></a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-list.php?page=<?php echo $total; ?>"><?php echo $total; ?></a></li>
<?php } elseif ($page == $total) {?>
                    <li><a href="forum-list.php">1</a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-list.php?page=<?php echo $page - 2; ?>"><?php echo $page - 2;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page - 1; ?>"><?php echo $page - 1;?></a></li>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
<?php } elseif ($page == $total - 1) {?>
                    <li><a href="forum-list.php">1</a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-list.php?page=<?php echo $page - 2; ?>"><?php echo $page - 2;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page - 1; ?>"><?php echo $page - 1;?></a></li>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page + 1; ?>"><?php echo $page + 1;?></a></li>
<?php } elseif ($page == $total - 2) {?>
                    <li><a href="forum-list.php">1</a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-list.php?page=<?php echo $page - 2; ?>"><?php echo $page - 2;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page - 1; ?>"><?php echo $page - 1;?></a></li>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page + 1; ?>"><?php echo $page + 1;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page + 2; ?>"><?php echo $page + 2;?></a></li>
<?php } elseif ($page == $total - 3) {?>
                    <li><a href="forum-list.php">1</a></li>
                    <li><a disabled style="border: none;">...</a></li>
                    <li><a href="forum-list.php?page=<?php echo $page - 2; ?>"><?php echo $page - 2;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page - 1; ?>"><?php echo $page - 1;?></a></li>
                    <li class="active"><a disabled><?php echo $page;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page + 1; ?>"><?php echo $page + 1;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page + 2; ?>"><?php echo $page + 2;?></a></li>
                    <li><a href="forum-list.php?page=<?php echo $page + 3; ?>"><?php echo $page + 3;?></a></li>
<?php }?>
                </ul>
            </div>
            <!--pagination-->
<?php }?>

        </section>
        <!--body content end-->

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
