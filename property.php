<?php 
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("config.php");
///code								
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Meta Tags -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Real Estate PHP">
<meta name="keywords" content="">
<meta name="author" content="Unicoder">
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
<link rel="stylesheet" type="text/css" href="css/color.css" id="color-change">
<link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/styledarkmode.css">

<!--	Title
	=========================================================-->
<title>Real Estate PHP</title>
<style>
    .fab.fa-whatsapp {
        font-size: 1.2em;
        vertical-align: middle;
    }
    .whatsapp-btn {
        display: block;
        margin: 10px auto 0;
        text-align: center;
        width: 90%;
    }
</style>
</head>
<body>

<div class="row"> 
    <!-- Header start -->
    <?php include("include/header.php");?>
    <!-- Header end -->
    
    <!-- Banner -->
    <div class="banner-full-row page-banner" style="background-image:url('images/breadcromb.jpg');">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="page-name float-left text-white text-uppercase mt-1 mb-0"><b>Property Grid</b></h2>
                </div>
                <div class="col-md-6">
                    <nav aria-label="breadcrumb" class="float-left float-md-right">
                        <ol class="breadcrumb bg-transparent m-0 p-0">
                            <li class="breadcrumb-item text-white"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Property Grid</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner end -->
    
    <div class="container m-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <?php 
                    $query=mysqli_query($con,"SELECT property.*, user.uname, user.utype, user.uimage ,user.uphone
                                             FROM `property`,`user` 
                                             WHERE property.uid=user.uid");
                    while($row=mysqli_fetch_array($query)) {
                    ?>
                    <div class="col-md-6">
                        <div class="featured-thumb hover-zoomer mb-4">
                            <div class="overlay-black overflow-hidden position-relative"> 
                                <img src="admin/property/<?php echo $row['18'];?>" alt="pimage">
                                <div class="sale bg-success text-white">For <?php echo $row['5'];?></div>
                                <div class="price text-primary text-capitalize">$<?php echo $row['13'];?> <span class="text-white"><?php echo $row['12'];?> Sqft</span></div>
                            </div>
                            <div class="featured-thumb-data shadow-one">
                                <div class="p-4">
                                    <h5 class="text-secondary hover-text-success mb-2 text-capitalize">
                                        <a href="propertydetail.php?pid=<?php echo $row['0'];?>"><?php echo $row['1'];?></a>
                                    </h5>
                                    <span class="location text-capitalize">
                                        <i class="fas fa-map-marker-alt text-success"></i> <?php echo $row['14'];?>
                                    </span> 
                                </div>
                                <div class="px-4 pb-2 d-inline-block w-100">
                                    <div class="float-left text-capitalize">
                                        <i class="fas fa-user text-success mr-1"></i>By : <?php echo $row['uname'];?>
                                    </div>
                                     <div class="float-left text-capitalize">
                                       <i class="fas fa-phone text-success mr-1"></i>Tel : <?php echo ($row['uphone']); ?>
                                    </div>
                                    <div class="float-right">
                                        <i class="far fa-calendar-alt text-success mr-1"></i> <?php echo date('d-m-Y', strtotime($row['date']));?>
                                    </div>
                                </div>
                                <!-- Bouton WhatsApp avec numéro fixe -->
                               <?php
    // Nettoyer le numéro de téléphone (enlever les espaces, tirets, etc.)
    $cleanPhone = preg_replace('/\D/', '', $row['uphone']);

    // Préparer le message WhatsApp
    $message = "Je suis intéressé par votre propriété " . $row['1'] .
               "  à " . $row['14'] .
               " pour " . $row['5'] . " au prix de $" . $row['13'];

    $waLink = "https://wa.me/212" . $cleanPhone . "?text=" . urlencode($message);
?>
<a href="<?php echo $waLink; ?>" 
   class="btn btn-success btn-sm whatsapp-btn" 
   target="_blank">
   <i class="fab fa-whatsapp"></i> Contacter sur WhatsApp
</a>

                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="sidebar-widget">
                    <h4 class="double-down-line-left text-secondary position-relative pb-4 my-4">Instalment Calculator</h4>
                    <form class="d-inline-block w-100" action="calc.php" method="post">
                        <label class="sr-only">Property Amount</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">$</div>
                            </div>
                            <input type="text" class="form-control" name="amount" placeholder="Property Price" required>
                        </div>
                        <label class="sr-only">Month</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                            <input type="text" class="form-control" name="month" placeholder="month" required>
                        </div>
                        <label class="sr-only">Interest Rate</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">%</div>
                            </div>
                            <input type="text" class="form-control" name="interest" placeholder="Interest Rate" required>
                        </div>
                        <button type="submit" value="submit" name="calc" class="btn btn-danger mt-4">Calculate Instalment</button>
                    </form>
                </div>

                <h4 class="double-down-line-left text-secondary position-relative pb-4 mb-4 mt-5">Featured Property</h4>
                <ul class="property_list_widget">
                    <?php 
                    $query=mysqli_query($con,"SELECT * FROM `property` WHERE isFeatured = 1 ORDER BY date DESC LIMIT 3");
                    while($row=mysqli_fetch_array($query)) {
                    ?>
                    <li> 
                        <img src="admin/property/<?php echo $row['18'];?>" alt="pimage">
                        <h6 class="text-secondary hover-text-success text-capitalize">
                            <a href="propertydetail.php?pid=<?php echo $row['0'];?>"><?php echo $row['1'];?></a>
                        </h6>
                        <span class="font-14">
                            <i class="fas fa-map-marker-alt icon-success icon-small"></i> <?php echo $row['14'];?>
                        </span>
                    </li>
                    <?php } ?>
                </ul>
                
                <div class="sidebar-widget mt-5">
                    <h4 class="double-down-line-left text-secondary position-relative pb-4 mb-4">Recently Added Property</h4>
                    <ul class="property_list_widget">
                        <?php 
                        $query=mysqli_query($con,"SELECT * FROM `property` ORDER BY date DESC LIMIT 6");
                        while($row=mysqli_fetch_array($query)) {
                        ?>
                        <li> 
                            <img src="admin/property/<?php echo $row['18'];?>" alt="pimage">
                            <h6 class="text-secondary hover-text-success text-capitalize">
                                <a href="propertydetail.php?pid=<?php echo $row['0'];?>"><?php echo $row['1'];?></a>
                            </h6>
                            <span class="font-14">
                                <i class="fas fa-map-marker-alt icon-success icon-small"></i> <?php echo $row['14'];?>
                            </span>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include("include/footer.php");?>
<!-- Footer end -->

<!-- Wrapper End --> 
<!-- Js Link -->
<script src="js/jquery.min.js"></script> 
<script src="js/greensock.js"></script> 
<script src="js/layerslider.transitions.js"></script> 
<script src="js/layerslider.kreaturamedia.jquery.js"></script> 
<script src="js/popper.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/owl.carousel.min.js"></script> 
<script src="js/tmpl.js"></script> 
<script src="js/jquery.dependClass-0.1.js"></script> 
<script src="js/draggable-0.1.js"></script> 
<script src="js/jquery.slider.js"></script> 
<script src="js/wow.js"></script> 
<script src="js/custom.js"></script>
<script type="text/javascript" src="dark.js" defer></script>
</body>
</html>