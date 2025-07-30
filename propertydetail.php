<?php 
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("config.php");

$error = "";
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    if (!empty($name) && !empty($email) && !empty($phone) && !empty($message)) {
        $stmt = $con->prepare("INSERT INTO messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $message);
        if ($stmt->execute()) {
            $msg = "<p class='alert alert-success'>Message sent successfully!</p>";
        } else {
            $error = "<p class='alert alert-warning'>Failed to send message. Please try again later.</p>";
        }
        $stmt->close();
    } else {
        $error = "<p class='alert alert-warning'>Please fill in all the fields!</p>";
    }
}
?>
<style>
.carousel-item img {
    object-fit: cover;
    height: 500px; /* Hauteur fixe pour uniformiser */
    width: 100%;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    transition: transform 0.5s ease;
}

.carousel-item img:hover {
    transform: scale(1.02);
}

.carousel-inner {
    border-radius: 10px;
    overflow: hidden;
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

<!--	Title
	=========================================================-->
<title>Real Estate PHP</title>
</head>

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
        
        <!--	Banner   --->
        <div class="banner-full-row page-banner" style="background-image:url('images/breadcromb.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="page-name float-left text-white text-uppercase mt-1 mb-0"><b>Property Detail</b></h2>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="breadcrumb" class="float-left float-md-right">
                            <ol class="breadcrumb bg-transparent m-0 p-0">
                                <li class="breadcrumb-item text-white"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Property Detail</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        
         <!--	Banner   --->

		
        <div class="full-row">
            <div class="container">
                <div class="row">
				
					<?php
						$id=$_REQUEST['pid']; 
						$query=mysqli_query($con,"SELECT property.*, user.* FROM `property`,`user` WHERE property.uid=user.uid and pid='$id'");
						while($row=mysqli_fetch_array($query))
						{
					  ?>
				  
                    <div class="col-lg-8">

    <?php
$images = [];
for($i = 18; $i <= 22; $i++) {
    if(!empty($row[$i])) {
        $imagePath = "admin/property/" . $row[$i];
        if(file_exists($imagePath)) {
            $images[] = $imagePath;
        }
    }
}
?>
<div class="col-md-12">
    <?php if(!empty($images)): ?>
    <div id="propertyCarousel" class="carousel slide property-slider" data-ride="carousel">
        <div class="carousel-inner">
            <?php foreach($images as $index => $image): ?>
            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                <div class="zoom-container">
                    <img src="<?php echo $image; ?>" class="d-block w-100 zoom-img" alt="Property Image <?php echo $index + 1; ?>">
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Contrôles -->
        <a class="carousel-control-prev" href="#propertyCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#propertyCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

        <!-- Indicateurs -->
        <ol class="carousel-indicators">
            <?php foreach($images as $index => $image): ?>
            <li data-target="#propertyCarousel" data-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>"></li>
            <?php endforeach; ?>
        </ol>
    </div>
    <?php else: ?>
    <div class="no-images-placeholder text-center p-4">
        <i class="fas fa-image fa-3x mb-3"></i>
        <h5>No images available for this property</h5>
    </div>
    <?php endif; ?>
</div>

<!-- 🔵 CSS Zoom + Style -->
<style>
.carousel-item img {
    height: 500px;
    object-fit: cover;
    transition: transform 0.6s ease;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
}

.zoom-container {
    overflow: hidden;
    border-radius: 10px;
}

.zoom-container:hover .zoom-img {
    transform: scale(1.1);
}

.carousel-inner {
    border-radius: 10px;
}
</style>

<!-- 🔵 JavaScript (Bootstrap 4/5 compatible) -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var myCarousel = document.querySelector('#propertyCarousel');

    // Vérifie si Bootstrap 5 est utilisé
    if (typeof bootstrap !== "undefined") {
        new bootstrap.Carousel(myCarousel, {
            interval: 3000,
            pause: 'hover',
            ride: 'carousel'
        });
    } else {
        // Bootstrap 4
        $('#propertyCarousel').carousel({
            interval: 3000,
            pause: 'hover'
        });
    }
});
</script>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="bg-success d-table px-3 py-2 rounded text-white text-capitalize">For <?php echo $row['5'];?></div>
                                <h5 class="mt-2 text-secondary text-capitalize"><?php echo $row['1'];?></h5>
                                <span class="mb-sm-20 d-block text-capitalize"><i class="fas fa-map-marker-alt text-success font-12"></i> &nbsp;<?php echo $row['14'];?></span>
							</div>
                            <div class="col-md-6">
                                <div class="text-success text-left h5 my-2 text-md-right">$<?php echo $row['13'];?></div>
                                <div class="text-left text-md-right">Price</div>
                            </div>
                        </div>
                        <div class="property-details">
                            <div class=" property-quantity px-4 pt-4 w-100">
                                <ul>
                                    <li><span class="text-secondary"><?php echo $row['12'];?></span> Sqft</li>
                                    <li><span class="text-secondary"><?php echo $row['6'];?></span> Bedroom</li>
                                    <li><span class="text-secondary"><?php echo $row['7'];?></span> Bathroom</li>
                                    <li><span class="text-secondary"><?php echo $row['8'];?></span> Balcony</li>
                                    <li><span class="text-secondary"><?php echo $row['10'];?></span> Hall</li>
                                    <li><span class="text-secondary"><?php echo $row['9'];?></span> Kitchen</li>
                                </ul>
                            </div>
                            <h4 class="text-secondary my-4">Description</h4>
                            <p><?php echo $row['2'];?></p>
                            
                            <h5 class="mt-5 mb-4 text-secondary">Property Summary</h5>
                            <div  class=" font-14 pb-2">
                                <table class="w-100">
                                    <tbody>
                                        <tr>
                                            <td>BHK :</td>
                                            <td class="text-capitalize"><?php echo $row['4'];?></td>
                                            <td>Property Type :</td>
                                            <td class="text-capitalize"><?php echo $row['3'];?></td>
                                        </tr>
                                        <tr>
                                            <td>Floor :</td>
                                            <td class="text-capitalize"><?php echo $row['11'];?></td>
                                            <td>Total Floor :</td>
                                            <td class="text-capitalize"><?php echo $row['28'];?></td>
                                        </tr>
                                        <tr>
                                            <td>City :</td>
                                            <td class="text-capitalize"><?php echo $row['15'];?></td>
                                            <td>State :</td>
                                            <td class="text-capitalize"><?php echo $row['16'];?></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <h5 class="mt-5 mb-4 text-secondary">Features</h5>
                            <div class="row">
								<?php echo $row['17'];?>
								
                            </div>   
							
                            <h5 class="mt-5 mb-4 text-secondary">Floor Plans</h5>
                            <div class="accordion" id="accordionExample">
                                <button class="bg-gray hover-bg-success hover-text-white text-ordinary py-3 px-4 mb-1 w-100 text-left rounded position-relative" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> Floor Plans </button>
                                <div id="collapseOne" class="collapse show p-4" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <img src="admin/property/<?php echo $row['25'];?>" alt="Not Available"> </div>
                                <button class="bg-gray hover-bg-success hover-text-white text-ordinary py-3 px-4 mb-1 w-100 text-left rounded position-relative collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Basement Floor</button>
                                <div id="collapseTwo" class="collapse p-4" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <img src="admin/property/<?php echo $row['26'];?>" alt="Not Available"> </div>
                                <button class="bg-gray hover-bg-success hover-text-white text-ordinary py-3 px-4 mb-1 w-100 text-left rounded position-relative collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Ground Floor</button>
                                <div id="collapseThree" class="collapse p-4" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <img src="admin/property/<?php echo $row['27'];?>" alt="Not Available"> </div>
                            </div>

                            <h5 class="mt-5 mb-4 text-secondary double-down-line-left position-relative">Contact Agent</h5>
                            <div class="agent-contact pt-60">
                                <div class="row">
                                    <div class="col-sm-4 col-lg-3"> <img src="admin/user/<?php echo $row['uimage']; ?>" alt="" height="200" width="170"> </div>
                                    <div class="col-sm-8 col-lg-9">
                                        <div class="agent-data text-ordinary mt-sm-20">
                                            <h6 class="text-success text-capitalize"><?php echo $row['uname'];?></h6>
                                            <ul class="mb-3">
                                                <li><?php echo $row['uphone'];?></li>
                                                <li><?php echo $row['uemail'];?></li>
                                            </ul>
                                            
                                            <div class="mt-3 text-secondary hover-text-success">
                                                <ul>
                                                    <li class="float-left mr-3"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                                    <li class="float-left mr-3"><a href="#"><i class="fab fa-twitter"></i></a></li>
                                                    <li class="float-left mr-3"><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                                    <li class="float-left mr-3"><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                                    <li class="float-left mr-3"><a href="#"><i class="fas fa-rss"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
					
					<?php } ?>
					
                    <div class="col-lg-4">
                        <h4 class="double-down-line-left text-secondary position-relative pb-4 mb-4 mt-md-50">Send Message</h4>
                        <form method="get" action="request.php">
    <?php
    if (isset($_GET['pid'])) {
        $pid = intval($_GET['pid']);
        $query = mysqli_query($con, "SELECT * FROM property WHERE pid = $pid");

        if ($query && mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query); 

            // Afficher les informations de la propriété
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<p>Prix: " . htmlspecialchars($row['price']) . "</p>";
            
            // Ajouter un champ caché pour l'ID de la propriété dans le formulaire
            echo '<input type="hidden" name="pid" value="' . $pid . '">';
        } else {
            echo "<p>Propriété introuvable.</p>";
        }
    } else {
        echo "<p>ID de propriété non fourni.</p>";
    }
    ?>


   <?php
$q = mysqli_query($con, "SELECT property.*, user.uname, user.utype, user.uimage, user.uphone 
                         FROM property 
                         INNER JOIN user ON property.uid = user.uid 
                         WHERE property.pid = '$id'"); // Ajout de la condition WHERE pour la propriété spécifique

if ($row = mysqli_fetch_assoc($q)) {
    // Vérifier si le numéro de téléphone existe
    if (!empty($row['uphone'])) {
        // Nettoyer le numéro de téléphone (enlever les espaces, tirets, etc.)
        $cleanPhone = preg_replace('/\D/', '', $row['uphone']);
        
        // Préparer le message WhatsApp avec vérification des champs
        $propertyName = !empty($row['title']) ? $row['title'] : 'une propriété';
     
        $propertyPrice = !empty($row['price']) ? '$'.$row['price'] : 'prix sur demande';
        
        $message = "Bonjour ".htmlspecialchars($row['uname']).",\n\n"
                  ."Je suis intéressé par votre propriété: ".htmlspecialchars($propertyName)."\n"
                  
                  ."Prix: ".htmlspecialchars($propertyPrice)."\n\n"
                  ."Pourriez-vous me fournir plus d'informations ?";
        
        $waLink = "https://wa.me/212".$cleanPhone."?text=".urlencode($message);
?>
        <span class="">
            <a href="<?php echo $waLink; ?>" 
               class="btn btn-success btn-sm " 
               target="_blank"
               style="background-color: #25D366;">
               <i class="fab fa-whatsapp mr-1"></i> Contacter sur WhatsApp
            </a>
            
            <button type="submit" class="btn btn-sm btn-success mt-">Envoyer un message</button>
        </span>
       
        
      
<?php 
    } else {
        echo '<div class="text-warning"><i class="fas fa-exclamation-circle"></i> Numéro de téléphone non disponible</div>';
    }
} else {
    echo '<div class="alert alert-warning">Aucune propriété trouvée.</div>';
}
?>
</form>
                        <!-- <?php echo $error; ?><?php echo $msg; ?>
                        <form method="post" action="#">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="phone" class="form-control" placeholder="Enter Phone" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea name="message" class="form-control" placeholder="Enter Message" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-success w-100">Send Message</button>
                                    </div>
                                </div>
                            </div>
                        </form> -->
                        <h4 class="double-down-line-left text-secondary position-relative pb-4 my-4">Instalment Calculator</h4>
                        <form class="d-inline-block w-100" action="calc.php" method="post">
                            <label class="sr-only">Property Amount</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">$</div>
                                </div>
                                <input type="number" class="form-control" name="amount" placeholder="Property Price" required>
                            </div>
                            <label class="sr-only">Month</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                </div>
                                <input type="number" class="form-control" name="month" placeholder="Duration month" required>
                            </div>
                            <label class="sr-only">Interest Rate</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">%</div>
                                </div>
                                <input type="number" class="form-control" name="interest" placeholder="Interest Rate" required>
                            </div>
                            <button type="submit" value="submit" name="calc" class="btn btn-danger mt-4">Calclute Instalment</button>
                        </form>
                        <h4 class="double-down-line-left text-secondary position-relative pb-4 mb-4 mt-5">Featured Property</h4>
                        <ul class="property_list_widget">
							
                            <?php 
                            $query=mysqli_query($con,"SELECT * FROM `property` WHERE isFeatured = 1 ORDER BY date DESC LIMIT 3");
                                    while($row=mysqli_fetch_array($query))
                                    {
                            ?>
                            <li> <img src="admin/property/<?php echo $row['18'];?>" alt="pimage">
                                <h6 class="text-secondary hover-text-success text-capitalize"><a href="propertydetail.php?pid=<?php echo $row['0'];?>"><?php echo $row['1'];?></a></h6>
                                <span class="font-14"><i class="fas fa-map-marker-alt icon-success icon-small"></i> <?php echo $row['14'];?></span>
                                
                            </li>
                            <?php } ?>

                        </ul>

                        </div>
                      

                        </div>
            </div>
            </div>
         <!--	Footer   start-->
		<?php include("include/footer.php");?>
		<!--	Footer   start-->
        
        
        <!-- Scroll to top --> 
        <a href="#" class="bg-secondary text-white hover-text-secondary" id="scroll"><i class="fas fa-angle-up"></i></a> 
        <!-- End Scroll To top --> 
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var myCarousel = document.querySelector('#propertyCarousel');
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 3000, // 3 secondes entre chaque slide
        pause: 'hover',
        ride: 'carousel',
        wrap: true
    });
});
</script>

                                    
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

</body>

</html>