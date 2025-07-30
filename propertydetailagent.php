<?php 
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
include("config.php");
								
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
<link rel="stylesheet" href="css/stylepropertydetailagent.css">

<!--	Title
	=========================================================-->
<title>Real Estate PHP</title>
</head>
<?php



include('config.php'); // Database connection file

// Get the agent ID from the URL and escape it to prevent SQL injection
$agent_id = htmlspecialchars(mysqli_real_escape_string($con, $_GET['id']));

// Pagination setup
$limit = 6; // Number of properties per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query to fetch all properties posted by the specific agent with pagination
$query = mysqli_query($con, "SELECT * FROM property WHERE uid = '$agent_id' LIMIT $limit OFFSET $offset");

// Fetch the total number of properties for pagination
$count_query = mysqli_query($con, "SELECT COUNT(*) as total FROM property WHERE uid = '$agent_id'");
$total_rows = mysqli_fetch_assoc($count_query)['total'];
$total_pages = ceil($total_rows / $limit);

// Fetch agent details
$agent_query = mysqli_query($con, "SELECT uname FROM user WHERE uid = '$agent_id'");
$agent = mysqli_fetch_array($agent_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Browse all properties listed by agent <?php echo $agent['uname']; ?>. Find the best properties in your preferred location.">
    <title>Agent Properties - <?php echo $agent['uname']; ?></title>

    <!-- Bootstrap CSS via CDN for better performance -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your custom CSS file -->
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

    
    
</head>
<body>
     <!-- Header -->
     <?php include("include/header.php"); ?>
        <!-- Header end -->
        <!-- Banner -->
        <div class="banner-full-row page-banner" style="background-image:url('images/breadcromb.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="page-name float-left text-white text-uppercase mt-1 mb-0"><b>Agent</b></h2>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="breadcrumb" class="float-left float-md-right">
                            <ol class="breadcrumb bg-transparent m-0 p-0">
                                <li class="breadcrumb-item text-white"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Agent</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner end -->

<div class="container">
    <h2>Properties by Agent: <?php echo $agent['uname']; ?></h2>

    <div class="row">
        <?php
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_array($query)) {
        ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="property-box">
                    <img src="admin/property/<?php echo $row['pimage1']; ?>" alt="Image of <?php echo $row['title']; ?>" class="img-fluid" loading="lazy">
                    <h5><?php echo $row['title']; ?></h5>
                    <p>Price: $<?php echo $row['price']; ?></p>
                    <p>Location: <?php echo $row['location']; ?></p>
                    <a href="propertydetail.php?pid=<?php echo $row['pid']; ?>" class="btn btn-success" aria-label="View details of property titled <?php echo $row['title']; ?>">View Details</a>
                </div>
            </div>
        <?php
            }
        } else {
            echo "<p>No properties found for this agent. Please try again later or contact the agent for more information.</p>";
        }
        ?>
    </div>

    <!-- Pagination links -->
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item">
                    <a class="page-link" href="propertydetailagent.php?id=<?php echo $agent_id; ?>&page=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>


<?php include("include/footer.php");?>
		<!--	Footer   start-->


        <!-- Scroll to top --> 
        <a href="#" class="bg-secondary text-white hover-text-secondary" id="scroll"><i class="fas fa-angle-up"></i></a> 
        <!-- End Scroll To top --> 
    </div>
</div>
<!-- jQuery and Bootstrap JS via CDN for better performance -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

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
