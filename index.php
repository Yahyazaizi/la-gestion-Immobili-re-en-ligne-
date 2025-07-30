<?php 
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("config.php");
								
?>


<!-- CSS personnalisé -->
<style>
    .property-btn .nav-link {
        font-weight: bold;
        color: black;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .property-btn .nav-link.active {
        background-color: #28a745;
        color: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .property-btn .nav-link:hover {
        background-color:#28a745;
        color: white;
    }
</style>
 <style>
        .full-row {
            padding: 3rem 0;
          
        }

        .testimonial-section h4 {
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 2rem;
            position: relative;
        }

        .testimonial-section h4::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #28a745, #20c997);
            border-radius: 2px;
        }

        #testimonialCarousel {
            position: relative;
            min-height: 200px;
            overflow: hidden;
        }

        .testimonial-slide {
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            position: absolute;
            width: 100%;
            top: 0;
            left: 0;
        }

        .testimonial-slide.active {
            opacity: 1;
            transform: translateX(0);
            position: relative;
        }

        .testimonial-bubble {
            background: linear-gradient(135deg, #28a745 0%, #34ce57 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            position: relative;
            margin-bottom: 1rem;
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        }

        .testimonial-bubble::before {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 30px;
            width: 0;
            height: 0;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
            border-top: 15px solid #28a745;
        }

        .quote-left {
            font-size: 1.5rem;
            opacity: 0.8;
            margin-right: 0.5rem;
        }

        .quote-right {
            font-size: 1.5rem;
            opacity: 0.8;
            margin-left: 0.5rem;
        }

        .testimonial-text {
            font-size: 1.1rem;
            line-height: 1.6;
            margin: 0;
            display: inline;
        }

        .testimonial-author {
            margin-left: 30px;
            margin-top: 0.5rem;
        }

        .author-name {
            color: #28a745;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .author-type {
            color: #888;
            font-size: 0.95rem;
        }

        .carousel-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .carousel-btn {
            width: 45px;
            height: 45px;
            border: 2px solid #28a745;
            background: white;
            color: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .carousel-btn:hover {
            background: #28a745;
            color: white;
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
        }

        .carousel-indicators {
            display: flex;
            gap: 0.5rem;
            margin: 0 1rem;
        }

        .indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #dee2e6;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .indicator.active {
            background: #28a745;
            transform: scale(1.3);
        }

        .indicator:hover {
            background: #20c997;
        }

        .pause-play-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            color: #28a745;
        }

        .pause-play-btn:hover {
            background: white;
            transform: scale(1.1);
        }

        .progress-bar-container {
            width: 100%;
            height: 4px;
            background: rgba(40, 167, 69, 0.2);
            border-radius: 2px;
            margin-top: 1.5rem;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #28a745, #20c997);
            border-radius: 2px;
            transition: width 0.1s linear;
            width: 0%;
        }

        .no-testimonials {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 2rem;
        }

        @media (max-width: 768px) {
            .testimonial-bubble {
                padding: 1.5rem;
            }
            
            .carousel-btn,.btn-success {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            
            .full-row {
                padding: 2rem 0;
            }
              
        }


/* Mobile : Écrans ≤ 730px */

            
    </style>
<!DOCTYPE html>
<html lang="en" >

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Required meta tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Meta Tags -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="images/favicon.ico">


<!-- CSS personnalisé -->
<style>
    .property-btn .nav-link {
        font-weight: bold;
        color: black;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .property-btn .nav-link.active {
        background-color: #28a745;
        color: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .property-btn .nav-link:hover {
        background-color:#28a745;
        color: white;
    }
    @media (max-width: 576px) {
    .form-control, .btn {
        font-size: 14px;
    }
    /* Force l'affichage et le style */
button[name="filter"] {
  display: block !important;
  background-color: #28a745 !important;
  color: white !important;
  padding: 0.5rem 1rem !important;
  border: none !important;
  border-radius: 0.25rem !important;
}
}
</style>

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
<!-- Dans le <head> de votre HTML -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!--	Title
	=========================================================-->
<title>Real Estate PHP</title>
</head>
<body >

<!--	Page Loader  -->
<!--<div class="page-loader position-fixed z-index-9999 w-100 bg-white vh-100">
	<div class="d-flex justify-content-center y-middle position-relative">
	  <div class="spinner-border" role="status">
		<span class="sr-only">Loading...</span>
	  </div>
	</div>
</div>  -->
<!--	Page Loader  -->


    <div class="row"> 
        <!--	Header start  -->
            
		<?php include("include/header.php");?>
        
        <!--	Header end  -->
		
        <!--	Banner Start   -->
        <!-- <div class="overlay-black w-100 slider-banner1 position-relative" style="background-image: url('images/banner/imga.jpeg'); background-size: cover; background-position: center center; background-repeat: no-repeat;"> -->
        <div class="overlay-black w-100 slider-banner1 position-relative">
        <video  id="background-video" autoplay muted playsinline class="w-100 h-100 position-absolute" style="object-fit: cover;">
    <source src="images/video1.mp4" type="video/mp4">
</video>
<script>
    const video = document.getElementById('background-video');
    video.addEventListener('ended', () => {
        setTimeout(() => {
            video.play();
        }, 100); // Ajoute un délai de 5 secondes après chaque boucle
    });
</script>

        <div class="container h-100">
    <div class="row h-100 align-items-center">
        <div class="col-12">
            <div class="text-white">
                <h1 class="mb-4"><span class="text-success">Let us</span><br>Guide you Home</h1>
                <form method="post" action="propertygrid.php">
                    <!-- Ligne réorganisée pour mobile -->
                    <div class="row g-3">
                        <!-- Type - 2 colonnes en mobile, 2 en tablette, 2 en desktop -->
                        <div class="col-6 col-md-6 col-lg-2">
                            <div class="form-group">
                                <select class="form-control" name="type">
                                    <option value="">Select Type</option>
                                    <option value="apartment">Apartment</option>
                                    <option value="flat">Flat</option>
                                    <option value="building">Building</option>
                                    <option value="house">House</option>
                                    <option value="villa">Villa</option>
                                    <option value="office">Office</option>
                                </select>
                            </div>
                        </div>

                        <!-- Status - 2 colonnes en mobile, 2 en tablette, 2 en desktop -->
                        <div class="col-6 col-md-6 col-lg-2">
                            <div class="form-group">
                                <select class="form-control" name="stype">
                                    <option value="">Select Status</option>
                                    <option value="rent">Rent</option>
                                    <option value="sale">Sale</option>
                                </select>
                            </div>
                        </div>

                        <!-- City - Pleine largeur en mobile, 8 colonnes en tablette, 5 en desktop -->
                        <div class="col-12 col-md-8 col-lg-5">
                            <div class="form-group">
                                <input type="text" class="form-control" name="city" placeholder="Enter City" required>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-3">
  <div class="form-group" style="overflow: visible;">
    <button type="submit" name="filter" 
            class="btn btn-success w-100 py-2"
            style="background-color: #28a745; color: white;">
      Search Property
    </button>
  </div>
</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        <!--	Banner End  -->
        
        <!--	Text Block One
		======================================================-->
        <div class="full-row" class="dark">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="text-secondary double-down-line text-center mb-5">What We Do</h2></div>
                </div>
                <div class="text-box-one">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="p-4 text-center  hover-shadow rounded mb-4 transation-3s"> 
								<i class="flaticon-rent text-success flat-medium" aria-hidden="true"></i>
                                <h5 class="text-secondary hover-text-success py-3 m-0"><a href="#">Selling Service</a></h5>
                                <p>This is a dummy text for filling out spaces. Just some random words...</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="p-4 text-center  hover-shadow rounded mb-4 transation-3s"> 
								<i class="flaticon-for-rent text-success flat-medium" aria-hidden="true"></i>
                                <h5 class="text-secondary hover-text-success py-3 m-0"><a href="#">Rental Service</a></h5>
                                <p>This is a dummy text for filling out spaces. Just some random words...</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="p-4 text-center  hover-shadow rounded mb-4 transation-3s"> 
								<i class="flaticon-list text-success flat-medium" aria-hidden="true"></i>
                                <h5 class="text-secondary hover-text-success py-3 m-0"><a href="#">Property Listing</a></h5>
                                <p>This is a dummy text for filling out spaces. Just some random words...</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="p-4 text-center  hover-shadow rounded mb-4 transation-3s"> 
								<i class="flaticon-diagram text-success flat-medium" aria-hidden="true"></i>
                                <h5 class="text-secondary hover-text-success py-3 m-0"><a href="#">Legal Investment</a></h5>
                                <p>This is a dummy text for filling out spaces. Just some random words...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-----  Our Services  ---->
		
        <!--	Recent Properties  -->
        <div class="full-row">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class=" double-down-line text-center mb-4">Recent Property</h2>
                    </div>
                    <div class="col-md-6 align-self-center">
                        <ul class="nav property-btn " id="pills-tab" role="tablist">
                            <li class="nav-item"> <a class="nav-link py-3 active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">New</a> </li>
                            <li class="nav-item"> <a class="nav-link py-3" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Featured</a> </li>
                            <li class="nav-item"> <a class="nav-link py-3" id="pills-contact-tab2" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">sale</a> </li>
                            <li class="nav-item"> <a class="nav-link py-3" id="pills-contact-tab3" data-toggle="pill" href="#pills-resturant" role="tab" aria-controls="pills-contact" aria-selected="false"> rent</a> </li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="tab-content mt-4" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home">
                                <div class="row">
								
									<?php $query=mysqli_query($con,"SELECT property.*, user.uname,user.utype,user.uimage FROM `property`,`user` WHERE property.uid=user.uid ORDER BY date DESC LIMIT 9");
										while($row=mysqli_fetch_array($query))
										{
									?>
								
                                    <div class="col-md-6 col-lg-4">
                                        <div class="featured-thumb hover-zoomer mb-4">
                                            <div class="overlay-black overflow-hidden position-relative"> <img src="admin/property/<?php echo $row['18'];?>" alt="pimage">
                                                <div class="featured bg-success text-white">New</div>
                                                <div class="sale bg-success text-white text-capitalize">For <?php echo $row['5'];?></div>
                                                <div class="price text-primary"><b>$<?php echo $row['13'];?> </b><span class="text-white"><?php echo $row['12'];?> Sqft</span></div>
                                            </div>
                                            <div class="featured-thumb-data shadow-one">
                                                <div class="p-3">
                                                    <h5 class="text-secondary hover-text-success mb-2 text-capitalize"><a href="propertydetail.php?pid=<?php echo $row['0'];?>"><?php echo $row['1'];?></a></h5>
                                                    <span class="location text-capitalize"><i class="fas fa-map-marker-alt text-success"></i> <?php echo $row['14'];?></span> </div>
                                                <div class=" quantity px-4 pt-4">
                                                    <ul>
                                                        <li><span><?php echo $row['12'];?></span> Sqft</li>
                                                        <li><span><?php echo $row['6'];?></span> Beds</li>
                                                        <li><span><?php echo $row['7'];?></span> Baths</li>
                                                        <li><span><?php echo $row['9'];?></span> Kitchen</li>
                                                        <li><span><?php echo $row['8'];?></span> Balcony</li>
                                                        
                                                    </ul>
                                                </div>
                                                <div class="p-4 d-inline-block w-100">
                                                    <div class="float-left text-capitalize"><i class="fas fa-user text-success mr-1"></i>By : <?php echo $row['uname'];?></div>
                                                    <div class="float-right"><i class="far fa-calendar-alt text-success mr-1"></i> <?php echo date('d-m-Y', strtotime($row['date']));?></div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<?php } ?>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="row">
                            <?php 
                            $query = mysqli_query($con, "SELECT property.*, user.uname, user.utype, user.uimage FROM `property`, `user` WHERE property.uid = user.uid AND property.isFeatured = 1 ORDER BY date DESC LIMIT 9");
                            while ($row = mysqli_fetch_array($query)) {
                            ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="featured-thumb hover-zoomer mb-4">
                                    <div class="overlay-black overflow-hidden position-relative"> <img src="admin/property/<?php echo $row['pimage'];?>" alt="pimage">
                                        <div class="featured bg-success text-white">Featured</div>
                                        <div class="sale bg-success text-white text-capitalize">For <?php echo $row['stype'];?></div>
                                        <div class="price text-primary"><b>$<?php echo $row['price'];?> </b><span class="text-white"><?php echo $row['size'];?> Sqft</span></div>
                                    </div>
                                    <div class="featured-thumb-data shadow-one">
                                        <div class="p-3">
                                            <h5 class="text-secondary hover-text-success mb-2 text-capitalize"><a href="propertydetail.php?pid=<?php echo $row['pid'];?>"><?php echo $row['title'];?></a></h5>
                                            <span class="location text-capitalize"><i class="fas fa-map-marker-alt text-success"></i> <?php echo $row['location'];?></span>
                                        </div>
                                        <div class="quantity px-4 pt-4">
                                            <ul>
                                                <li><span><?php echo $row['size'];?></span> Sqft</li>
                                                <li><span><?php echo $row['bedroom'];?></span> Beds</li>
                                                <li><span><?php echo $row['bathroom'];?></span> Baths</li>
                                                <li><span><?php echo $row['kitchen'];?></span> Kitchen</li>
                                                <li><span><?php echo $row['balcony'];?></span> Balcony</li>
                                            </ul>
                                        </div>
                                        <div class="p-4 d-inline-block w-100">
                                            <div class="float-left text-capitalize"><i class="fas fa-user text-success mr-1"></i>By : <?php echo $row['uname'];?></div>
                                            <div class="float-right"><i class="far fa-calendar-alt text-success mr-1"></i> <?php echo date('d-m-Y', strtotime($row['date']));?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab2">
                        <div class="row">
                            <?php 
                            $query = mysqli_query($con, "SELECT property.*, user.uname, user.utype, user.uimage FROM `property`, `user` WHERE property.uid = user.uid AND property.stype = 'sale' ORDER BY date DESC LIMIT 9");
                            while ($row = mysqli_fetch_array($query)) {
                            ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="featured-thumb hover-zoomer mb-4">
                                    <div class="overlay-black overflow-hidden position-relative"> <img src="admin/property/<?php echo $row['pimage'];?>" alt="pimage">
                                        <div class="featured bg-success text-white">Top Sale</div>
                                        <div class="sale bg-success text-white text-capitalize">For <?php echo $row['stype'];?></div>
                                        <div class="price text-primary"><b>$<?php echo $row['price'];?> </b><span class="text-white"><?php echo $row['size'];?> Sqft</span></div>
                                    </div>
                                    <div class="featured-thumb-data shadow-one">
                                        <div class="p-3">
                                            <h5 class="text-secondary hover-text-success mb-2 text-capitalize"><a href="propertydetail.php?pid=<?php echo $row['pid'];?>"><?php echo $row['title'];?></a></h5>
                                            <span class="location text-capitalize"><i class="fas fa-map-marker-alt text-success"></i> <?php echo $row['location'];?></span>
                                        </div>
                                        <div class="quantity px-4 pt-4">
                                            <ul>
                                                <li><span><?php echo $row['size'];?></span> Sqft</li>
                                                <li><span><?php echo $row['bedroom'];?></span> Beds</li>
                                                <li><span><?php echo $row['bathroom'];?></span> Baths</li>
                                                <li><span><?php echo $row['kitchen'];?></span> Kitchen</li>
                                                <li><span><?php echo $row['balcony'];?></span> Balcony</li>
                                            </ul>
                                        </div>
                                        <div class="p-4 d-inline-block w-100">
                                            <div class="float-left text-capitalize"><i class="fas fa-user text-success mr-1"></i>By : <?php echo $row['uname'];?></div>
                                            <div class="float-right"><i class="far fa-calendar-alt text-success mr-1"></i> <?php echo date('d-m-Y', strtotime($row['date']));?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-resturant" role="tabpanel" aria-labelledby="pills-contact-tab3">
                        <div class="row">
                            <?php 
                            $query = mysqli_query($con, "SELECT property.*, user.uname, user.utype, user.uimage FROM `property`, `user` WHERE property.uid = user.uid AND property.stype = 'rent' ORDER BY date DESC LIMIT 9");
                            while ($row = mysqli_fetch_array($query)) {
                            ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="featured-thumb hover-zoomer mb-4">
                                    <div class="overlay-black overflow-hidden position-relative"> <img src="admin/property/<?php echo $row['pimage'];?>" alt="pimage">
                                        <div class="featured bg-success text-white">Best Sale</div>
                                        <div class="sale bg-success text-white text-capitalize">For <?php echo $row['stype'];?></div>
                                        <div class="price text-primary"><b>$<?php echo $row['price'];?> </b><span class="text-white"><?php echo $row['size'];?> Sqft</span></div>
                                    </div>
                                    <div class="featured-thumb-data shadow-one">
                                        <div class="p-3">
                                            <h5 class="text-secondary hover-text-success mb-2 text-capitalize"><a href="propertydetail.php?pid=<?php echo $row['pid'];?>"><?php echo $row['title'];?></a></h5>
                                            <span class="location text-capitalize"><i class="fas fa-map-marker-alt text-success"></i> <?php echo $row['location'];?></span>
                                        </div>
                                        <div class="quantity px-4 pt-4">
                                            <ul>
                                                <li><span><?php echo $row['size'];?></span> Sqft</li>
                                                <li><span><?php echo $row['bedroom'];?></span> Beds</li>
                                                <li><span><?php echo $row['bathroom'];?></span> Baths</li>
                                                <li><span><?php echo $row['kitchen'];?></span> Kitchen</li>
                                                <li><span><?php echo $row['balcony'];?></span> Balcony</li>
                                            </ul>
                                        </div>
                                        <div class="p-4 d-inline-block w-100">
                                            <div class="float-left text-capitalize"><i class="fas fa-user text-success mr-1"></i>By : <?php echo $row['uname'];?></div>
                                            <div class="float-right"><i class="far fa-calendar-alt text-success mr-1"></i> <?php echo date('d-m-Y', strtotime($row['date']));?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        
        <!--	Why Choose Us -->
        <div class="full-row living  overlay-secondary-half" style="background-image: url('images/01.jpg'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="living-list pr-4">
                            <h3 class="pb-4 mb-3 text-white">Why Choose Us</h3>
                            <ul>
                                <li class="mb-4 text-white d-flex"> 
									<i class="flaticon-reward flat-medium float-left d-table mr-4 text-success" aria-hidden="true"></i>
									<div class="pl-2">
										<h5 class="mb-3">Top Rated</h5>
										<p>This is a dummy text for filling out spaces. This is just a dummy text for filling out blank spaces.</p>
									</div>
                                </li>
                                <li class="mb-4 text-white d-flex"> 
									<i class="flaticon-real-estate flat-medium float-left d-table mr-4 text-success" aria-hidden="true"></i>
									<div class="pl-2">
										<h5 class="mb-3">Experience Quality</h5>
										<p>This is a dummy text for filling out spaces. This is just a dummy text for filling out blank spaces.</p>
									</div>
                                </li>
                                <li class="mb-4 text-white d-flex"> 
									<i class="flaticon-seller flat-medium float-left d-table mr-4 text-success" aria-hidden="true"></i>
									<div class="pl-2">
										<h5 class="mb-3">Experienced Agents</h5>
										<p>This is a dummy text for filling out spaces. This is just a dummy text for filling out blank spaces.</p>
									</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!--	why choose us -->
		
		<!--	How it work -->
        <div class="full-row">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="text-secondary double-down-line text-center mb-5">How It Work</h2>
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="icon-thumb-one text-center mb-5">
                            <div class="bg-success text-white rounded-circle position-absolute z-index-9">1</div>
                            <div class="left-arrow"><i class="flaticon-investor flat-medium icon-success" aria-hidden="true"></i></div>
                            <h5 class="text-secondary mt-5 mb-4">Discussion</h5>
                            <p>Nascetur cubilia sociosqu aliquet ut elit nascetur nullam duis tincidunt nisl non quisque vestibulum platea ornare ridiculus.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="icon-thumb-one text-center mb-5">
                            <div class="bg-success text-white rounded-circle position-absolute z-index-9">2</div>
                            <div class="left-arrow"><i class="flaticon-search flat-medium icon-success" aria-hidden="true"></i></div>
                            <h5 class="text-secondary mt-5 mb-4">Files Review</h5>
                            <p>Nascetur cubilia sociosqu aliquet ut elit nascetur nullam duis tincidunt nisl non quisque vestibulum platea ornare ridiculus.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="icon-thumb-one text-center mb-5">
                            <div class="bg-success text-white rounded-circle position-absolute z-index-9">3</div>
                            <div><i class="flaticon-handshake flat-medium icon-success" aria-hidden="true"></i></div>
                            <h5 class="text-secondary mt-5 mb-4">Acquire</h5>
                            <p>Nascetur cubilia sociosqu aliquet ut elit nascetur nullam duis tincidunt nisl non quisque vestibulum platea ornare ridiculus.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        

 <!--	How It Work -->
     <!-- Connexion MySQL dans ce fichier -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <style>
        .count-num { font-size: 2rem; font-weight: bold; }
        .xy-center { top: 50%; left: 50%; transform: translate(-50%, -50%); }
        .position-absolute { position: absolute; }
    </style>
</head>
<body>

<!-- Counter Section -->
<div class="full-row overlay-secondary" style="background-image: url('images/breadcromb.jpg'); background-size: cover;">
    <div class="container">
        <div class="fact-counter">
            <div class="row text-center text-white">

                <!-- Total Properties -->
                <div class="col-md-3">
                    <i class="flaticon-house flat-large"></i>
                    <?php
                    $res = mysqli_query($con, "SELECT COUNT(pid) FROM property");
                    $total = ($row = mysqli_fetch_array($res)) ? $row[0] : 0;
                    ?>
                    <div class="count-num text-success my-4" data-speed="2000" data-stop="<?= $total ?>">0</div>
                    <div class="h5">Property Available</div>
                </div>

                <!-- Sale Properties -->
                <div class="col-md-3">
                    <i class="flaticon-house flat-large"></i>
                    <?php
                    $res = mysqli_query($con, "SELECT COUNT(pid) FROM property WHERE stype='sale'");
                    $total = ($row = mysqli_fetch_array($res)) ? $row[0] : 0;
                    ?>
                    <div class="count-num text-success my-4" data-speed="2000" data-stop="<?= $total ?>">0</div>
                    <div class="h5">Sale Property Available</div>
                </div>

                <!-- Rent Properties -->
                <div class="col-md-3">
                    <i class="flaticon-house flat-large"></i>
                    <?php
                    $res = mysqli_query($con, "SELECT COUNT(pid) FROM property WHERE stype='rent'");
                    $total = ($row = mysqli_fetch_array($res)) ? $row[0] : 0;
                    ?>
                    <div class="count-num text-success my-4" data-speed="2000" data-stop="<?= $total ?>">0</div>
                    <div class="h5">Rent Property Available</div>
                </div>

                <!-- Registered Users -->
                <div class="col-md-3">
                    <i class="flaticon-man flat-large"></i>
                    <?php
                    $res = mysqli_query($con, "SELECT COUNT(uid) FROM user");
                    $total = ($row = mysqli_fetch_array($res)) ? $row[0] : 0;
                    ?>
                    <div class="count-num text-success my-4" data-speed="2000" data-stop="<?= $total ?>">0</div>
                    <div class="h5">Registered Users</div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Animation Script -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const counters = document.querySelectorAll('.count-num');

    const animateCounter = (counter) => {
        const target = +counter.getAttribute('data-stop');
        const speed = +counter.getAttribute('data-speed');
        const increment = Math.max(1, Math.ceil(target / (speed / 16))); // éviter 0

        let current = 0;
        const count = () => {
            current += increment;
            if (current >= target) {
                counter.textContent = target;
            } else {
                counter.textContent = current;
                requestAnimationFrame(count);
            }
        };
        count();
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => observer.observe(counter));
});
</script>

  <!-- #region -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrousel de Témoignages</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
   
</head>
<body>
   <div class="full-row">
  <div class="container">
    <div class="testimonial-section">
      <h4 class="text-secondary pb-4 mb-4">Témoignages</h4>

      <div id="testimonialCarousel" class="position-relative">
        <button class="pause-play-btn" id="pausePlayBtn">
          <i class="fas fa-pause"></i>
        </button>

        <?php
        $query = mysqli_query($con, "SELECT feedback.*, user.uname, user.utype FROM feedback JOIN user ON feedback.uid = user.uid WHERE feedback.status = '1'");
        if (mysqli_num_rows($query) > 0) {
            $i = 0;
            while ($row = mysqli_fetch_array($query)) {
                ?>
                <div class="testimonial-slide <?= $i === 0 ? 'active' : '' ?>">
                  <div class="testimonial-bubble">
                    <i class="fas fa-quote-left quote-left"></i>
                    <p class="testimonial-text"><?= htmlspecialchars($row['fdescription']) ?></p>
                    <i class="fas fa-quote-right quote-right"></i>
                  </div>
                  <div class="testimonial-author">
                    <div class="author-name"><?= htmlspecialchars($row['uname']) ?></div>
                    <div class="author-type"><?= htmlspecialchars($row['utype']) ?></div>
                  </div>
                </div>
                <?php
                $i++;
            }
        } else {
            echo "<div class='no-testimonials'>Aucun témoignage disponible.</div>";
        }
        ?>
      </div>

      <div class="carousel-controls" id="carouselControls">
        <button class="carousel-btn" id="prevBtn"><i class="fas fa-chevron-left"></i></button>
        <div class="carousel-indicators" id="indicators"></div>
        <button class="carousel-btn" id="nextBtn"><i class="fas fa-chevron-right"></i></button>
      </div>

      <div class="progress-bar-container">
        <div class="progress-bar-fill" id="progressFill"></div>
      </div>
    </div>
  </div>
</div>


    <script>
        class TestimonialCarousel {
            constructor() {
                this.slides = document.querySelectorAll('.testimonial-slide');
                this.nextBtn = document.getElementById('nextBtn');
                this.prevBtn = document.getElementById('prevBtn');
                this.pausePlayBtn = document.getElementById('pausePlayBtn');
                this.progressFill = document.getElementById('progressFill');
                this.indicatorsContainer = document.getElementById('indicators');
                
                this.currentSlide = 0;
                this.totalSlides = this.slides.length;
                this.isPlaying = true;
                this.autoSlideInterval = null;
                this.progressInterval = null;
                this.slideTimer = 0;
                this.slideDuration = 4000; // 4 secondes pour chaque témoignage
                
                this.init();
            }
            
            init() {
                if (this.totalSlides === 0) return;
                
                this.createIndicators();
                this.bindEvents();
                this.showSlide(this.currentSlide);
                this.startAutoSlide();
                
                // Navigation clavier
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft') this.prevSlide();
                    if (e.key === 'ArrowRight') this.nextSlide();
                    if (e.key === ' ') {
                        e.preventDefault();
                        this.toggleAutoSlide();
                    }
                });
                
                // Pause au survol
                const carousel = document.getElementById('testimonialCarousel');
                carousel.addEventListener('mouseenter', () => {
                    if (this.isPlaying) this.pauseAutoSlide();
                });
                carousel.addEventListener('mouseleave', () => {
                    if (this.isPlaying) this.startAutoSlide();
                });
            }
            
            createIndicators() {
                this.indicatorsContainer.innerHTML = '';
                for (let i = 0; i < this.totalSlides; i++) {
                    const indicator = document.createElement('div');
                    indicator.className = 'indicator';
                    if (i === 0) indicator.classList.add('active');
                    indicator.addEventListener('click', () => this.goToSlide(i));
                    this.indicatorsContainer.appendChild(indicator);
                }
            }
            
            bindEvents() {
                this.nextBtn.addEventListener('click', () => this.nextSlide());
                this.prevBtn.addEventListener('click', () => this.prevSlide());
                this.pausePlayBtn.addEventListener('click', () => this.toggleAutoSlide());
            }
            
            showSlide(index) {
                // Mettre à jour les slides
                this.slides.forEach((slide, i) => {
                    slide.classList.remove('active');
                    if (i === index) {
                        slide.classList.add('active');
                    }
                });
                
                // Mettre à jour les indicateurs
                const indicators = document.querySelectorAll('.indicator');
                indicators.forEach((indicator, i) => {
                    indicator.classList.toggle('active', i === index);
                });
                
                this.currentSlide = index;
            }
            
            nextSlide() {
                const nextIndex = (this.currentSlide + 1) % this.totalSlides;
                this.goToSlide(nextIndex);
            }
            
            prevSlide() {
                const prevIndex = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
                this.goToSlide(prevIndex);
            }
            
            goToSlide(index) {
                this.showSlide(index);
                this.resetAutoSlide();
            }
            
            startAutoSlide() {
                if (!this.isPlaying || this.totalSlides <= 1) return;
                
                this.slideTimer = 0;
                this.progressFill.style.width = '0%';
                
                this.progressInterval = setInterval(() => {
                    this.slideTimer += 50;
                    const progress = (this.slideTimer / this.slideDuration) * 100;
                    this.progressFill.style.width = `${Math.min(progress, 100)}%`;
                }, 50);
                
                this.autoSlideInterval = setTimeout(() => {
                    this.nextSlide();
                }, this.slideDuration);
            }
            
            pauseAutoSlide() {
                clearTimeout(this.autoSlideInterval);
                clearInterval(this.progressInterval);
            }
            
            resetAutoSlide() {
                this.pauseAutoSlide();
                if (this.isPlaying) {
                    this.startAutoSlide();
                }
            }
            
            toggleAutoSlide() {
                this.isPlaying = !this.isPlaying;
                const icon = this.pausePlayBtn.querySelector('i');
                
                if (this.isPlaying) {
                    icon.className = 'fas fa-pause';
                    this.startAutoSlide();
                } else {
                    icon.className = 'fas fa-play';
                    this.pauseAutoSlide();
                    this.progressFill.style.width = '0%';
                }
            }
        }
        
        // Initialiser le carrousel
        document.addEventListener('DOMContentLoaded', () => {
            const slides = document.querySelectorAll('.testimonial-slide');
            if (slides.length > 0) {
                new TestimonialCarousel();
            } else {
                // Masquer les contrôles s'il n'y a pas de témoignages
                const controls = document.getElementById('carouselControls');
                const progressBar = document.getElementById('progressBarContainer');
                const pauseBtn = document.getElementById('pausePlayBtn');
                
                if (controls) controls.style.display = 'none';
                if (progressBar) progressBar.style.display = 'none';
                if (pauseBtn) pauseBtn.style.display = 'none';
            }
        });
    </script>
</body>
</html>
</body>
</html>
</head>
<body>
    
<!-- Footer -->
<?php include("include/footer.php"); ?>

<!-- Scroll to top -->
<a href="#" class="bg-success text-white hover-text-secondary" id="scroll"><i class="fas fa-angle-up"></i></a>

<!-- Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/wow.min.js"></script>
<script>
    $(document).ready(function () {
        new WOW().init();

        $('.count-num').each(function () {
            var $this = $(this),
                countTo = $this.attr('data-stop'),
                speed = parseInt($this.attr('data-speed'));

            $({ countNum: $this.text() }).animate({
                countNum: countTo
            }, {
                duration: speed,
                easing: 'swing',
                step: function () {
                    $this.text(Math.floor(this.countNum));
                },
                complete: function () {
                    $this.text(this.countNum);
                }
            });
        });
    });
</script>


<!--	Testimonial -->

		
      
		<!--	Footer   start-->
        
        
        <!-- Scroll to top --> 
        <a href="#" class="bg-success text-white hover-text-secondary" id="scroll"><i class="fas fa-angle-up"></i></a> 
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
<script src="js/YouTubePopUp.jquery.js"></script> 
<script src="js/validate.js"></script> 
<script src="js/jquery.cookie.js"></script> 
<script src="js/custom.js"></script>
<script type="text/javascript" src="dark.js" defer></script>
<script type="text/javascript" src="include/dark.js" defer></script>

<!-- Bootstrap JS + jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>


