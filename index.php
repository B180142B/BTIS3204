<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: homepage.php");
    exit;
}

// Include config file
require_once "assets/db/config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
        
    if ($_POST['action'] == "login") {
        $username = trim($_POST["login-form-username"]);
        $password = trim($_POST["login-form-password"]);
 
        // Prepare a select statement
        $sql = "SELECT StudentID, Username, Password FROM student WHERE Username = ? AND Activated = '1'";

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
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username; 
                            $_SESSION["user"] = 1;
                            
                            // if remember me clicked . Values will be stored in $_COOKIE  array
                            if(!empty($_POST["remember"])) {
                                //COOKIES for username
                                setcookie ("user_login",$username,time()+ (10 * 365 * 24 * 60 * 60));
                                //COOKIES for password
                                setcookie ("userpassword",$password,time()+ (10 * 365 * 24 * 60 * 60));
                            } else {
                                if(isset($_COOKIE["user_login"])) {
                                    setcookie ("user_login","");
                                    if(isset($_COOKIE["userpassword"])) {
                                        setcookie ("userpassword","");
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
                } else {

                    // check teacher login
                    $sql = "SELECT TeacherID, Username, Password FROM teacher WHERE Username = ? AND Activated = '1'";
                    if($stmt = mysqli_prepare($conn, $sql)){
                        mysqli_stmt_bind_param($stmt, "s", $param_username);
                        if(mysqli_stmt_execute($stmt)){
                            mysqli_stmt_store_result($stmt);
                            if(mysqli_stmt_num_rows($stmt) == 1){
                                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                                if(mysqli_stmt_fetch($stmt)){
                                    if(password_verify($password, $hashed_password)){
                                        session_start();
                                        $_SESSION["loggedin"] = true;
                                        $_SESSION["id"] = $id;
                                        $_SESSION["username"] = $username; 
                                        $_SESSION["user"] = 2;
                                        // if remember me clicked . Values will be stored in $_COOKIE  array
                                        if(!empty($_POST["remember"])) {
                                            //COOKIES for username
                                            setcookie ("user_login",$username,time()+ (10 * 365 * 24 * 60 * 60));
                                            //COOKIES for password
                                            setcookie ("userpassword",$password,time()+ (10 * 365 * 24 * 60 * 60));
                                        } else {
                                            if(isset($_COOKIE["user_login"])) {
                                                setcookie ("user_login","");
                                                if(isset($_COOKIE["userpassword"])) {
                                                    setcookie ("userpassword","");
                                                }
                                            }
                                        }
                                        header("location: homepage.php");
                                    } else {
                                        echo '<script>alert("Invalid username or password.")</script>';
                                    }
                                } else {
                                    echo '<script>alert("Invalid username or password.")</script>';
                                }
                            } else {
                                echo '<script>alert("Invalid username or password.")</script>';
                            }
                        } else {
                            echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
                        }
                    }
                }
            } else {
                echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    } else if (($_POST['action'] == "register")) {
        // Validate username
        if(!preg_match('/^[a-zA-Z0-9]+$/', trim($_POST["register-username"]))) {
            $username_err = "Username can only contain letters and numbers.";
        } else {
            // Prepare a select statement
            if ($_POST["user"] == "Teacher") {
                $sql = "SELECT TeacherID FROM teacher WHERE Username = ?";
            } else {
                $sql = "SELECT StudentID FROM student WHERE Username = ?";
            }
            
            if($stmt = mysqli_prepare($conn, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                
                // Set parameters
                $param_username = trim($_POST["register-username"]);
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)) {
                    /* store result */
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) == 1) {
                        echo '<script>alert("This ID already registered.")</script>';
                        $username_err = "This ID already registered.";

                    } else {
                        $username = trim($_POST["register-username"]);
                    }
                } else {
                    echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
                    $username_err = "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }

        // Validate password
        if(strlen(trim($_POST["register-password"])) < 6) {
            $password_err = "Password must have atleast 6 characters.";
        } else {
            $password = trim($_POST["register-password"]);
        }

        // Validate confirm password

        $confirm_password = trim($_POST["confirm-password"]);
        if(empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
            echo '<script>alert("Password did not match.")</script>';
        }

        // Check input errors before inserting in database
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
            
            // Prepare an insert statement
            if ($_POST["user"] == "Teacher") {
                $sql = "INSERT INTO teacher (Username, Password, Name, Email, PhoneNo, ID_Card) VALUES (?, ?, ?, ?, ?, ?);";
            } else {
                $sql = "INSERT INTO student (Username, Password, Name, Email, PhoneNo, ID_Card) VALUES (?, ?, ?, ?, ?, ?);";
            }

            // upload ID card
            $imgname = $_FILES['id_card']['name'];
            $extension = pathinfo($imgname, PATHINFO_EXTENSION);
            $rename = 'upload'.date('Ymd').time();
            $newname = $rename.'.'.$extension;

            move_uploaded_file($_FILES['id_card']['tmp_name'], "id_card/".$newname);
            $id_card="id_card/".$newname;

            if($stmt = mysqli_prepare($conn, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssssss", $param_username, $param_password, $param_name, $param_email, $param_phoneNo, $param_id_card);
                
                // Set parameters
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                $param_name = trim($_POST["register-name"]);
                $param_email = trim($_POST["register-email"]);
                $param_phoneNo = trim($_POST["register-phone-number"]);
                $param_id_card = $id_card;

                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)) {
                    echo '<script>alert("Register successful. Please wait for admin verified.")</script>';
                } else {
                    echo '<script>alert("Oops! Something went wrong. Please try again later.")</script>';
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
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
    <link rel="icon" type="image/png" href="#">

    <title>Login | Asas Sains Komputer</title>

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
        <header class="l-header">

            <div class="l-navbar l-navbar_expand l-navbar_t-light js-navbar-sticky">
                <div class="container-fluid">
                    <nav class="menuzord js-primary-navigation" role="navigation" aria-label="Primary Navigation">

                        

                    </nav>
                </div>
            </div>

        </header>
        <!--header end-->

        <!--page title start-->
        <section class="page-title">
            <div class="container">
                <h4 class="text-uppercase"> Asas Sains Komputer </h4>   
            </div>
        </section>
        <!--page title end-->

        <!--body content start-->
        <section class="body-content ">


            <div class="page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">


                            <section class="normal-tabs line-tab">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#tab-login">Login</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#tab-register">Register</a>
                                    </li>

                                </ul>
                                <div class="panel-body">
                                    <div class="tab-content">
                                        <div id="tab-login" class="tab-pane active">
                                            <div class="login register ">
                                                <div class=" btn-rounded">
                                                    <form class="login" method="post">
                                                        <input type="hidden" name="action" value="login">
                                                        <div class="form-group">
                                                            <input type="text" name="login-form-username" value="<?php if(isset($_COOKIE["user_login"])) {echo $_COOKIE['user_login'];} ?>" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" placeholder="Login ID" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="password" name="login-form-password" value="<?php if(isset($_COOKIE["userpassword"])) {echo $_COOKIE['userpassword'];} ?>" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <button class="btn btn-small btn-dark-solid full-width" value="login">Login</button>
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="hidden" name="user">
                                                            <input type="checkbox" name="remember" id="remember" checked ="checked">
                                                            <label for="remember">Remember me</label>
                                                            <a class="pull-right" href="forgot.php"> Forgot Password?</a>
                                                            <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>
                                                        </div>

                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                        <div id="tab-register" class="tab-pane">
                                            <form class="register" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="action" value="register">

                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Student ID/Teacher ID" name="register-username" required>
                                                </div>

                                                <div class="form-group">
                                                    <input type="password" class="form-control" placeholder="Password" name="register-password" required>
                                                </div>

                                                <div class="form-group">
                                                    <input type="password" class="form-control" placeholder="Confirm Password" name="confirm-password" required>
                                                </div>

                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Name" name="register-name" required>
                                                </div>

                                                <div class="form-group">
                                                    <input type="email" class="form-control" placeholder="Email" name="register-email" required>
                                                </div>

                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Phone Number" name="register-phone-number" required>
                                                </div>

                                                <div class="form-group">
                                                    <p>    Please upload your ID card.</p>
                                                    <input type="file" class="form-control" name="id_card" required>
                                                </div>

                                                <div class="form-group">
                                                    <input type="radio" name="user" value="Teacher">
                                                    <label>Teacher</label>
                                                    <input type="radio" name="user" value="Student" style="margin-left: 15px;" checked ="checked">
                                                    <label>Student</label>
                                                </div>

                                                <div class="form-group">
                                                    <button class="btn btn-small btn-dark-solid full-width " id="login-form-submit" name="login-form-submit" value="login">Register
                                                    </button>
                                                </div>

                                            </form>
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