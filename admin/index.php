<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["admin_loggedin"]) && $_SESSION["admin_loggedin"] === true){
    header("location: homepage.php");
    exit;
}

// Include config file
require_once "../assets/db/config.php";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
        
    $username = trim($_POST["login-form-username"]);
    $password = trim($_POST["login-form-password"]);

    // Prepare a select statement
    $sql = "SELECT AdminID, Username, Password FROM admin WHERE Username = ?;";

    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_username);

        // Set parameters
        $param_username = $username;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Store result
            mysqli_stmt_store_result($stmt);
            
            // Check if username exists, if yes then verify password
            if(mysqli_stmt_num_rows($stmt) == 1){
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if(mysqli_stmt_fetch($stmt)){
                    // echo password_hash($password, PASSWORD_DEFAULT);
                    if(password_verify($password, $hashed_password)){
                        // Password is correct, so start a new session
                        session_start();
                        
                        // Store data in session variables
                        $_SESSION["admin_loggedin"] = true;
                        $_SESSION["admin_id"] = $id;
                        $_SESSION["admin_username"] = $username; 
                        
                        // if remember me clicked . Values will be stored in $_COOKIE  array
                        if(!empty($_POST["remember"])) {
                            //COOKIES for username
                            setcookie ("admin_login",$username,time()+ (10 * 365 * 24 * 60 * 60));
                            //COOKIES for password
                            setcookie ("admin_password",$password,time()+ (10 * 365 * 24 * 60 * 60));
                        } else {
                            if(isset($_COOKIE["admin_login"])) {
                                setcookie ("admin_login","");
                                if(isset($_COOKIE["admin_password"])) {
                                    setcookie ("admin_password","");
                                }
                            }
                        }

                        // Redirect user to welcome page
                        header("location: homepage.php");
                    } else {
                        // Password is not valid, display a generic error message
                        echo '<script>alert("Invalid username or password.")</script>';
                    }
                }
            }
        } else {
            echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
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
    <link rel="icon" type="image/png" href="">

    <title>Login Admin</title>

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

    <div class="login login-bg login-parallax">

        <div class="container">
            <div class="login-logo text-center">
                
            </div>
            <div class="login-box btn-rounded">
                <form id="login-form" name="login-form" method="post">
                    <div class="text-center">
                        <h3>LOGIN</h3>
                    </div>

                    <div class="form-group">
                        <input type="text" name="login-form-username" value="<?php if(isset($_COOKIE["admin_login"])) {echo $_COOKIE['admin_login'];} ?>" class="form-control" placeholder="Admin ID" required>
                    </div>

                    <div class="form-group">
                        <input type="password" name="login-form-password" value="<?php if(isset($_COOKIE["admin_password"])) {echo $_COOKIE['admin_password'];} ?>" class="form-control" placeholder="Password" required>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-small btn-dark-solid full-width btn-rounded" id="login-form-submit" name="login-form-submit" value="login">Login</button>
                    </div>

                    <div class="form-group">
                        <input type="checkbox" name="remember" id="remember" checked ="checked">
                        <label for="checkbox1">Remember me</label>
                    </div>
                </form>
            </div>
        </div>

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