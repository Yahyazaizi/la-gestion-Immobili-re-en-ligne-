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

<!-- < id="page-wrapper"> -->
    <div class="row"> 
        <!-- Header -->
        <?php include("include/header.php"); ?>
        <!-- Header end -->

        <!-- Banner -->
        <div class="banner-full-row page-banner" style="background-image:url('images/breadcromb.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="page-name float-left text-white text-uppercase mt-1 mb-0"><b>society</b></h2>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="breadcrumb" class="float-left float-md-right">
                            <ol class="breadcrumb bg-transparent m-0 p-0">
                                <li class="breadcrumb-item text-white"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">society</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner end -->

        <div class="full-row">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="text-secondary double-down-line text-center mb-5">Agents</h2>
                <p class="text-center">Découvrez nos agents immobiliers experts prêts à vous aider dans vos transactions immobilières. Cliquez sur un agent pour en savoir plus sur son expérience et ses compétences.</p>
            </div>
        </div>
        <div class="row ">
            <?php 
                // Connexion à la base de données
              

                // Vérifiez si la connexion a réussi
                if (!$con) {
                    die("Échec de la connexion : " . mysqli_connect_error());
                }

                // Requête pour sélectionner les agents avec les champs nécessaires
                $query = mysqli_query($con, "SELECT uid, uname, uphone, uemail, uimage FROM user WHERE utype='agent'");

                // Vérifiez si la requête a été exécutée avec succès
                if ($query) {
                    // Comptez le nombre d'agents
                    $agentCount = mysqli_num_rows($query);
                    if ($agentCount > 0) {
                        while ($row = mysqli_fetch_assoc($query)) { 
                            // Gestion des données de l'agent
                            $agentImage = !empty($row['uimage']) ? 'admin/user/' . htmlspecialchars($row['uimage']) : 'admin/user/user-profile-min.png';
                            $agentName = !empty($row['uname']) ? htmlspecialchars($row['uname']) : 'Nom inconnu';
                            $phoneNumber = !empty($row['uphone']) ? htmlspecialchars($row['uphone']) : 'Non disponible';
                            $email = !empty($row['uemail']) ? htmlspecialchars($row['uemail']) : 'Non disponible';
            ?>
            <div class="col-md-6 col-lg-4 ">
                <div class="hover-zoomer  shadow-one mb-4">
                    <div class="overflow-hidden ">
                        <img src="<?php echo $agentImage; ?>" alt="Image de l'agent" class="img-fluid">
                    </div>
                    <div class="py-3 text-center">
                        <h5 class="text-secondary hover-text-success">
                            <a href="profile.php?id=<?php echo $row['uid']; ?>"><?php echo $agentName; ?> </a>
                        </h5>
                        <span>Agent Immobilier</span>
                        <div class="mt-2">
                            <p><i class="fas fa-phone"></i> <?php echo $phoneNumber; ?></p>
                            <p><i class="fas fa-envelope"></i> <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
                        </div>
                        <div class="mt-3">
                            <a href="propertydetailagent.php?id=<?php echo $row['uid']; ?>"class="btn btn-primary">Voir les Propriétés</a>
                            

                        </div>
                    </div>
                </div>
            </div>
            <?php 
                        } 
                    } else {
                        echo "<div class='col-lg-12'><p class='text-danger'>Aucun agent trouvé.</p></div>";
                    }
                } else {
                    echo "<div class='col-lg-12'><p class='text-danger'>Erreur lors de la récupération des agents : " . mysqli_error($con) . "</p></div>";
                }

                // Fermez la connexion à la base de données
                mysqli_close($con);
            ?>
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
</>
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