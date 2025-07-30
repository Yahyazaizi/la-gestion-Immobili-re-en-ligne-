<?php 
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("config.php");
$error="";
$msg="";
if(isset($_POST['send']))
{
	$name=$_POST['name'];
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	$subject=$_POST['subject'];
	$message=$_POST['message'];
	
	if(!empty($name) && !empty($email) && !empty($phone) && !empty($subject) && !empty($message))
	{
		
		$sql="INSERT INTO contact (name,email,phone,subject,message) VALUES ('$name','$email','$phone','$subject','$message')";
		   $result=mysqli_query($con, $sql);
		   if($result){
			   $msg = "<p class='alert alert-success'>Message Send Successfully</p> ";
		   }
		   else{
			   $error = "<p class='alert alert-warning'>Message Not Send Successfully</p> ";
		   }
	}else{
		$error = "<p class='alert alert-warning'>Please Fill all the fields</p>";
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Meta Tags -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="images/favicon.ico">

<!--	Fonts
	========================================================-->
<link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

<!--	Css Link
	========================================================-->
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-slider.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="css/layerslider.css">
<link rel="stylesheet" type="text/css" href="css/color.css" id="color-change">
<link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/styledarkmode.css">
<!-- Dans le <head> de votre HTML -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
	/* Force l'affichage et le style */

button[name="send"] {
  display: block !important;
  background-color: #28a745 !important;
  color: white !important;
  padding: 0.5rem 1rem !important;
  border: none !important;
  border-radius: 0.25rem !important;
 
}

</style>
<style>
  /* Style par défaut : bouton plein largeur sur petits écrans */

  /* À partir de 768px (écrans moyens et plus) : bouton auto */
  @media (min-width: 768px) {
    .send-btn {
      width: auto;
    }
  }
</style>
<!--	Title
	=========================================================-->
<title>Real Estate PHP</title>
</head>
<body>

<!--	Page Loader
=============================================================
<div class="page-loader position-fixed z-index-9999 w-100 bg-white vh-100">
	<div class="d-flex justify-content-center y-middle position-relative">
	  <div class="spinner-border" role="status">
		<span class="sr-only">Loading...</span>
	  </div>
	</div>
</div>
--> 


    <div class="row"> 
        <!--	Header start  -->
		<?php include("include/header.php");?>
        <!--	Header end  -->
        
        <!--	Banner -->
        <!-- <div class="banner-full-row page-banner" style="background-image:url('images/breadcromb.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="page-name float-left text-white text-uppercase mt-1 mb-0"><b>Contact</b></h2>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="breadcrumb" class="float-left float-md-right">
                            <ol class="breadcrumb bg-transparent m-0 p-0">
                                <li class="breadcrumb-item text-white"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Contact</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div> -->
        <!--	Banner -->
		
        <!--	Contact Information -->
        <div class="full-row">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-5 bg-secondary">
                        <div class="contact-info">
                            <h3 class="mb-4 mt-4 text-white">Contacts</h3>
							
                            <ul>
                                <li class="d-flex mb-4"> <i class="fas fa-map-marker-alt text-white mr-2 font-13 mt-1"></i>
                                    <div class="contact-address">
                                        <h5 class="text-white">Address</h5>
                                        <span class="text-white">227 ingram street marrakech</span> <br>
										<span class="text-white">227 ingram street marrakech</span>
										</div>
                                </li>
                                <li class="d-flex mb-4"> <i class="fas fa-phone-alt text-white mr-2 font-13 mt-1"></i>
                                    <div class="contact-address">
                                        <h5 class="text-white">Call Us</h5>
                                        <span class="d-table text-white">+1 234-567-8910</span>
										<span class="text-white">+1 243-765-4321 </span>
									</div>
                                </li>
                                <li class="d-flex mb-4"> <i class="fas fa-envelope text-white mr-2 font-13 mt-1"></i>
                                    <div class="contact-address">
                                        <h5 class="text-white">Email Adderss</h5>
										<span class="d-table text-white">helpline@realestatest.com</span>
										<span class="text-white">helpline@realestatest.com</span>
										</div>
                                </li>
                            </ul>
                        </div>
                    </div>
					<div class="col-lg-1"></div>
                    <div class="col-md-12 col-lg-7">
						<div class="container">
                        <div class="row">
							<div class="col-lg-12">
								<h2 class="text-secondary double-down-line text-center mb-5">Get In Touch</h2>
								<?php echo $msg; ?><?php echo $error; ?>
							</div>
						</div>
					<div class="container">
  <form action="#" method="post">
    <div class="row g-3">
      <div class="col-12 col-md-6">
        <input type="text" name="name" class="form-control form-control-lg" placeholder="Your Name*" required>
      </div>
      <div class="col-12 col-md-6">
        <input type="email" name="email" class="form-control form-control-lg" placeholder="Email*" required>
      </div>
      <div class="col-12 col-md-6">
        <input type="tel" name="phone" class="form-control form-control-lg" placeholder="Phone" maxlength="10">
      </div>
      <div class="col-12 col-md-6">
        <input type="text" name="subject" class="form-control form-control-lg" placeholder="Subject">
      </div>
      <div class="col-12">
        <textarea name="message" class="form-control form-control-lg" rows="5" placeholder="Message"></textarea>
      </div>
      <div class="col-12 text-center mt-3">
  <div class="d-grid d-md-flex justify-content-md-center mt-4">
    <button type="submit" name="send" class="btn btn-success ">
      Send Message
    </button>
  </div>
</div>

      </div>
    </div>
  </form>
</div>
				</div>
					</div>
                </div>
            </div>
        </div>
        <!--	Contact Inforamtion -->
        
        <!--	Map -->
		<iframe 
  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3399.669103041482!2d-7.993583684838901!3d31.62594898133677!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xdafee8d96179e51%3A0x5950b6534f87adb8!2sJemaa%20el-Fnaa!5e0!3m2!1sen!2sma!4v1697130000000!5m2!1sen!2sma" 
  width="100%" 
  height="400" 
  style="border:0;" 
  allowfullscreen="" 
  loading="lazy" 
  referrerpolicy="no-referrer-when-downgrade">
</iframe>
		<!--	Map -->
        
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
<script src="js/jquery.cookie.js"></script> 
<script src="js/custom.js"></script>
<script type="text/javascript" src="include/dark.js" defer></script>
</body>
</html>