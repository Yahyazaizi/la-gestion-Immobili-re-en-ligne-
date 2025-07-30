<?php 
session_start();
include("config.php");

$error = "";
$msg = "";

if (isset($_REQUEST['login'])) {
    $email = $_REQUEST['email'];
    $pass = $_REQUEST['pass'];
    $pass = sha1($pass); // Secure the password using SHA1 (consider more secure hashing algorithms like bcrypt)

    if (!empty($email) && !empty($pass)) {
        
        // Check in the `user` table first
        $stmt = $con->prepare("SELECT * FROM user WHERE uemail = ? AND upass = ?");
        $stmt->bind_param("ss", $email, $pass);
        $stmt->execute();
        $userResult = $stmt->get_result();
        $userRow = $userResult->fetch_assoc();

        if ($userRow) {
            // User found in `user` table
            $_SESSION['uid'] = $userRow['uid'];
            $_SESSION['uemail'] = $email;
            header("Location: index.php"); // Redirect user to their dashboard
            exit();
        } else {
            // If not found in `user` table, check in `admin` table
            $stmt = $con->prepare("SELECT * FROM admin WHERE aemail = ? AND apass = ?");
            $stmt->bind_param("ss", $email, $pass);
            $stmt->execute();
            $adminResult = $stmt->get_result();
            $adminRow = $adminResult->fetch_assoc();

            if ($adminRow) {
                // Admin found in `admin` table
                $_SESSION['aid'] = $adminRow['aid'];
                $_SESSION['aemail'] = $email;
                header("Location: admin/dashboard.php"); // Redirect admin to the admin dashboard
                exit();
            } else {
                // No match found in either table
                $error = "<p class='alert alert-warning'>Email or Password does not match!</p>";
            }
        }

        // Close the statement
        $stmt->close();

    } else {
        $error = "<p class='alert alert-warning'>Please fill in all the fields!</p>";
    }
}

if (isset($_POST['login'])) {
    if (isset($_POST['user']) && isset($_POST['pass'])) {
        $user = $_POST['user']; // Use POST data instead of REQUEST
        $pass = $_POST['pass'];
        $pass = sha1($pass); // Hash the password with sha1 (though it's recommended to use a more secure algorithm like bcrypt)

        // Check if fields are not empty
        if (!empty($user) && !empty($pass)) {
            
            // Prepare the query to prevent SQL injection
            $stmt = $con->prepare("SELECT auser, apass FROM admin WHERE auser = ? AND apass = ?");
            $stmt->bind_param("ss", $user, $pass); // "ss" stands for two string parameters
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if the user is found
            if ($result->num_rows == 1) {
                $_SESSION['auser'] = $user; // Set session for the user
                header("Location: dashboard.php"); // Redirect to the dashboard
                exit(); // Ensure the script stops after the redirect
            } else {
                $error = '* Invalid Username or Password';
            }

            // Close the statement and connection
            $stmt->close();

        } else {
            $error = "* Please fill in all the fields!";
        }
    } else {
        $error = "* Please fill in all the fields!";
    }
}

if (isset($_POST['return'])) {
    header("Location:http://localhost/PHP/pfa/"); // Redirect to the main index page
    exit(); // Always call exit after a header redirect
}
?> 
<style>
	 @media (max-width: 576px) {
    .form-control, .btn {
        font-size: 14px;
    }
    /* Force l'affichage et le style */
button[name="login"] {
  display: block !important;
  background-color: #28a745 !important;
  color: white !important;
  padding: 0.5rem 1rem !important;
  border: none !important;
  border-radius: 0.25rem !important;
 
}
}
</style>


<!DOCTYPE html>
<html lang="en">

<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Meta Tags -->
<meta http-equiv="X-Compatible" content="IE=edge">
<link rel="shortcut icon" href="images/favicon.ico">

<!--	Fonts
	========================================================-->
<link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

<!--	Css Link
	========================================================-->
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-slider.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="css/layerslider.css">
<link rel="stylesheet" type="text/css" href="css/color.css">
<link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/login.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!--	Title
	=========================================================-->
<title>Real Estate PHP</title>
</head>
<body>

	<!-- Page Loader
============================================================= -->
<!-- <div class="page-loader position-fixed z-index-9999 w-100 bg-white vh-100">
	<div class="d-flex justify-content-center y-middle position-relative">
	  <div class="spinner-border" role="status">
		<span class="sr-only">Loading...</span>
	  </div>
	</div>
</div> -->
 


<!-- <div id="page-wrapper"> -->
    <div class="row"> 
        <!--	Header start  -->
		<?php include("include/header.php");?>
        <!--	Header end  -->
        
        <!--	Banner   --->
        <!-- <div class="banner-full-row page-banner" style="background-image:url('images/breadcromb.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="page-name float-left text-white text-uppercase mt-1 mb-0"><b>Login</b></h2>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="breadcrumb" class="float-left float-md-right">
                            <ol class="breadcrumb bg-transparent m-0 p-0">
                                <li class="breadcrumb-item text-white"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Login</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div> -->
         <!--	Banner   --->
		 
		 
		 
        <div class="page-wrappers login-body full-row  ">
            <div class="login-wrapper">
            	<div class="container">
                	<div class="loginbox">
                        <div class="login-right " id="login">
							<div class="login-right-wrap">
								<h1 class="text-success ">Login</h1>
								<p class="account-subtitle">Access to our dashboard</p>
								<?php echo $error; ?><?php echo $msg; ?>
								<!-- Form -->
								<form method="post">
    <div class="form-group">
        <input type="email" name="email" class="form-control" placeholder="Your Email*" required>
    </div>
    <div class="form-group">
        <input type="password" name="pass" class="form-control" placeholder="Your Password" required>
    </div>
    <div class="d-flex justify-content-center">
  <button class="btn btn-success" name="login"class="btn btn-success w-100 py-2" 
         
            style="background-color: #28a745; color: white;">Login</button>
</div>
</form>

								


								
								<div class="login-or">
									<span class="or-line"></span>
									<span class="span-or">or</span>
								</div>
							
								<!-- Social Login -->
								<!-- <div class="social-login">
									<span>Login with</span>
									<a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
									<a href="#" class="google"><i class="fab fa-google"></i></a>
									<a href="#" class="facebook"><i class="fab fa-twitter"></i></a>
									<a href="#" class="google"><i class="fab fa-instagram"></i></a>
								</div> -->
								<!-- /Social Login -->
								
								<div class="text-center dont-have">Don't have an account? <a href="register.php">Register</a></div>
								
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<!--	login  -->
        
        
        <!--	Footer   start-->
		<?php include("include/footer.php");?>
		<!--	Footer   start-->
        
        <!-- Scroll to top --> 
        <a href="#" class="bg-secondary text-white hover-text-secondary" id="scroll"><i class="fas fa-angle-up"></i></a> 
        <!-- End Scroll To top --> 
    </div>
</div>
<!-- Wrapper End --> 

<!--	Js Link
============================================================--> 
<script src="js/jquery.min.js"></script> 
<!--jQuery Layer Slider --> 
<script src="js/greensock.js"></script> 
<script src="js/layerslider.transitions.js"></script> 
<script src="js/layerslider.kreaturamedia.jquery.js"></script> 
<!--jQuery Layer Slider --> 
<script src="js/popper.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/owl.carousel.min.js"></script> 
<script src="js/tmpl.js"></script> 
<script src="js/jquery.dependClass-0.1.js"></script> 
<script src="js/draggable-0.1.js"></script> 
<script src="js/jquery.slider.js"></script> 
<script src="js/wow.js"></script> 
<script src="js/custom.js"></script>
<script type="text/javascript" src="include/dark.js" defer></script>
</body>
</html>